<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:18 AM
 */
class Employee extends CI_Controller
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
        if ($data['is_logged_in'] != 1){
//            $this->session->set_flashdata('login_error', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url());
        }

    }

    public function get_session_data(){
        // remember use xss_clean
        if($this->session->userdata('is_logged_in') == 1){
            // if a session already exist
            // pass the session data to $data, this will be passed when rendering views
            $data['session_username'] = xss_clean($this->session->userdata('session_username'));
            $data['session_user_id'] = xss_clean($this->session->userdata('session_user_id'));
            $data['session_is_admin'] = xss_clean($this->session->userdata('session_is_admin'));
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
        // this shows the list of the employees in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Employee';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('c.id = e.company_id');
//        $this->db->order_by('l.name, f.name asc');
        $data['records'] = $this->db->get()->result();

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

        $this->parser->parse('employees/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function employee_update_form(){
        // this shows the form for updating an employee

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Employee';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('3');

        $query = $this->db->get_where('employees', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->select('c.*');
        $this->db->from('companies c');
//        $this->db->where('');
        $this->db->order_by('c.name asc');
        $data['companies'] = $this->db->get()->result();

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
        foreach($this->db->get()->result() as $second_sub_location) {
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

        $this->load->view('employees/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function employee_update(){
        // this updates a employee in the database

        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'employee');
        }

        $this->load->model('Employee_model');

        $locs = $this->input->post('location_id', TRUE);
        $locs_id = explode(',',$locs);
        $location_id = $locs_id[0];
        $first_sub_location_id = $locs_id[1];
        $second_sub_location_id = $locs_id[2];

        $is_working = ($this->input->post('is_working') != null) ? 1 : 0;
        $data = [
            'name' => $this->input->post('name', TRUE),
            'company_id' => $this->input->post('company_id', TRUE),
            'is_working' => $is_working,
            'location_id' => $location_id,
            'first_sub_location_id' => $first_sub_location_id,
            'second_sub_location_id' => $second_sub_location_id
        ];
        $id = $this->uri->segment('4');

        if ($this->Employee_model->update($data, $id)) {
            //success updating data
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Changes saved!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'employee/detail/'.$id);
        } else {
            //show errors
        }
    }

    public function detail(){
        // this shows the employee detail page
        // showing employee information with all the items the employee is currently holding

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Employee';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('3');

        $this->db->select('e.*, c.name as company_name');
        $this->db->from('companies c');
        $this->db->where('c.id = e.company_id');
        $query = $this->db->get_where('employees e', array('e.id' => $id));
//        $this->db->order_by('l.name, f.name asc');
        $data['record'] = $query->result()[0];

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

        //get list of item this employee hold
        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id, 
                            e.company_id as employee_company_id, 
                            0 as assembled');
        $this->db->from('item_types it, brands b, models m, employees e');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id AND assembled_item_id = 0');
        $query = $this->db->get_where('items i', array('i.employee_id' => $id));
        $result1 = $query->result();

        $this->db->select('ai.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name, 
                            e.name as employee_name, e.location_id as employee_location_id, 
                            e.first_sub_location_id as employee_first_sub_location_id, 
                            e.second_sub_location_id as employee_second_sub_location_id, 
                            e.company_id as employee_company_id,
                            1 as assembled');
        $this->db->from('item_types it, brands b, employees e');
        $this->db->where('ai.brand_id = b.id AND b.item_type_id = it.id AND
                          ai.employee_id = e.id');
        $query = $this->db->get_where('assembled_items ai', array('ai.employee_id' => $id));
        $result2 = $query->result();

//        foreach($result2 as $entry){
//            $entry->assembled = 1; //mark this record as an assembled item, so we can redirect correctly
//        }

        $data['items'] = array_merge($result1, $result2);
        // for debugging purposes
//        echo sizeof($result1);
//        echo '<br/>';
//        echo sizeof($result2);
//        echo '<br/>';
//        echo json_encode($data['items']);


        $this->db->reset_query();
        $this->db->select('e.*, c.name as company_name');
        $this->db->from('employees e, companies c');
        $this->db->where('e.company_id = c.id');
        $this->db->order_by('e.name asc');
        foreach($this->db->get()->result() as $employee){
            $data['employees'][$employee->id] = $employee;
        }
        $this->db->reset_query();
        $this->db->select('ms.* ');
        $this->db->from('mutation_statuses ms');
        $this->db->order_by('ms.name asc');
        foreach($this->db->get()->result() as $ms){
            $data['mutation_statuses'][$ms->id] = $ms;
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

        $this->load->view('employees/detail.php', $data);

        $this->load->view('templates/footer.php', $data);
    }

    public function mutate_multiple_items(){
        $data = $this->get_session_data();
        // check if it's a POST request or not first
        $employee_id = $this->uri->segment('3');
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span> You can\'t do that operation!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url() . 'employee/detail/'.$employee_id);
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

        $employee_id = $this->input->post('employee_id', TRUE);
        $prev_employee_id =$this->input->post('prev_employee_id', TRUE);

        $mutation_date = date("Y-m-d", strtotime($this->input->post('mutation_date', TRUE)));

        $item_ids = $this->input->post('item_ids', TRUE);

//        echo json_encode($item_ids);

        $this->db->trans_start(); # Starting Transaction

        // for every item id
        foreach($item_ids as $item_id){
            $item_info = explode(',',$item_id);
            $id = $item_info[0];
            $assembled = $item_info[1];

            if($assembled == 0){
                // if item is not assembled item,
                // first
                // insert a new mutation
                $data = [
                    'item_id' => $id,
                    'prev_employee_id' => $prev_employee_id,
                    'employee_id' => $employee_id,
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

            } else {
                // if item is assembled item
                // we have to iterate through every items inside as well

                //first insert mutation record for the assembled item
                $data = [
                    'item_id' => $id,
                    'prev_employee_id' => $prev_employee_id,
                    'employee_id' => $employee_id,
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

                // now update the assembled_item with the new employee id and location
                $data2 = [
                    'employee_id' => $this->input->post('employee_id', TRUE),
                    'location_id' => $location_id,
                    'first_sub_location_id' => $first_sub_location_id,
                    'second_sub_location_id' => $second_sub_location_id,
                ];
                $this->load->model('Assembled_item_model');
                $this->Assembled_item_model->update($data2, $id);

                // now insert a mutation record for every item that is part of this assembled item as well
                $this->db->reset_query();
                $this->db->select('i.*');
                $query = $this->db->get_where('items i', array('i.assembled_item_id' => $id));
                $data['items'] = $query->result();

                $this->load->model('Item_model');

                foreach($data['items'] as $item) {
                    // loop for each item in the assembled item
                    // insert a mutation record
                    $data = [
                        'item_id' => $item->id,
                        'prev_employee_id' => $prev_employee_id,
                        'employee_id' => $employee_id,
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
                    // insert the mutation record
                    $this->Mutation_model->insert($data);

                    // update the item holder information
                    $data2 = [
                        'employee_id' => $this->input->post('employee_id', TRUE),
                        'location_id' => $location_id,
                        'first_sub_location_id' => $first_sub_location_id,
                        'second_sub_location_id' => $second_sub_location_id,
                    ];
                    $this->Item_model->update($data2, $item->id);
                }
            }
        }

        if ($this->db->trans_complete()) {
            //Transaction succeeded! Both query is successfully executed
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info"></span> Mutation success!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url() . 'employee/detail/'.$employee_id);
        } else {
            //show errors
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-warning"></span>An error occured!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url() . 'employee/mutate/'.$employee_id);
        }


    }
}