<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class Products extends REST_Controller {

	public function __construct(){
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");


		parent::__construct();
		$this->load->database();
	}

	public function search_get($page = 0, $filter = "", $company = 0) {
		$page = $page * 10;

		if ($company) $cond = "AND p.company = $company";
		else $cond = "OR c.name LIKE '%$filter%'";
		if ($filter === "0") $filter = "";
	
		$sql = "SELECT p.id, p.name, p.unity, p.price, p.company, p.description, c.name AS 'companyName' FROM products AS p
				INNER JOIN companies AS c on (p.company = c.id)
				WHERE p.name LIKE '%$filter%' $cond LIMIT $page,10;";

		$query = $this->db->query($sql);

		$response = array(
			'error' => FALSE,
			'products' => $query->result_array()
		);
	
		$this->response($response);
	}
}