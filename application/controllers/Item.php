<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:18 AM
 */
class Item extends CI_Controller
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
        $item_id = $this->uri->segment('3') ?: 0;
        if($item_id == 0){
            $item_id = $this->uri->segment('4') ?: 0;
        }

        if ($section == 'new' && $data['permission_item_insert'] == 1) {
            // this user is trying to insert new item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'edit' && $data['permission_item_edit'] == 1)  {
            // this user is trying to edit item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'delete' && $data['permission_item_delete'] == 1)  {
            // this user is trying to delete item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'mutate' && $data['permission_item_mutate'] == 1)  {
            // this user is trying to mutate item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'power-edit' && $data['permission_item_power_edit'] == 1)  {
            // this user is trying to power-edit item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'delete-mutation' && $data['permission_mutation_delete'] == 1)  {
            // this user is trying to delete mutation of item, and has the appropriate permission
            // do nothing
        } elseif ($section == 'detail')  {
            // this user is trying to access item detail, no permission needed
            // do nothing
        } elseif ($section == '')  {
            // this user is trying to access item index, no permission needed
            // do nothing
        } else {
            // else, restrict access
            $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            if($item_id != 0){
                redirect(base_url().'item/detail/'.$item_id);
            }
            redirect(base_url().'item');
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

    public function get_max_id(){
        //this function get the current highest id of either assembled_item_id and item_id
        $this->db->select('max(i.id) as max_item_id');
        $this->db->from('items i');
        $result = $this->db->get()->result();
        $max_item_id = $result[0]->max_item_id;

        $this->db->select('max(i.id) as max_a_item_id');
        $this->db->from('assembled_items i');
        $result = $this->db->get()->result();
        $max_a_item_id = $result[0]->max_a_item_id;

        //return whichever is larger
        if($max_item_id > $max_a_item_id){
            return $max_item_id;
        } else {
            return $max_a_item_id;
        }
    }
    public function index()
    {
        // item index page
        // just show table of every item sort by id

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $this->parser->parse('templates/header.php', $data);

        // parse the content of this route here!

        // for mutation limits
        $from = date("Y-m-d", strtotime($this->input->post("date_start", TRUE)));
        $to = date("Y-m-d", strtotime($this->input->post("date_end", TRUE)));
        $limit = $this->input->post("limit", TRUE) ?: 100;
        $company_id = $this->input->post("company_id", TRUE) ?: 0;
        $model_id = $this->input->post("model_id", TRUE) ?: 0;

        $date_start = $this->input->post("date_start", TRUE);
        $date_end = $this->input->post("date_end", TRUE);

        if ($to == "1970-01-01") {
            $to = "2300-12-31";
        }
        if ($limit == 0) {
            $limit = 100;
        }

        // get location ids
        $locs = $this->input->post('location_id', TRUE) ?: '0,0,0';
        $locs_id = explode(',', $locs);
        $location_id = $locs_id[0];
        $first_sub_location_id = $locs_id[1];
        $second_sub_location_id = $locs_id[2];

        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        $data['limit'] = $limit;
        $data['company_id'] = $company_id;
        $data['model_id'] = $model_id;
        $data['location_id'] = $location_id;
        $data['first_sub_location_id'] = $first_sub_location_id;
        $data['second_sub_location_id'] = $second_sub_location_id;



        $sql = "SELECT 
                    i.*, it.name as item_type_name, it.id as item_type_id, 
                    b.name as brand_name, m.name as model_name, 
                    e.name as employee_name, e.location_id as employee_location_id, 
                    e.first_sub_location_id as employee_first_sub_location_id, 
                    e.second_sub_location_id as employee_second_sub_location_id, 
                    e.company_id as employee_company_id
                FROM items i, item_types it, brands b, models m, employees e
                WHERE i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND 
                      i.employee_id = e.id AND i.assembled_item_id = 0 AND 
                      i.date_of_purchase BETWEEN '$from' AND '$to' ";

        if($company_id != 0){
            $sql .= " AND i.company_id = $company_id";
        }
        if($model_id != 0){
            $sql .= " AND i.model_id = $model_id";
        }
        if($location_id != 0){
            $sql .= " AND i.location_id = $location_id";
        }
        if($first_sub_location_id != 0){
            $sql .= " AND i.first_sub_location_id = $first_sub_location_id";
        }
        if($second_sub_location_id != 0){
            $sql .= " AND i.second_sub_location_id = $second_sub_location_id";
        }


        $sql .= " ORDER BY i.id desc";
        $sql .= " LIMIT 0, $limit";

        $query = $this->db->query($sql);
        $data['records'] = $query->result();

        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

//        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id,
//                            b.name as brand_name, m.name as model_name,
//                            e.name as employee_name, e.location_id as location_id,
//                            e.first_sub_location_id as first_sub_location_id,
//                            e.second_sub_location_id as second_sub_location_id,
//                            e.company_id as employee_company_id');
//        $this->db->from('items i, item_types it, brands b, models m, employees e');
//        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
//                          i.employee_id = e.id AND assembled_item_id = 0');
////        $this->db->order_by('l.name, f.name asc');
//        $data['records'] = $this->db->get()->result();

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }

        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        $this->db->order_by('l.name asc');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        $this->db->order_by('f.name asc');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->parser->parse('items/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }

    public function item_insert_form(){
        // this shows the form for inserting a new mutation status

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $this->parser->parse('templates/header.php', $data);

        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('suppliers s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $supplier){
            $data['suppliers'][$supplier->id] = $supplier;
        }

        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        $this->db->order_by('os.name asc');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        $this->db->order_by('c.name asc');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }
        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        $this->db->order_by('l.name asc');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        $this->db->order_by('f.name asc');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->parser->parse('items/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function item_insert(){
        // this insert a new item to the database

        // check if it's a POST request or not first
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'item');
        }
        $id_to_insert = $this->get_max_id()+1;
        $is_used = ($this->input->post('is_used') != null) ? '1' : '0';
        $this->load->model('Item_model');
        $date_of_purchase = date("Y-m-d", strtotime($this->input->post('date_of_purchase', TRUE)));
        $warranty_expiry_date = date("Y-m-d", strtotime($this->input->post('warranty_expiry_date', TRUE)));

        // get location ids
        $locs = $this->input->post('location_id', TRUE);
        $locs_id = explode(',',$locs);
        $location_id = $locs_id[0];
        $first_sub_location_id = $locs_id[1];
        $second_sub_location_id = $locs_id[2];

        // final checking to ensure $warranty_expiry_date is not earlier than purchase date
        // in case front end is breached
        if($warranty_expiry_date < $date_of_purchase){
            $warranty_expiry_date = $date_of_purchase;
        }

        $this->db->trans_start(); # Starting Transaction
        // insert a new item
        $data = [
            'id' => $id_to_insert,
            'model_id' => $this->input->post('model_id', TRUE),
            'supplier_id' => $this->input->post('supplier_id', TRUE),
            'company_id' => $this->input->post('company_id', TRUE),
            'operating_system_id' => $this->input->post('operating_system_id', TRUE),
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id,
            'employee_id' => $this->input->post('employee_id', TRUE),
            'is_used' => $is_used,
            'note' => $this->input->post('note', TRUE),
            'date_of_purchase' => $date_of_purchase,
            'warranty_expiry_date' => $warranty_expiry_date
        ];
        $this->Item_model->insert($data);

        // insert a new mutation
        $data2 = [
            'item_id' => $id_to_insert,
            'employee_id' => $this->input->post('employee_id', TRUE),
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id,
            'note' => 'First item assignment',
            'mutation_date' => $date_of_purchase
        ];
        // insert mutation data to db
        $this->load->model('Mutation_model');
        $this->Mutation_model->insert($data2);

        if ($this->db->trans_complete()) {
            //Transaction succeeded! Both query is successfully executed
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Item successfully added!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item/detail/'.$id_to_insert);
        } else {
            //show errors
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span>An error occured!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url() . 'item/new');
        }
    }

    public function insert_100k(){
        // insert a 100k new mutation
        $i = 0;
        while ($i < 100000) {
            $data2 = [
                'item_id' => 13,
                'employee_id' => 2,
                'note' => '100,000 dummy records',
                'mutation_date' => '2017-03-27'
            ];
            // insert mutation data to db
            $this->load->model('Mutation_model');
            $this->Mutation_model->insert($data2);
            $i++;
        }
    }

    public function item_update_form(){
        // this shows the form for inserting a new mutation status

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('3');

        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id');
        $this->db->from('items i, item_types it, brands b, models m, employees e');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id ');

        $query = $this->db->get_where('items', array('i.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('suppliers s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $supplier){
            $data['suppliers'][$supplier->id] = $supplier;
        }

        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        $this->db->order_by('os.name asc');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        $this->db->order_by('c.name asc');
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

        $this->load->view('items/update_form.php', $data);

        $this->load->view('templates/footer.php', $data);
    }

    public function item_update(){
        // this update an item in the database

        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'item');
        }
        $this->load->model('Item_model');

        $id = $this->uri->segment('4');

        $is_used = ($this->input->post('is_used') != null) ? '1' : '0';

        $date_of_purchase = date("Y-m-d", strtotime($this->input->post('date_of_purchase', TRUE)));
        $warranty_expiry_date = date("Y-m-d", strtotime($this->input->post('warranty_expiry_date', TRUE)));

        // final checking to ensure $warranty_expiry_date is not earlier than purchase date
        // in case front end is breached
        if($warranty_expiry_date < $date_of_purchase){
            $warranty_expiry_date = $date_of_purchase;
        }

        $data = [
            'model_id' => $this->input->post('model_id', TRUE),
            'supplier_id' => $this->input->post('supplier_id', TRUE),
            'company_id' => $this->input->post('company_id', TRUE),
            'operating_system_id' => $this->input->post('operating_system_id', TRUE),
            'employee_id' => $this->input->post('employee_id', TRUE),
            'is_used' => $is_used,
            'note' => $this->input->post('note', TRUE),
            'date_of_purchase' => $date_of_purchase,
            'warranty_expiry_date' => $warranty_expiry_date
        ];
        // for debugging purposes
//        echo json_encode($data);

        if ($this->Item_model->update($data, $id)) {
            //success updating data
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Changes saved!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item/detail/'.$id);
        } else {
            //show errors
        }
    }


    public function item_update_form_2(){
        // this shows the form for inserting a new mutation status
        // this allows editing of employee and location directly! for Privileged user only!

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('3');

        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id');
        $this->db->from('items i, item_types it, brands b, models m, employees e');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id ');

        $query = $this->db->get_where('items', array('i.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('suppliers s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $supplier){
            $data['suppliers'][$supplier->id] = $supplier;
        }

        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        $this->db->order_by('os.name asc');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        $this->db->order_by('c.name asc');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }

        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        $this->db->order_by('l.name asc');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        $this->db->order_by('f.name asc');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->load->view('items/update_form_2.php', $data);

        $this->load->view('templates/footer.php', $data);
    }

    public function item_update_2(){
        // this update an item in the database
        // this allows editing of employee and location directly! for Privileged user only!

        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'item');
        }
        $this->load->model('Item_model');

        $id = $this->uri->segment('4');

        $is_used = ($this->input->post('is_used') != null) ? '1' : '0';

        $date_of_purchase = date("Y-m-d", strtotime($this->input->post('date_of_purchase', TRUE)));
        $warranty_expiry_date = date("Y-m-d", strtotime($this->input->post('warranty_expiry_date', TRUE)));

        // final checking to ensure $warranty_expiry_date is not earlier than purchase date
        // in case front end is breached
        if($warranty_expiry_date < $date_of_purchase){
            $warranty_expiry_date = $date_of_purchase;
        }
        // get location ids
        $locs = $this->input->post('location_id', TRUE);
        $locs_id = explode(',',$locs);
        $location_id = $locs_id[0];
        $first_sub_location_id = $locs_id[1];
        $second_sub_location_id = $locs_id[2];

        $data = [
            'model_id' => $this->input->post('model_id', TRUE),
            'supplier_id' => $this->input->post('supplier_id', TRUE),
            'company_id' => $this->input->post('company_id', TRUE),
            'operating_system_id' => $this->input->post('operating_system_id', TRUE),
            'employee_id' => $this->input->post('employee_id', TRUE),
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id,
            'is_used' => $is_used,
            'note' => $this->input->post('note', TRUE),
            'date_of_purchase' => $date_of_purchase,
            'warranty_expiry_date' => $warranty_expiry_date
        ];
        // for debugging purposes
//        echo json_encode($data);

        if ($this->Item_model->update($data, $id)) {
            //success updating data
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Changes saved!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item/detail/'.$id);
        } else {
            //show errors
        }
    }

    public function detail(){
        // this shows the form for inserting a new mutation status

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $id = $this->uri->segment('3');
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            m.capacity_size as model_capacity_size,
                            m.units as model_units, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id,
                            e.company_id as employee_company_id,
                            c.name as company_name, 
                            s.name as supplier_name');
        $this->db->from('items i, item_types it, brands b, models m, employees e, companies c, suppliers s');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id AND i.company_id = c.id AND i.supplier_id = s.id');

        $query = $this->db->get_where('items', array('i.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();

        // for mutation limits
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
                            SELECT mu.*, it.name as item_type_name, it.id as item_type_id, 
                                b.name as brand_name, m.name as model_name,
                                m.capacity_size as model_capacity_size,
                                m.units as model_units, i.operating_system_id as operating_system_id
                            FROM mutations mu, items i, item_types it, brands b, models m 
                            WHERE mu.item_id = i.id AND i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND 
                                  mu.item_id = $id AND mu.mutation_date BETWEEN '$from' AND '$to'
                            ORDER BY mu.mutation_date, mu.id desc
        ");
        $data['mutations'] = $query->result();

        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        $this->db->order_by('ms.name asc');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('suppliers s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $supplier){
            $data['suppliers'][$supplier->id] = $supplier;
        }

        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        $this->db->order_by('os.name asc');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        $this->db->order_by('c.name asc');
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

        $this->load->view('items/detail.php', $data);

        $this->load->view('templates/footer.php', $data);
    }

    public function item_mutate_form(){
        // show the item mutation form
        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item';
        $id = $this->uri->segment('3');
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            m.capacity_size as model_capacity_size,
                            m.units as model_units, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id,
                            e.company_id as employee_company_id,
                            c.name as company_name, 
                            s.name as supplier_name');
        $this->db->from('items i, item_types it, brands b, models m, employees e, companies c, suppliers s');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id AND i.company_id = c.id AND i.supplier_id = s.id');

        $query = $this->db->get_where('items', array('i.id' => $id));
        $data['record'] = $query->result()[0];

        //check the assembled_item_id. if it's not 0, mutations are not allowed
        if($data['record']->assembled_item_id != 0){
            //prevent mutation to items that have parents
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span> You can\'t mutate an item that is part of an assembled item!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'item/detail/'.$id);
        }
        $data['id'] = $id;


        $this->db->reset_query();
        $this->db->select('m.*, b.name as brand_name, it.name as item_type_name ');
        $this->db->from('models m, brands b, item_types it');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = it.id');
        $this->db->order_by('it.name, b.name, m.name asc');
        foreach($this->db->get()->result() as $model){
            $data['models'][$model->id] = $model;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('suppliers s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $supplier){
            $data['suppliers'][$supplier->id] = $supplier;
        }

        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }

        $this->db->reset_query();
        $this->db->select('os.* ');
        $this->db->from('operating_systems os');
        $this->db->order_by('os.name asc');
        foreach($this->db->get()->result() as $os){
            $data['operating_systems'][$os->id] = $os;
        }

        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        $this->db->order_by('ms.name asc');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
        }

        $this->db->reset_query();
        $this->db->select('c.* ');
        $this->db->from('companies c');
        $this->db->order_by('c.name asc');
        foreach($this->db->get()->result() as $company){
            $data['companies'][$company->id] = $company;
        }


        $this->db->reset_query();
        $this->db->select('l.* ');
        $this->db->from('locations l');
        $this->db->order_by('l.name asc');
        foreach($this->db->get()->result() as $location){
            $data['locations'][$location->id] = $location;
        }

        $this->db->reset_query();
        $this->db->select('f.* ');
        $this->db->from('first_sub_locations f');
        $this->db->order_by('f.name asc');
        foreach($this->db->get()->result() as $first_sub_location){
            $data['first_sub_locations'][$first_sub_location->id] = $first_sub_location;
        }

        $this->db->reset_query();
        $this->db->select('s.* ');
        $this->db->from('second_sub_locations s');
        $this->db->order_by('s.name asc');
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }


        $this->load->view('items/mutate_form.php', $data);

        $this->load->view('templates/footer.php', $data);
    }

    public function item_mutate(){
        $data = $this->get_session_data();
        // check if it's a POST request or not first
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'item');
        }

        // get location ids
        $locs = $this->input->post('location_id', TRUE);
        $locs_id = explode(',',$locs);
        $location_id = $locs_id[0];
        $first_sub_location_id = $locs_id[1];
        $second_sub_location_id = $locs_id[2];
        $prev_location_id = $this->input->post('prev_location_id', TRUE);
        $prev_first_sub_location_id = $this->input->post('prev_first_sub_location_id', TRUE);
        $prev_second_sub_location_id = $this->input->post('prev_second_sub_location_id', TRUE);


        $id = $this->uri->segment('4');
        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            m.capacity_size as model_capacity_size,
                            m.units as model_units, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id,
                            e.company_id as employee_company_id,
                            c.name as company_name, 
                            s.name as supplier_name');
        $this->db->from('items i, item_types it, brands b, models m, employees e, companies c, suppliers s');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id AND i.company_id = c.id AND i.supplier_id = s.id');

        $query = $this->db->get_where('items', array('i.id' => $id));
        $data['record'] = $query->result()[0];

        //check the assembled_item_id. if it's not 0, mutations are not allowed
        if($data['record']->assembled_item_id != 0){
            //prevent mutation to items that have parents
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span> You can\'t mutate an item that is part of an assembled item!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'item/detail/'.$id);
        }

        $employee_id = $this->input->post('employee_id', TRUE);
        $prev_employee_id =$this->input->post('prev_employee_id', TRUE);

        if ($employee_id == $prev_employee_id &&
            $location_id == $prev_location_id &&
            $first_sub_location_id == $prev_first_sub_location_id &&
            $second_sub_location_id == $prev_second_sub_location_id){
            //prevents mutation from and to the same employee and location
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span> You can\'t mutate to the same employee and locations! You have to at least mutate to a different employee or location!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'item/mutate/'.$id);
        }

        // we're going to do insert mutation and update item information as a transaction
        // if one fail, we're going to rollback
        $this->db->trans_start(); # Starting Transaction
        // insert a new mutation
        $mutation_date = date("Y-m-d", strtotime($this->input->post('mutation_date', TRUE)));
        $data = [
            'item_id' => $id,
            'prev_employee_id' => $this->input->post('prev_employee_id', TRUE),
            'employee_id' => $this->input->post('employee_id', TRUE),
            'prev_location_id' => $prev_location_id,
            'prev_first_sub_location_id' => $prev_first_sub_location_id,
            'prev_second_sub_location_id' => $prev_second_sub_location_id,
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id,
            'mutation_status_id' => $this->input->post('mutation_status_id', TRUE),
            'note' => $this->input->post('note', TRUE),
            'mutation_date' => $mutation_date
        ];

        // insert mutation data to db
        $this->load->model('Mutation_model');
        $this->Mutation_model->insert($data);

        // now update item with the new employee id and location
        $data2 = [
            'employee_id' => $this->input->post('employee_id', TRUE),
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id,
        ];

        $this->load->model('Item_model');
        $this->Item_model->update($data2, $id);

        if ($this->db->trans_complete()) {
            //Transaction succeeded! Both query is successfully executed
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Mutation success!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item/detail/'.$id);
        } else {
            //show errors
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span>An error occured!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url() . 'item/mutate/'.$id);
        }

    }

    public function item_delete(){
        $data = $this->get_session_data();
        // this should only be accessed by admins,
        // check for admin privileges
        $id = $this->uri->segment('3');
//        if($data['session_is_admin'] == 0) {
//            //not admin!
//            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span> You don\'t have access to do that!');
//            $this->session->set_flashdata('site_wide_msg_type', 'danger');
//            redirect(base_url() . 'item/detail/'.$id);
//        }

        // we reached here, which means this user is indeed admin
        // so we delete the item with the id, and also the mutation records

        // first, delete the item
        $this->db->trans_start(); # Starting Transaction
        $this->load->model('Item_model');
        $this->Item_model->delete($id);

        // then delete the mutation records
        $this->load->model('Mutation_model');
        $this->Mutation_model->delete_where_item_id($id);
        if ($this->db->trans_complete()) {
            //Transaction succeeded! Both query is successfully executed
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Successfully deleted item and its mutation records!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item');
        } else {
            //show errors
            $db_error = $this->db->error();
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span>An error occured! '. $db_error['code']);
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url() . 'item/detail/'.$id);
        }
    }

    public function delete_mutation(){
        $data = $this->get_session_data();

        $id = $this->uri->segment('3');
        $mutation_id = $this->uri->segment('4');

        $this->load->model('Mutation_model');
        if ($this->Mutation_model->delete($mutation_id)) {
            //successfully deleted data
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Successfully deleted mutation record!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'item/detail/'.$id);
        } else {
            //show errors
        }
    }
}