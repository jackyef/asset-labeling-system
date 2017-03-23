<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/13/2017
 * Time: 8:56 AM
 */


class Barcode extends CI_Controller
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
//        echo json_encode($this->session->userdata());
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
        $data = $this->get_session_data();
//        echo json_encode($data);
        $data['title'] = 'ALS - Barcode';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('barcode/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }

    public function find(){
        $data = $this->get_session_data();
        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'barcode');
        }
//        echo json_encode($data);
        $item_code = $this->input->post('item_code', TRUE);
        $item_code = html_escape($item_code);
        $item_type_id = substr($item_code, 0, 2);
        while($item_type_id[0] == '0'){
            //remove leading zeroes
            $item_type_id = substr($item_type_id, 1);
        }

        $this->db->reset_query();
        $this->db->select('it.* ');
        $query = $this->db->get_where('item_types it', array('it.id' => $item_type_id));
        if(isset($query->result()[0])){
            $item_type = $query->result()[0];
        } else {
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item type does not exist!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'barcode');
        }

        $is_assembled = ($item_type->is_assembled == 1) ? true : false;

        $item_id = substr($item_code, 2); // start taking item id from the 3rd character
        while($item_id[0] == '0'){
            $item_id = substr($item_id, 1); // remove leading zeroes
        }

        if($is_assembled){
            $this->db->reset_query();
            $this->db->select('ai.* ');
            $query = $this->db->get_where('assembled_items ai', array('ai.id' => $item_id));
            if(isset($query->result()[0])){
                $item = $query->result()[0];
            } else {
                $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item does not exist!');
                $this->session->set_flashdata('site_wide_msg_type', 'danger');
                redirect(base_url().'barcode');
            }
        } else {
            $this->db->reset_query();
            $this->db->select('i.*');
            $query = $this->db->get_where('items i ', array('i.id' => $item_id));
            if(isset($query->result()[0])){
                $item = $query->result()[0];
            } else {
                $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item does not exist!');
                $this->session->set_flashdata('site_wide_msg_type', 'danger');
                redirect(base_url().'barcode');
            }
        }

//        echo $is_assembled;
//        echo '<br/>';
//        echo $item_type_id;
//        echo '<br/>';
//        echo $item_id;

        if($is_assembled){
            redirect(base_url().'assembled-item/detail/'.$item_id);
        } else {
            redirect(base_url().'item/detail/'.$item_id);
        }

    }

    public function print_barcode_form(){

        $data = $this->get_session_data();
//        echo json_encode($data);
        $data['title'] = 'ALS - Barcode';
        $this->parser->parse('templates/header.php', $data);

        // show form to select codes to print
        //get list of items and assembled items
        $this->db->select('i.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name, 
                            e.name as employee_name, e.location_id as location_id, 
                            e.first_sub_location_id as first_sub_location_id, 
                            e.second_sub_location_id as second_sub_location_id, 
                            e.company_id as employee_company_id');
        $this->db->from('items i, item_types it, brands b, models m, employees e');
        $this->db->where('i.model_id = m.id AND m.brand_id = b.id AND b.item_type_id = it.id AND
                          i.employee_id = e.id');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('ai.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name, 
                            e.name as employee_name, e.location_id as location_id, 
                            e.first_sub_location_id as first_sub_location_id, 
                            e.second_sub_location_id as second_sub_location_id, 
                            e.company_id as employee_company_id');
        $this->db->from('assembled_items ai, item_types it, brands b, employees e');
        $this->db->where('ai.brand_id = b.id AND b.item_type_id = it.id AND
                          ai.employee_id = e.id');
        $query = $this->db->get();
        $result2 = $query->result();

        foreach($result2 as $entry){
            $entry->assembled = 1; //mark this record as an assembled item, so we can redirect correctly
        }

        $items = array_merge($result1, $result2);

//        echo json_encode($items);
        // sort items in reverse order by id
        usort($items, array($this, "compare"));
        $data['items'] = $items;


        $this->parser->parse('barcode/print_barcode_form.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }
    private function compare($a, $b)
    {
        // present item in reverse sorted id
        return $a->id < $b->id;
    }

//
//    public function print_barcode(){
//        $item_codes = $this->input->post('item_codes', TRUE);
//        echo json_encode($item_codes);
//    }


    public function print_barcode(){
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');

        $item_codes = $this->input->post('item_codes', TRUE);
//        $item_codes = ['1200003', '0900003', '2300238', '0100523', '1009301'];

        $count = 0;
        $out = null;
        $i = 0;

        $files = array();
        while ($i < sizeof($item_codes)){
            $count++;
            $barcodeOptions = array('text' => $item_codes[$i],
                'barHeight' => 50,
                'barThickWidth' => 3,
                'barThinWidth' => 2,
                'font' => 5,
                'fontSize' => 20,
                'drawText' => true,
                'withQuietZones' => true,
                'factor' => 1);

            // No required options
            $rendererOptions = array('imageType' => 'png');

            // Draw the barcode in a new image,
            // send the headers and the image

            // draw an image resource
            $image = Zend_Barcode::draw(
                'code128', 'image', $barcodeOptions, $rendererOptions
            );

            if($count == 1 && $i == sizeof($item_codes)-1) {
                // this is the first image, and there are no image after this
                // append white spaces
                $out = $image;
                $out = $this->append_side_white($out, $image);

                // put the output images as base64 encoded string into files array
                ob_start();
                imagepng($out);
                $contents =  ob_get_contents();
                ob_end_clean();
                array_push($files, $contents);

            } elseif ($count == 1) {
                // there is still another image
                $out = $image;
            } elseif ($count == 2) {
                // this is a second image
                $out = $this->append_side($out, $image);

                // put the output images as base64 encoded string into files array
                ob_start();
                imagepng($out);
                $contents =  ob_get_contents();
                ob_end_clean();
                array_push($files, $contents);

                //reset count to 0
                $count = 0;
            }
            $i++;
        }

        $zipname = 'barcodes.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        $idx = 0;
        foreach ($files as $file) {
            echo $file;
            $idx++;
            $zip->addFromString('barcode'.$idx.'.png', $file);
        }
        $zip->close();


//        foreach($item_codes as $code){
//            $count++;
//            $barcodeOptions = array('text' => $code,
//                'barHeight' => 50,
//                'barThickWidth' => 3,
//                'barThinWidth' => 2,
//                'font' => 5,
//                'fontSize' => 20,
//                'drawText' => true,
//                'withQuietZones' => true,
//                'factor' => 1);
//
//            // No required options
//            $rendererOptions = array('imageType' => 'png');
//
//            // Draw the barcode in a new image,
//            // send the headers and the image
//
//            // draw an image resource
//            $image = Zend_Barcode::draw(
//                'code128', 'image', $barcodeOptions, $rendererOptions
//            );
//
//            if($count == sizeof($item_codes)){
//                $out = $image;
//                $out = $this->append_side_white($out, $image);
//            } elseif ($count == 2){
//                $out = $this->append_side($out, $image);
//            } elseif ($count % 2 == 1){
//                //for the 3rd, 5th, 7th, etc
//                $out = $this->append_below($out, $image);
//            } elseif ($count % 2 == 0){
//                //for the 4th, 6th, 8th, etc
//                $out = $this->append_lower_right($out, $image);
//            }
//
//            $files = array('readme.txt', 'test.html', 'image.gif');
//            $zipname = 'file.zip';
//            $zip = new ZipArchive;
//            $zip->open($zipname, ZipArchive::CREATE);
//            foreach ($files as $file) {
//                $zip->addFile($file);
//            }
//            $zip->close();
//
//        }
        if(sizeof($files) == 1){
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="barcode.png"');
            header('Content-Type: application/octet-stream; Content-Disposition: filename="barcode.png"');
            imagepng($files[0]);
        } else {
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename='.$zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
        }
    }
    private function append_side_white($img_resource_x, $img_resource_y) {

        // Get dimensions for specified images

        $width_x = imagesx($img_resource_x);
        $width_y = imagesx($img_resource_y);
        $height_x = imagesy($img_resource_x);
        $height_y = imagesy($img_resource_y);

        // Create new image with desired dimensions
        $image = imagecreatetruecolor($width_x + $width_y, $height_x)
        or die('Cannot Initialize new GD image stream');
        // set background to white
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);


        imagecopy($image, $img_resource_x, 0, 0, 0, 0, $width_x, $height_x);
//        imagecopy($image, $img_resource_y, $width_x, 0, 0, 0, $width_y, $height_y); //concatenate to the right side

//        imagedestroy($img_resource_x);
//        imagedestroy($img_resource_y);

        // return the image resource
        return ($image);
    }

    private function append_side($img_resource_x, $img_resource_y) {

        // Get dimensions for specified images

        $width_x = imagesx($img_resource_x);
        $width_y = imagesx($img_resource_y);
        $height_x = imagesy($img_resource_x);
        $height_y = imagesy($img_resource_y);

        // Create new image with desired dimensions
        $image = imagecreatetruecolor($width_x + $width_y, $height_x)
        or die('Cannot Initialize new GD image stream');
        // set background to white
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);


        imagecopy($image, $img_resource_x, 0, 0, 0, 0, $width_x, $height_x);
        imagecopy($image, $img_resource_y, $width_x, 0, 0, 0, $width_y, $height_y); //concatenate to the right side

//        imagedestroy($img_resource_x);
//        imagedestroy($img_resource_y);

        // return the image resource
        return ($image);
    }

    private function append_below($img_resource_x, $img_resource_y) {

        // Get dimensions for specified images

        $width_x = imagesx($img_resource_x);
        $width_y = imagesx($img_resource_y);
        $height_x = imagesy($img_resource_x);
        $height_y = imagesy($img_resource_y);

        // Create new image with desired dimensions
        $image = imagecreatetruecolor($width_x, $height_x+$height_y)
        or die('Cannot Initialize new GD image stream');
        // set background to white
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);


        imagecopy($image, $img_resource_x, 0, 0, 0, 0, $width_x, $height_x);
        imagecopy($image, $img_resource_y, 0, $height_x, 0, 0, $width_y, $height_y); //concatenate to the below

//        imagedestroy($img_resource_x);
//        imagedestroy($img_resource_y);

        // return the image resource
        return ($image);

    }

    private function append_lower_right($img_resource_x, $img_resource_y) {

        // Get dimensions for specified images

        $width_x = imagesx($img_resource_x);
        $width_y = imagesx($img_resource_y);
        $height_x = imagesy($img_resource_x);
        $height_y = imagesy($img_resource_y);

        // Create new image with desired dimensions
        $image = imagecreatetruecolor($width_x, $height_x)
        or die('Cannot Initialize new GD image stream');
        // set background to white
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);

        imagecopy($image, $img_resource_x, 0, 0, 0, 0, $width_x, $height_x);
        imagecopy($image, $img_resource_y, $width_x-$width_y, $height_x-$height_y, 0, 0, $width_y, $height_y); //concatenate to lower_right

//        imagedestroy($img_resource_x);
//        imagedestroy($img_resource_y);

        // return the image resource
        return ($image);

    }
}