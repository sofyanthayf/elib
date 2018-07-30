<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koleksi extends CI_Model {

    public $data;

    public function __construct() {
        parent::__construct();
    }


    function queryBuku( $kriteria, $page = 1 ){

      $books = array();

      $sql_count = "SELECT COUNT(*) jumlah FROM buku WHERE ".$kriteria;
      $query = $this->db->query( $sql_count );
      $books = $query->row_array();

      $books['jumlah_halaman'] = ceil( $books['jumlah'] / 20 );
      if( $page > $books['jumlah_halaman'] ) $page = 1;
      $books['halaman'] = $page;

      $offset = ($page * 20)-20;
      if( $offset < 0 ) $offset = 0;

      $sql_books = "SELECT id, id_buku, kode_ex, class, judul, tahun, isbn, tipe,
                           status, sinopsis, keywords, searched
                      FROM buku LEFT JOIN publisher USING (id_publisher)
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul LIMIT $offset,20";
      $query = $this->db->query( $sql_books );
      $books['buku'] = $query->result_array();

      $i = 0;
      foreach ($books['buku'] as $book) {
        // $books['buku'][$i]['num'] = $i+1;

        // authors
        $sql_auth = "SELECT urut, id_author, nama_depan, nama_belakang, singkatdepan
                      FROM bukuauthor LEFT JOIN author USING (id_author)
                      WHERE id_buku='".$book['id_buku']."' AND (tipe='B' OR tipe='E')
                      ORDER BY urut";
        $query = $this->db->query( $sql_auth );
        $books['buku'][$i]['author'] = $query->result_array();

        // publisher
        $sql_publ = "SELECT DISTINCT id_publisher, publisher, kota, negara
                      FROM publisher LEFT JOIN buku USING (id_publisher)
                      WHERE id_buku='".$book['id_buku']."'";
        $query = $this->db->query( $sql_publ );
        $books['buku'][$i]['publisher'] = $query->result_array();

        $i++;
      }

    	return $books ;
    }

    function querySkripsi( $kriteria, $page = 1 ){

      $skripsi = array();

      $sql_count = "SELECT COUNT(*) jumlah FROM skripsi WHERE ".$kriteria;
      $query = $this->db->query( $sql_count );
      $skripsi = $query->row_array();

      $skripsi['jumlah_halaman'] = ceil( $skripsi['jumlah'] / 20 );
      if( $page > $skripsi['jumlah_halaman'] ) $page = 1;
      $skripsi['halaman'] = $page;

      $offset = ($page * 20)-20;
      if( $offset < 0 ) $offset = 0;

      $sql_skripsi = "SELECT id, id_skripsi, kode_ex, class, judul, tahun, nim,
                           status, abstrak, keywords, searched
                      FROM skripsi
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul LIMIT $offset,20";
      $query = $this->db->query( $sql_skripsi );
      $skripsi['skripsi'] = $query->result_array();

      $i = 0;
      foreach ($skripsi['skripsi'] as $skripsi) {
        $skripsi['skripsi'][$i]['num'] = $i+1;

        // authors
        $sql_auth = "SELECT urut, id_author, nama_depan, nama_belakang, singkatdepan
                      FROM bukuauthor LEFT JOIN author USING (id_author)
                      WHERE id_buku='".$skripsi['id_skripsi']."' AND tipe='S'
                      ORDER BY urut";
        $query = $this->db->query( $sql_auth );
        $skripsi['skripsi'][$i]['author'] = $query->result_array();
$skripsi['auth'] = $sql_auth;
        // publisher
        $sql_publ = "SELECT DISTINCT id_publisher, publisher, kota, negara
                      FROM publisher
                      WHERE id_publisher='ST002'";
      //   $query = $this->db->query( $sql_publ );
      //   $skripsi['skripsi'][$i]['publisher'] = $query->result_array();
      //
        $i++;
      }

    	return $skripsi ;
    }

    function keywords( $field, $keys ){
      $pattern_reject = array('/=/', '/\'/', "@[/\\\]@", '/ /', '/%20/',
                              '/ dan /','/ atau /','/ bagi /','/ untuk /', '/ pada /',
                              '/ di /', '/ dari /', '/ke /', '/ dengan /', '/menggunakan/',
                              '/ and /', '/( or )|( for )/', '/ with /', '/ by /', '/ to /', '/ of /' );

      $pattern_plus = array('/\+/', '/ \+/', '/ \+ /');
      $pattern_except = array('/~/', '/ ~/', '/ ~ /');

      $keys = preg_replace($pattern_reject, ' ', $keys);

      $keys = preg_replace($pattern_plus, ' +', $keys);
      $keys = preg_replace($pattern_except, ' ~', $keys);
      $akey = explode(" ", $keys);

      $stringkriteria = "";
      $cnt = 0;
      $num = count($akey);
  		foreach ($akey as $k) {
  			if( strlen( trim( $k ) ) > 1 ) {
          if($cnt==0) {
            $first = "";
          } else {
            $first = "OR ";
          }
  				if( strpos($k, "+") !== false ){
  					$k = trim( str_replace("+", "", $k) );
  					$stringkriteria .= "AND " . $field . " LIKE '%$k%' ";
  				} elseif( strpos($k, "~") !== false ){
  					$k = trim( str_replace("~", "", $k) );
            if( $num <= 2 ){
              $and = "";
            } else {
              $and = "AND ";
            }
  					$stringkriteria .= $and . $field . " NOT LIKE '%$k%' ";
  				} else {
  					$stringkriteria .= $first . $field . " LIKE '%$k%' ";
  				}
  			}
        $cnt++;
  		}
    	return $stringkriteria;
    }





}
