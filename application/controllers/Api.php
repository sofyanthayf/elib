<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

	private $api_key;

	public function __construct($config = 'rest') {

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  	parent::__construct();

		$this->load->model('koleksi');

		$headers = apache_request_headers();
		if( isset($headers['API-KEY']) ) {
			$this->api_key = $headers['API-KEY'];
		} else {
			$this->api_key = "x";
		}

  }

	// "https://elib.kharisma.ac.id/api/books/key/" + API_KEY + "/keyword/" + keyword
	public function books_get(){

		$this->api_key = $this->get('key');

		if ( !$this->_key_exists() )
		{
				$this->response([ 'status' => FALSE,
													'message' => 'Invalid API key'
													], REST_Controller::HTTP_BAD_REQUEST );

		}	else {

			if( empty( $this->get('keyword') ) ) {

				$this->response([ 'status' => FALSE,
													'message' => 'Invalid API key'
													], REST_Controller::HTTP_BAD_REQUEST );

			} else {

				$keyword = $this->get('keyword');
				$page = $this->get('page');

				if( strlen($keyword) < 4 || substr($keyword,0,1) == '~' || substr($keyword,0,1) == '+' ) {
					$this->response([ 'status' => FALSE,
														'message' => 'Invalid API key'
														], REST_Controller::HTTP_BAD_REQUEST );

				} else {

					$kriteria = $this->koleksi->keywords('judul', $keyword);
					if( empty($page) ) $page = 1;
					$buku = $this->koleksi->queryBuku( $kriteria, $page );
					if( $buku['jumlah'] == 0 ){
						$this->response( "no data", REST_Controller::HTTP_NO_CONTENT );
					} else {
						$this->response( $buku, REST_Controller::HTTP_OK );
					}

				}
			}
		}
	}

	// public function books_post(){
	// 	if ( !$this->_key_exists() )
	// 	{
	// 		$this->response([ 'status' => FALSE,
	// 											'message' => 'Invalid API key'
	// 											], REST_Controller::HTTP_BAD_REQUEST );
	// 	} else {
	// 		$keyword = $this->post('keyword');
	// 		$page = $this->post('page');
	// 		if( empty( $this->post('keyword') ) ) {
	// 			$this->response([ 'status' => FALSE,
	// 												'message' => 'Invalid API key'
	// 												], REST_Controller::HTTP_BAD_REQUEST );
	// 		} else {
	// 			if( strlen($keyword) < 4 || substr($keyword,0,1) == '~' || substr($keyword,0,1) == '+' ) {
	// 				$this->response([ 'status' => FALSE,
	// 													'message' => 'Invalid API key'
	// 													], REST_Controller::HTTP_BAD_REQUEST );
	// 			} else {
	// 				$kriteria = $this->koleksi->keywords('judul', $keyword);
	// 				if( empty($page) ) $page = 1;
	// 				$buku = $this->koleksi->queryBuku( $kriteria, $page );
	// 				if( $buku['jumlah'] == 0 ){
	// 					$this->response( "no data", 204 );
	// 				} else {
	// 					$this->response( $buku, 200 );
	// 				}
	// 			}
	// 		}
	// 	}
	// }

	// "https://elib.kharisma.ac.id/api/skripsi/key/" + API_KEY + "/keyword/" + keyword
	public function skripsi_get(){

		$this->api_key = $this->get('key');

		if ( !$this->_key_exists() )
		{
				$this->response([ 'status' => FALSE,
													'message' => 'Invalid API key'
													], REST_Controller::HTTP_BAD_REQUEST );
		}	else {
			if( empty( $this->get('keyword') ) ) {
				$this->response([ 'status' => FALSE,
													'message' => 'Invalid API key'
													], REST_Controller::HTTP_BAD_REQUEST );
			} else {
				$keyword = $this->get('keyword');
				$page = $this->get('page');
				if( strlen($keyword) < 4 || substr($keyword,0,1) == '~' || substr($keyword,0,1) == '+' ) {
					$this->response([ 'status' => FALSE,
														'message' => 'Invalid API key'
														], REST_Controller::HTTP_BAD_REQUEST );
				} else {
					$kriteria = $this->koleksi->keywords('judul', $keyword);
					if( empty($page) ) $page = 1;
					$skripsi = $this->koleksi->querySkripsi( $kriteria, $page );
					// if( $skripsi['jumlah'] == 0 ){
						// $this->response( "no data", REST_Controller::HTTP_NO_CONTENT );
					// } else {
						$this->response( $skripsi, REST_Controller::HTTP_OK );
					// }

				}
			}
		}
	}

	private function _key_exists()
	{
		return $this->rest->db
				->where(config_item('rest_key_column'), $this->api_key)
				->count_all_results(config_item('rest_keys_table')) > 0;
	}

}
