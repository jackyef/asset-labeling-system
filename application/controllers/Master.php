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
        $this->load->database();
        $this->output->enable_profiler(FALSE);

        $data = $this->get_session_data();
        if ($data['is_admin'] != 1){
            redirect(base_url().'home');
        }

    }

    public function get_session_data(){
        // TODO: use real session data
        // remember use xss_clean
        $data['username'] = 'John-Doe';
        $data['user_id'] = '123';
        $data['is_admin'] = 1;
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
            'name' => $this->input->post('name'),
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name'),
            'item_type_id' => $this->input->post('item_type_id')
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
            'name' => $this->input->post('name'),
            'item_type_id' => $this->input->post('item_type_id')
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
            'name' => $this->input->post('name'),
            'brand_id' => $this->input->post('brand_id'),
            'capacity_size' => $this->input->post('capacity_size'),
            'units' => $this->input->post('units'),

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
        // and then redirect to /master/item-type

        $this->load->model('Model_model');
        $data = [
            'name' => $this->input->post('name'),
            'item_type_id' => $this->input->post('item_type_id')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name'),
            'location_id' => $this->input->post('location_id')
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
            'name' => $this->input->post('name'),
            'location_id' => $this->input->post('location_id')
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
            'name' => $this->input->post('name'),
            'first_sub_location_id' => $this->input->post('first_sub_location_id')
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
            'name' => $this->input->post('name'),
            'first_sub_location_id' => $this->input->post('first_sub_location_id')
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
            'name' => $this->input->post('name')
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
            'name' => $this->input->post('name')
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
        $locs = $this->input->post('location_id');
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
        $locs = $this->input->post('location_id');
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
}