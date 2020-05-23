<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class Company extends REST_Controller {

	public function __construct(){
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");


		parent::__construct();
		$this->load->database();
	}

	public function info_get($company = 0) {
		$sql = "SELECT id, name, description FROM companies WHERE id = $company;";

		$query = $this->db->query($sql);

		$company = $query->result_array();
		$response = array(
			'error' => FALSE,
			'company' => $company[0]
		);
	
		$this->response($response);
	}
}