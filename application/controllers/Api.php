<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

	public function __construct($config = 'rest') {

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  	parent::__construct();

		$this->load->model('koleksi');

  }

	public function index_get()
	{
		$this->load->template('api_home');
	}

	public function test_get(){
		$this->response( "OK" , 200  );
	}

	public function books_get(){
		if( empty( $this->get('keyword') ) ) {
			$this->response( "empty keywords", 400 );
		} else {
			$keyword = $this->get('keyword');

			if( strlen($keyword) < 4 || substr($keyword,0,1) == '~' || substr($keyword,0,1) == '+' ) {
				$this->response( "invalid criteria or keywords", 400 );
			} else {
				$kriteria = $this->koleksi->keywords('judul', $keyword);
				$buku = $this->koleksi->queryBuku( $kriteria );
				if( $buku['jumlah'] == 0 ){
					$this->response( "no data", 204 );
				} else {
					$this->response( $buku, 200 );
				}
			}
		}

	}

}
