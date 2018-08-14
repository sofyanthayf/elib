<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

	private $api_key;
	private $keyword;
	private $page;

	public function __construct($config = 'rest') {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  	parent::__construct();

		$this->load->model('koleksi');
		$this->api_key = $this->get('key');
  }

	// "https://elib.kharisma.ac.id/api/books/key/" + API_KEY + "/keyword/" + keyword
	public function books_get(){
		if( $this->requestOk() ) {
			$kriteria = $this->koleksi->keywords('judul', $this->keyword);
			if( empty($this->page) ) $this->page = 1;
			$buku = $this->koleksi->queryBuku( $kriteria, $this->page );
			if( $buku['jumlah'] == 0 ){
				$this->response( "no data", REST_Controller::HTTP_NO_CONTENT );
			} else {
				$this->response( $buku, REST_Controller::HTTP_OK );
			}
		}
	}


	// "https://elib.kharisma.ac.id/api/skripsi/key/" + API_KEY + "/keyword/" + keyword
	public function skripsi_get(){
		if( $this->requestOk() ) {
			$kriteria = $this->koleksi->keywords('judul', $this->keyword);
			if( empty($this->page) ) $this->page = 1;
			$skripsi = $this->koleksi->querySkripsi( $kriteria, $this->page );
			if( $skripsi['jumlah'] == 0 ){
				$this->response( "no data", REST_Controller::HTTP_NO_CONTENT );
			} else {
				$this->response( $skripsi, REST_Controller::HTTP_OK );
			}
		}

	}

	// "https://elib.kharisma.ac.id/api/paper/key/" + API_KEY + "/keyword/" + keyword
	public function paper_get(){
		if( $this->requestOk() ) {
			$tipe = $this->get('type');
			$kriteria = $this->koleksi->keywords('judul', $this->keyword);
			if( empty($this->page) ) $this->page = 1;
			$paper = $this->koleksi->queryPaper( $kriteria, $tipe, $this->page );
			if( $paper['jumlah'] == 0 ){
				$this->response( "no data", REST_Controller::HTTP_NO_CONTENT );
			} else {
				$this->response( $paper, REST_Controller::HTTP_OK );
			}
		}
	}


	/*********************** private functions *******************/

	private function requestOk(){
		$ok = false;

		if ( !$this->_key_exists() )
		{
				$this->response([ 'status' => FALSE,
													'message' => 'Invalid API key'
													], REST_Controller::HTTP_BAD_REQUEST );
		}	else {
			if( empty( $this->get('keyword') ) ) {
				$this->response([ 'status' => FALSE,
													'message' => 'Empty keyword!'
													], REST_Controller::HTTP_BAD_REQUEST );
			} else {
				$this->keyword = $this->get('keyword');
				$this->page = $this->get('page');
				if( strlen($this->keyword) < 4 || substr($this->keyword,0,1) == '~' || substr($this->keyword,0,1) == '+' ) {
					$this->response([ 'status' => FALSE,
														'message' => 'Invalid keywords'
														], REST_Controller::HTTP_BAD_REQUEST );
				} else {
					$ok = true;
				}
			}
		}
		return $ok;
	}

	private function _key_exists()
	{
		return $this->rest->db
				->where(config_item('rest_key_column'), $this->api_key)
				->count_all_results(config_item('rest_keys_table')) > 0;
	}


}
