<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:18 AM
 */
class Mutation_history extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); //for base_url()
        $this->load->helper('security'); // for xss_clean()
        $this->load->helper('date'); // for
        // now() returns an unix timestamp, and
        // mdate() take an unix timestamp or a date string, convert to mysql formatted date

        $this->load->library('parser');
        $this->load->library('session');
        $this->load->database();
        $this->output->enable_profiler(FALSE);

        $data = $this->get_session_data();
        $section = $this->uri->segment('2') ?: '';

        if ($section == 'edit' && $data['permission_mutation_edit'] == 1) {
            // this user is trying to edit mutation, and has the appropriate permission
            // do nothing
        } elseif ($section == '')  {
            // this user is trying to access mutation index, no permission needed
            // do nothing
        } else {
            // else, restrict access
            $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'mutation-history');
        }
        if ($data['is_logged_in'] != 1){
//            $this->session->set_flashdata('login_error', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url());
        }

    }

    public function get_session_data(){
        // TODO: use real session data
        // remember use xss_clean
        if($this->session->userdata('is_logged_in') == 1){
            // if a session already exist
            // pass the session data to $data, this will be passed when rendering views
            $data['session_username'] = xss_clean($this->session->userdata('session_username'));
            $data['session_user_id'] = xss_clean($this->session->userdata('session_user_id'));
            $data['session_is_admin'] = xss_clean($this->session->userdata('session_is_admin'));
            $data['permission_master'] = xss_clean($this->session->userdata('permission_master'));
            $data['permission_user_management'] = xss_clean($this->session->userdata('permission_user_management'));
            $data['permission_item_insert'] = xss_clean($this->session->userdata('permission_item_insert'));
            $data['permission_item_edit'] = xss_clean($this->session->userdata('permission_item_edit'));
            $data['permission_item_delete'] = xss_clean($this->session->userdata('permission_item_delete'));
            $data['permission_item_mutate'] = xss_clean($this->session->userdata('permission_item_mutate'));
            $data['permission_item_power_edit'] = xss_clean($this->session->userdata('permission_item_power_edit'));
            $data['permission_company_edit'] = xss_clean($this->session->userdata('permission_company_edit'));
            $data['permission_employee_edit'] = xss_clean($this->session->userdata('permission_employee_edit'));
            $data['permission_mutation_edit'] = xss_clean($this->session->userdata('permission_mutation_edit'));
            $data['permission_mutation_delete'] = xss_clean($this->session->userdata('permission_mutation_delete'));
            $data['is_logged_in'] = 1;
        } else {
            // else set is_logged_in = 0
            $data['is_logged_in'] = 0;
        }
        //get site_wide_msg, if exists
        $data['site_wide_msg'] = $this->session->flashdata('site_wide_msg');
        $data['site_wide_msg_type'] = $this->session->flashdata('site_wide_msg_type');

        return $data;
    }
    public function index(){
        // mutation history index page
        // just show table of every mutations sort by id descending

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Mutation History';
        $this->parser->parse('templates/header.php', $data);

        // parse the content of this route here!
        $from =  date("Y-m-d", strtotime($this->input->post("date_start", TRUE)));
        $to =  date("Y-m-d", strtotime($this->input->post("date_end", TRUE)));
        $limit = $this->input->post("limit", TRUE);

        $date_start = $this->input->post("date_start", TRUE);
        $date_end = $this->input->post("date_end", TRUE);

        if ($to == "1970-01-01"){
            $to = "2300-12-31";
        }
        if ($limit == 0){
            $limit = 100;
        }

        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        $data['limit'] = $limit;

        $query = $this->db->query("
                (
                SELECT mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            i.operating_system_id, '0' as 'assembled' 
                FROM mutations mu, items i, item_types it, brands b, models m
                WHERE mu.item_id = i.id AND i.model_id = m.id AND 
                        m.brand_id = b.id AND b.item_type_id = it.id AND 
                        assembled_item_id = 0 AND 
                        mutation_date BETWEEN '$from' AND '$to' 
                )
                UNION 
                (
                SELECT mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name,
                            ai.operating_system_id as operating_system_id, '1' as 'assembled'
                FROM mutations mu, assembled_items ai, item_types it, brands b
                WHERE mu.item_id = ai.id AND ai.brand_id = b.id AND b.item_type_id = it.id AND 
                        mutation_date BETWEEN '$from' AND '$to'
                )
                ORDER BY mutation_date desc 
                LIMIT 0, $limit
        ");

        $data['records'] = $query->result();
//        echo json_encode($data['records']);

        // for debugging purposes
//        echo sizeof($result1);
//        echo '<br/>';
//        echo sizeof($result2);
//        echo '<br/>';
//        echo json_encode($data['records']);

        $this->db->reset_query();
        $this->db->select('e.* ');
        $this->db->from('employees e');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }
        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->load->view('mutation_histories/index.php', $data);

        $this->load->view('templates/footer.php', $data);
    }
    private function index_backup(){
        // mutation history index page
        // just show table of every mutations sort by id descending

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Mutation History';
        $this->parser->parse('templates/header.php', $data);

        // parse the content of this route here!
        $this->db->select('mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name');
        $this->db->from('mutations mu, items i, item_types it, brands b, models m');
        $this->db->where('mu.item_id = i.id AND i.model_id = m.id AND 
                        m.brand_id = b.id AND b.item_type_id = it.id AND 
                        assembled_item_id = 0'); // only show items that are not part of other assembled item
        $this->db->order_by('mu.id desc');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name,
                            ai.operating_system_id as operating_system_id');

        $this->db->from('mutations mu, assembled_items ai, item_types it, brands b');
        $this->db->where('mu.item_id = ai.id AND ai.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('mu.id desc');
        $query = $this->db->get();
        $result2 = $query->result();
        foreach($result2 as $entry){
            $entry->assembled = 1; //mark this record as an assembled item, so we can redirect correctly
        }

        $data['records'] = array_merge($result1, $result2);

        // for debugging purposes
//        echo sizeof($result1);
//        echo '<br/>';
//        echo sizeof($result2);
//        echo '<br/>';
//        echo json_encode($data['records']);

        $this->db->reset_query();
        $this->db->select('e.* ');
        $this->db->from('employees e');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }
        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->parser->parse('mutation_histories/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }

    public function mutation_history_update_form(){
        // this shows the form for updating a mutation

        $data = $this->get_session_data();

        $id = $this->uri->segment('3');

        $data['title'] = 'ALS - Mutation History';
        $this->parser->parse('templates/header.php', $data);

        // parse the content of this route here!
        $this->db->select('mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            m.capacity_size as model_capacity_size,
                            m.units as model_units, i.operating_system_id as operating_system_id');

        $this->db->from('items i, item_types it, brands b, models m');
        $this->db->where('mu.item_id = i.id AND i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('mu.id desc');
        $query = $this->db->get_where('mutations mu', array('mu.id' => $id));
        $result1 = $query->result();

        $this->db->select('mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name,
                            ai.operating_system_id as operating_system_id');

        $this->db->from('assembled_items ai, item_types it, brands b');
        $this->db->where('mu.item_id = ai.id AND ai.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('mu.id desc');
        $query = $this->db->get_where('mutations mu', array('mu.id' => $id));
        $result2 = $query->result();

        $data['record'] = array_merge($result1, $result2)[0];

        if (sizeof($result1) == 0){
            $data['assembled'] = 1; //used to decide how to link to item detail page assembled-item/detail or item/detail
        } else {
            $data['assembled'] = 0;
        }

        $this->db->reset_query();
        $this->db->select('e.* ');
        $this->db->from('employees e');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
        }
        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }
        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->load->view('mutation_histories/update_form.php', $data);

        $this->load->view('templates/footer.php', $data);

    }

    public function mutation_history_update(){
        // this update an item in the database

        $data = $this->get_session_data();

        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'mutation-history');
        }

        $this->load->model('Mutation_model');

        $id = $this->uri->segment('4');

        $data = [
            'mutation_status_id' => $this->input->post('mutation_status_id', TRUE),
            'note' => $this->input->post('note', TRUE)
        ];

        if ($this->Mutation_model->update($data, $id)) {
            //success updating data
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Successfully edited mutation!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'mutation-history/edit/'.$id);
        } else {
            //show errors
        }
    }

//    public function mutation_history_delete(){
//        // delete mutation from index page
//        $data = $this->get_session_data();
//
//        $id = $this->uri->segment('3');
//
//        $this->load->model('Mutation_model');
//        if ($this->Mutation_model->delete($id)) {
//            //successfully deleted data
//            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Successfully deleted mutation record!');
//            $this->session->set_flashdata('site_wide_msg_type', 'success');
//            redirect(base_url() . 'mutation-history');
//        } else {
//            //show errors
//        }
//
//    }

    function fetch_mutation_history(){
        $this->load->model("Mutation_model");
        $fetch_data = $this->Mutation_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->model_name;
//            $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs">Update</button>';
//            $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->Mutation_model->get_all_data(),
            "recordsFiltered"   => $this->Mutation_model->get_filtered_data(),
            "data"              => $data
        );
        echo json_encode($output);
    }


}