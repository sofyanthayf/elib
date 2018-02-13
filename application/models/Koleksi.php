<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koleksi extends CI_Model {

    public $data;

    public function __construct() {
        parent::__construct();
    }


    function queryBuku( $kriteria ){

    	// $sql = "SELECT tipe, id_buku, tahun, judul,
    	// 			   IF(nama IS NULL, publisher, nama) namaauthor,
    	// 			   namaauthor1, namaauthor2, namaauthor3, namaauthor4

    	// $sql = "SELECT tipe, id_buku, tahun, judul
      //   			FROM
      //   				(SELECT DISTINCT id_buku, id, judul, tahun, tipe, publisher
      //   					FROM buku LEFT JOIN publisher USING (id_publisher)
      //   					GROUP BY id_buku) b
      //   			LEFT JOIN
      //   				(SELECT id_author, id_buku,
      //   					IF(nama_belakang='', nama_depan, nama_belakang) nama,
      //   					CONCAT(nama_depan,' ',nama_belakang) namaauthor1
      //   					FROM bukuauthor LEFT JOIN author USING (id_author)
      //   						WHERE urut=1
      //   						AND tipe='B' OR tipe='E') a1
      //   			USING(id_buku)
      //   			LEFT JOIN
      //   				(SELECT id_author, id_buku,
      //   					CONCAT(nama_depan,' ',nama_belakang) namaauthor2
      //   					FROM bukuauthor LEFT JOIN author USING (id_author)
      //   						WHERE urut=2
      //   						AND tipe='B' OR tipe='E') a2
      //   			USING(id_buku)
      //   			LEFT JOIN
      //   				(SELECT id_author, id_buku,
      //   					CONCAT(nama_depan,' ',nama_belakang) namaauthor3
      //   					FROM bukuauthor LEFT JOIN author USING (id_author)
      //   						WHERE urut=3
      //   						AND tipe='B' OR tipe='E') a3
      //   			USING(id_buku)
      //   			LEFT JOIN
      //   				(SELECT id_author, id_buku,
      //   					CONCAT(nama_depan,' ',nama_belakang) namaauthor4
      //   					FROM bukuauthor LEFT JOIN author USING (id_author)
      //   						WHERE urut=4
      //   						AND tipe='B' OR tipe='E') a4
      //   			USING(id_buku)
      //   			WHERE ".$kriteria.
      //   			"ORDER BY tahun DESC, judul";
      $books = array();

      $sql_count = "SELECT COUNT(*) jumlah FROM buku WHERE ".$kriteria;
      $query = $this->db->query( $sql_count );
      $books = $query->row_array();

      $sql_books = "SELECT id, id_buku, kode_ex, class, judul, tahun, isbn, tipe,
                           status, sinopsis, keywords, searched
                      FROM buku LEFT JOIN publisher USING (id_publisher)
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul";
      $query = $this->db->query( $sql_books );
      $books['buku'] = $query->result_array();

      $i = 0;
      foreach ($books['buku'] as $book) {
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
