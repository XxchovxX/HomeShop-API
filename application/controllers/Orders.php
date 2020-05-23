<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class Orders extends REST_Controller {

	public function __construct(){
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");


		parent::__construct();
		$this->load->database();
	}

	public function set_post($page = 0, $filter = "", $company = 0) {
        $data = $this->post();
        
        $this->db->reset_query();

        $this->db->insert('orders', array('date' => date('Y-m-d'), 'company' => $data['id']));
        $order = $this->db->insert_id();

        foreach ($data['products'] as $key => $product) {
            $insert = array(
                'idProduct' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'idOrder' => $order
            );
            $this->db->insert('orders_details', $insert);
        }

		$response = array(
			'error' => FALSE,     
            'order' => $order
		);
	
		$this->response($response);
	}
}