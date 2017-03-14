<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:18 AM
 */
class Master extends CI_Controller
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
        if ($data['session_is_admin'] != 1){
            $this->session->set_flashdata('login_error', 'You don\'t have access to that page');
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
            $data['is_logged_in'] = 1;
        } else {
            // else set is_logged_in = 0
            $data['is_logged_in'] = 0;
        }

        return $data;
    }
    public function index(){
        // master page doesn't have an index page
        // just show a big an error message
        show_404();

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item Type';
        $this->parser->parse('templates/header.php', $data);

        // TODO: parse the content of this route here!
        // master index

        $this->parser->parse('templates/footer.php', $data);

    }

    public function item_type(){
        // this shows the list of the item types in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item Type';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Item_type_model');
        $data['records'] = $this->Item_type_model->select_all();
        $this->parser->parse('masters/item_types/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function item_type_insert_form(){
        // this shows the form for inserting a new item type

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item Type';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/item_types/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function item_type_insert(){
        // this insert a new item_type to the database
        // and then redirect to /master/item-type

        $this->load->model('Item_type_model');
        $is_assembled = ($this->input->post('is_assembled') != null) ? 1 : 0;
        $data = [
            'name' => $this->input->post('name', TRUE),
            'is_assembled' => $is_assembled
        ];

        if ($this->Item_type_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/item-type');
        } else {
            //show errors
        }
    }
    public function item_type_update_form(){
        // this shows the form for updating an item

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Item Type';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('item_types', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/item_types/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function item_type_update(){
        // this updates a item_type in the database
        // and then redirect to /master/item-type

        $this->load->model('Item_type_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Item_type_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/item-type');
        } else {
            //show errors
        }
    }

    public function brand(){
        // this shows the list of the item types in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Brand';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('b.*, i.name as item_type_name');
        $this->db->from('brands b, item_types i');
        $this->db->where('i.id = b.item_type_id');
        $query = $this->db->get();
        $data['records'] = $query->result();

//        echo json_encode($data);
        $this->parser->parse('masters/brands/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function brand_insert_form(){
        // this shows the form for inserting a brand

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Brand';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('*');
        $this->db->from('item_types i');
        $this->db->order_by('name asc');
        $data['item_types'] = $this->db->get()->result();
        $this->parser->parse('masters/brands/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function brand_insert(){
        // this insert a new brand to the database
        // and then redirect to /master/item-type

        $this->load->model('Brand_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'item_type_id' => $this->input->post('item_type_id', TRUE)
        ];

        if ($this->Brand_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/brand');
        } else {
            //show errors
        }
    }
    public function brand_update_form(){
        // this shows the form for updating an item type

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Brand';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $this->db->select('b.*');
        $this->db->from('brands b, item_types i');
        $this->db->where('i.id = b.item_type_id');
        $query = $this->db->get_where('brands', array('b.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        $this->db->select('*');
        $this->db->from('item_types i');
        $this->db->order_by('name asc');
        $data['item_types'] = $this->db->get()->result();

        $this->load->view('masters/brands/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function brand_update(){
        // this updates a brand in the database
        // and then redirect to /master/item-type

        $this->load->model('Brand_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'item_type_id' => $this->input->post('item_type_id', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Brand_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/brand');
        } else {
            //show errors
        }
    }

    public function model(){
        // this shows the list of the item types in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Model';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('m.*, b.name as brand_name, i.name as item_type_name');
        $this->db->from('models m, brands b, item_types i');
        $this->db->where('m.brand_id = b.id AND b.item_type_id = i.id');
        $query = $this->db->get();
        $data['records'] = $query->result();

//        echo json_encode($data);
        $this->parser->parse('masters/models/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function model_insert_form(){
        // this shows the form for inserting a model

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Model';
        $this->parser->parse('templates/header.php', $data);

        // models are only applicable for items,
        // so only query for item_type that has is_assembled = 0
        $this->db->select('b.*, i.name as item_type_name');
        $this->db->from('brands b, item_types i');
        $this->db->where('b.item_type_id = i.id and i.is_assembled = 0');
        $this->db->order_by('item_type_name, b.name asc');
        $data['brands'] = $this->db->get()->result();

        $this->parser->parse('masters/models/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function model_insert(){
        // this insert a new model to the database
        // and then redirect to /master/item-type

        $this->load->model('Model_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'capacity_size' => $this->input->post('capacity_size', TRUE),
            'units' => $this->input->post('units', TRUE),

        ];
        if ($this->Model_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/model');
        } else {
            //show errors
        }
    }
    public function model_update_form(){
        // this shows the form for updating an item type

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Model';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $this->db->select('m.*');
        $this->db->from('models m, brands b');
        $this->db->where('m.brand_id = b.id');
        $query = $this->db->get_where('models', array('m.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        // models are only applicable for items,
        // so only query for item_type that has is_assembled = 0
        $this->db->select('b.*, i.name as item_type_name');
        $this->db->from('brands b, item_types i');
        $this->db->where('b.item_type_id = i.id and i.is_assembled = 0');
        $this->db->order_by('item_type_name, b.name asc');
        $data['brands'] = $this->db->get()->result();

        $this->load->view('masters/models/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function model_update(){
        // this updates a model in the database
        // and then redirect to /master/model

        $this->load->model('Model_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'capacity_size' => $this->input->post('capacity_size', TRUE),
            'units' => $this->input->post('units', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Model_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/model');
        } else {
            //show errors
        }
    }

    public function supplier(){
        // this shows the list of the suppliers in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Supplier';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Supplier_model');
        $data['records'] = $this->Supplier_model->select_all();
        $this->parser->parse('masters/suppliers/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function supplier_insert_form(){
        // this shows the form for inserting a new supplier

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Supplier';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/suppliers/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function supplier_insert(){
        // this insert a new supplier to the database
        // and then redirect to /master/item-type

        $this->load->model('Supplier_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];

        if ($this->Supplier_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/supplier');
        } else {
            //show errors
        }
    }
    public function supplier_update_form(){
        // this shows the form for updating an supplier

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Supplier';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('suppliers', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/suppliers/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function supplier_update(){
        // this updates a supplier in the database
        // and then redirect to /master/item-type

        $this->load->model('Supplier_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Supplier_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/supplier');
        } else {
            //show errors
        }
    }

    public function company(){
        // this shows the list of the companies in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Company';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Company_model');
        $data['records'] = $this->Company_model->select_all();
        $this->parser->parse('masters/companies/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function company_insert_form(){
        // this shows the form for inserting a new company

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Company';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/companies/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function company_insert(){
        // this insert a new company to the database
        // and then redirect to /master/item-type

        $this->load->model('Company_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];

        if ($this->Company_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/company');
        } else {
            //show errors
        }
    }
    public function company_update_form(){
        // this shows the form for updating an company

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Company';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('companies', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/companies/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function company_update(){
        // this updates a company in the database
        // and then redirect to /master/item-type

        $this->load->model('Company_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Company_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/company');
        } else {
            //show errors
        }
    }

    public function location(){
        // this shows the list of the locations in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Location';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Location_model');
        $data['records'] = $this->Location_model->select_all();
        $this->parser->parse('masters/locations/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function location_insert_form(){
        // this shows the form for inserting a new location

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Location';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/locations/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function location_insert(){
        // this insert a new location to the database
        // and then redirect to /master/item-type

        $this->load->model('Location_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];

        if ($this->Location_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/location');
        } else {
            //show errors
        }
    }
    public function location_update_form(){
        // this shows the form for updating an location

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Location';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('locations', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/locations/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function location_update(){
        // this updates a location in the database
        // and then redirect to /master/item-type

        $this->load->model('Location_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Location_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/location');
        } else {
            //show errors
        }
    }


    public function first_sub_location(){
        // this shows the list of the item types in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - 1st Sub Location';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('f.*, l.name as location_name');
        $this->db->from('first_sub_locations f, locations l');
        $this->db->where('l.id = f.location_id');
        $query = $this->db->get();
        $data['records'] = $query->result();

//        echo json_encode($data);
        $this->parser->parse('masters/first_sub_locations/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function first_sub_location_insert_form(){
        // this shows the form for inserting a first_sub_location

        $data = $this->get_session_data();

        $data['title'] = 'ALS - First_sub_location';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('*');
        $this->db->from('locations l');
        $this->db->order_by('name asc');
        $data['locations'] = $this->db->get()->result();
        $this->parser->parse('masters/first_sub_locations/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function first_sub_location_insert(){
        // this insert a new first_sub_location to the database
        // and then redirect to /master/item-type

        $this->load->model('First_sub_location_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'location_id' => $this->input->post('location_id', TRUE)
        ];

        if ($this->First_sub_location_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/fsub-location');
        } else {
            //show errors
        }
    }
    public function first_sub_location_update_form(){
        // this shows the form for updating an item type

        $data = $this->get_session_data();

        $data['title'] = 'ALS - First Sub Location';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $this->db->select('f.*');
        $this->db->from('first_sub_locations f, locations l');
        $this->db->where('l.id = f.location_id');
        $query = $this->db->get_where('first_sub_locations', array('f.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        $this->db->select('*');
        $this->db->from('locations l');
        $this->db->order_by('name asc');
        $data['locations'] = $this->db->get()->result();

        $this->load->view('masters/first_sub_locations/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function first_sub_location_update(){
        // this updates a first_sub_location in the database
        // and then redirect to /master/item-type

        $this->load->model('First_sub_location_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'location_id' => $this->input->post('location_id', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->First_sub_location_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/fsub-location');
        } else {
            //show errors
        }
    }

    public function second_sub_location(){
        // this shows the list of the item types in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - 2nd Sub Location';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('s.*, f.name as first_sub_location_name, l.name as location_name');
        $this->db->from('second_sub_locations s, first_sub_locations f, locations l');
        $this->db->where('l.id = f.location_id and f.id = s.first_sub_location_id');
        $query = $this->db->get();
        $data['records'] = $query->result();

//        echo json_encode($data);
        $this->parser->parse('masters/second_sub_locations/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function second_sub_location_insert_form(){
        // this shows the form for inserting a second_sub_location

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Second_sub_location';
        $this->parser->parse('templates/header.php', $data);

        $this->db->select('f.*, l.name as location_name');
        $this->db->from('first_sub_locations f, locations l');
        $this->db->where('l.id = f.location_id');
        $this->db->order_by('l.name, f.name asc');
        $data['first_sub_locations'] = $this->db->get()->result();
        $this->parser->parse('masters/second_sub_locations/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function second_sub_location_insert(){
        // this insert a new second_sub_location to the database
        // and then redirect to /master/item-type

        $this->load->model('Second_sub_location_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'first_sub_location_id' => $this->input->post('first_sub_location_id', TRUE)
        ];

        if ($this->Second_sub_location_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/ssub-location');
        } else {
            //show errors
        }
    }
    public function second_sub_location_update_form(){
        // this shows the form for updating an item type

        $data = $this->get_session_data();

        $data['title'] = 'ALS - First Sub Location';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $this->db->select('s.*');
        $this->db->from('second_sub_locations s, first_sub_locations f');
        $this->db->where('f.id = s.first_sub_location_id');
        $query = $this->db->get_where('second_sub_locations', array('s.id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;

        $this->db->reset_query();
        $this->db->select('f.*, l.name as location_name');
        $this->db->from('first_sub_locations f, locations l');
        $this->db->where('l.id = f.location_id');
        $this->db->order_by('l.name, f.name asc');
        $data['first_sub_locations'] = $this->db->get()->result();

        $this->load->view('masters/second_sub_locations/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function second_sub_location_update(){
        // this updates a second_sub_location in the database
        // and then redirect to /master/item-type

        $this->load->model('Second_sub_location_model');
        $data = [
            'name' => $this->input->post('name', TRUE),
            'first_sub_location_id' => $this->input->post('first_sub_location_id', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Second_sub_location_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/ssub-location');
        } else {
            //show errors
        }
    }

    public function mutation_status(){
        // this shows the list of the mutation statuses in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Mutation status';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Mutation_status_model');
        $data['records'] = $this->Mutation_status_model->select_all();
        $this->parser->parse('masters/mutation_statuses/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function mutation_status_insert_form(){
        // this shows the form for inserting a new mutation status

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Mutation status';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/mutation_statuses/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function mutation_status_insert(){
        // this insert a new mutation_status to the database
        // and then redirect to /master/item-type

        $this->load->model('Mutation_status_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];

        if ($this->Mutation_status_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/mutation-status');
        } else {
            //show errors
        }
    }
    public function mutation_status_update_form(){
        // this shows the form for updating an item

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Mutation status';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('mutation_statuses', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/mutation_statuses/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function mutation_status_update(){
        // this updates a mutation_status in the database
        // and then redirect to /master/mutation-status

        $this->load->model('Mutation_status_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Mutation_status_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/mutation-status');
        } else {
            //show errors
        }
    }

    public function employee(){
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

        $this->parser->parse('masters/employees/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function employee_insert_form(){
        // this shows the form for inserting a new employee

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Employee';
        $this->parser->parse('templates/header.php', $data);

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
        foreach($this->db->get()->result() as $second_sub_location){
            $data['second_sub_locations'][$second_sub_location->id] = $second_sub_location;
        }

//        echo json_encode($data['locations']);

        $this->parser->parse('masters/employees/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function employee_insert(){
        // this insert a new employee to the database
        // and then redirect to /master/item-type

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

        if ($this->Employee_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/employee');
        } else {
            //show errors
        }
    }
    public function employee_update_form(){
        // this shows the form for updating an employee

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Employee';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

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

        $this->load->view('masters/employees/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function employee_update(){
        // this updates a employee in the database
        // and then redirect to /master/item-type

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

        $id = $this->uri->segment('5');
//        echo json_encode($data);
//        echo '<br>';
//        echo $id;

        if ($this->Employee_model->update($data, $id)) {
            //success updating data
            redirect(base_url() . 'master/employee');
        } else {
            //show errors
        }
    }

    public function user(){
        // this shows the list of the users in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - User';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('User_model');
        $data['records'] = $this->User_model->select_all();
        $this->parser->parse('masters/users/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function user_insert_form(){
        // this shows the form for inserting a new user

        $data = $this->get_session_data();

        // check if there's any previous error messages to parse
        $errors = $this->session->flashdata('errors');
        $data['errors'] = $errors;

        // pass the previously entered value
        $username = $this->session->flashdata('username');
        $data['username'] = $username;
        $is_admin = $this->session->flashdata('is_admin');
        $data['is_admin'] = $is_admin;


        $data['title'] = 'ALS - User';
        $this->parser->parse('templates/header.php', $data);
        $this->parser->parse('masters/users/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function user_insert(){
        // this insert a new user to the database
        // and then redirect to /master/user
        $method = $this->input->method();

        if($method == 'get') {
            //show the form
            redirect(base_url().'master/user/new');

        } else if ($method == 'post'){
            //check for errors
            $errors = [];
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $is_admin = ($this->input->post('is_admin') != null) ? 1 : 0;

            if (!ctype_alnum($username)){
                array_push($errors, 'Username can only contains alphanumeric characters!');
            }
            if (!ctype_alnum($password)){
                array_push($errors, 'Password can only contains alphanumeric characters!');
            }
            if (strlen($username) < 4 || strlen($username) > 20){
                array_push($errors, 'Username must be between 4 to 20 characters!');
            }
            if (strlen($password) < 8 || strlen($password) > 32){
                array_push($errors, 'Password must be between 8 to 32 characters!');
            }
            
            if (sizeof($errors) == 0){
                //if there are still no errors at this point, try inserting
                $data = [
                    'username' => $username,
                    'password' => md5($password),
                    'is_admin' => $is_admin
                ];
                $this->load->model('User_model');
                if ($this->User_model->insert($data)) {
                    //success inserting data
                    redirect(base_url() . 'master/user');
                } else {
                    //errors!
                    $db_error = $this->db->error();
                    if ($db_error['code'] == 1062){
                        //this means that there are duplicate entry
                        array_push($errors, 'Username already exists! Please use a different username!');
                    }
                    // For Debugging purposes only
//                    $error_msg = 'Error code: '.$db_error['code'].'<br/>';
//                    $error_msg .= 'Message: '.$db_error['message'];
//                    array_push($errors, $error_msg);
                }
            }

            //if we reach this point, this means that there were still errors
            //so we show the input form again, while passing the error messages as flashdata.
            $data = $this->get_session_data();

            $this->session->set_flashdata('errors', $errors);
            $this->session->set_flashdata('username', $username);
            $this->session->set_flashdata('is_admin', $is_admin);
            redirect(base_url().'master/user/new');
        }
    }
    public function user_update_form(){
        // this shows the form for updating an item

        $data = $this->get_session_data();

        // check if there's any previous error messages to parse
        $errors = $this->session->flashdata('errors');
        $data['errors'] = $errors;

        // pass the previously entered value
        $username = $this->session->flashdata('username');
        $data['username'] = $username;
        $is_admin = $this->session->flashdata('is_admin');
        $data['is_admin'] = $is_admin;

        $data['title'] = 'ALS - User';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('users', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/users/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function user_update(){
        // this updates a user in the database
        // and then redirect to /master/user
        $method = $this->input->method();

        if($method == 'get') {
            //show the form
            redirect(base_url().'master/user/new');

        } else if ($method == 'post'){
            //check for errors
            $errors = [];
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $is_admin = ($this->input->post('is_admin') != null) ? 1 : 0;
            $id = $this->uri->segment('5');

            if (!ctype_alnum($username)){
                array_push($errors, 'Username can only contains alphanumeric characters!');
            }
            if (!ctype_alnum($password)){
                array_push($errors, 'Password can only contains alphanumeric characters!');
            }
            if (strlen($username) < 4 || strlen($username) > 20){
                array_push($errors, 'Username must be between 4 to 20 characters!');
            }
            if (strlen($password) < 8 || strlen($password) > 32){
                array_push($errors, 'Password must be between 8 to 32 characters!');
            }

            if (sizeof($errors) == 0){
                //if there are still no errors at this point, try updating database
                $data = [
                    'username' => $username,
                    'password' => md5($password),
                    'is_admin' => $is_admin
                ];
                $this->load->model('User_model');
                if ($this->User_model->update($data, $id)) {
                    //success inserting data
                    redirect(base_url() . 'master/user');
                } else {
                    //errors!
                    $db_error = $this->db->error();
                    if ($db_error['code'] == 1062){
                        // this means that there are duplicate entry
                        // add more error code in the future using nested if statements
                        array_push($errors, 'Username already exists! Please use a different username!');
                    }
                    // For Debugging purposes only
//                    $error_msg = 'Error code: '.$db_error['code'].'<br/>';
//                    $error_msg .= 'Message: '.$db_error['message'];
//                    array_push($errors, $error_msg);
                }
            }

            //if we reach this point, this means that there were still errors
            //so we show the input form again, while passing the error messages as flashdata.
            $data = $this->get_session_data();

            $this->session->set_flashdata('errors', $errors);
            $this->session->set_flashdata('username', $username);
            $this->session->set_flashdata('is_admin', $is_admin);
            redirect(base_url().'master/user/edit/'.$id);
        }
    }

    public function operating_system(){
        // this shows the list of the operating_systems in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Operating_system';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Operating_system_model');
        $data['records'] = $this->Operating_system_model->select_all();
        $this->parser->parse('masters/operating_systems/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function operating_system_insert_form(){
        // this shows the form for inserting a new operating_system

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Operating_system';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('masters/operating_systems/insert_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function operating_system_insert(){
        // this insert a new operating_system to the database
        // and then redirect to /master/item-type

        $this->load->model('Operating_system_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];

        if ($this->Operating_system_model->insert($data)) {
            //success inserting data
            redirect(base_url() . 'master/os');
        } else {
            //show errors
        }
    }
    public function operating_system_update_form(){
        // this shows the form for updating an operating_system

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Operating_system';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('4');

        $query = $this->db->get_where('operating_systems', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('masters/operating_systems/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function operating_system_update(){
        // this updates a operating_system in the database
        // and then redirect to /master/item-type

        $this->load->model('Operating_system_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('5');

        if ($this->Operating_system_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'master/operating_system');
        } else {
            //show errors
        }
    }
}