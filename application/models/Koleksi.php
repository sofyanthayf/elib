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

      $sql_books = "SELECT DISTINCT id, id_buku, id_publisher, kode_ex, class, judul, tahun, isbn, tipe,
                           status, sinopsis, keywords, searched
                      FROM buku LEFT JOIN publisher USING (id_publisher)
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul LIMIT $offset,20";
      $query = $this->db->query( $sql_books );
      $books['buku'] = $query->result_array();

      $i = 0;
      foreach ($books['buku'] as $book) {
        $books['buku'][$i]['author'] = $this->getAuthor($book['id_buku'], 'B');
        $books['buku'][$i]['publisher'] = $this->getPublisher($book['id_publisher']);
        // $books['buku'][$i]['publisher'] = $this->getPublisher($book, 'B');
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

      $sql_skripsi = "SELECT DISTINCT id, id_skripsi, kode_ex, class, judul, tahun, nim,
                           status, abstrak, keywords, searched
                      FROM skripsi
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul LIMIT $offset,20";
      $query = $this->db->query( $sql_skripsi );
      $skripsi['skripsi'] = $query->result_array();

      $i = 0;
      foreach ($skripsi['skripsi'] as $skr) {
        $skripsi['skripsi'][$i]['author'] = $this->getAuthor( $skr['id_skripsi'], 'S' );
        $skripsi['skripsi'][$i]['publisher'] = $this->getPublisher( 'ST002' );
        // $skripsi['skripsi'][$i]['publisher'] = $this->getPublisher($skr, 'S');
        $i++;
      }
    	return $skripsi ;
    }


    function queryPaper( $kriteria, $page = 1 ){

      $paper = array();

      $sql_count = "SELECT COUNT(*) jumlah FROM paper WHERE ".$kriteria;
      $query = $this->db->query( $sql_count );
      $paper = $query->row_array();

      $paper['jumlah_halaman'] = ceil( $paper['jumlah'] / 20 );
      if( $page > $paper['jumlah_halaman'] ) $page = 1;
      $paper['halaman'] = $page;

      $offset = ($page * 20)-20;
      if( $offset < 0 ) $offset = 0;

      $sql_paper = "SELECT id_paper, id_jurnal, judul, awal dari_hlm, akhir sampai_hlm,
                           abstrak, tipe, keywords, searched
                      FROM paper
              			  WHERE ".$kriteria. " ORDER BY tahun DESC, judul LIMIT $offset,20";
      $query = $this->db->query( $sql_paper );
      $paper['paper'] = $query->result_array();

      $i = 0;
      foreach ($paper['paper'] as $ppr) {
        $paper['paper'][$i]['author'] = $this->getAuthor($ppr, 'S');
        $paper['paper'][$i]['publication'] = $this->getJurnal($ppr);
        $i++;
      }
    	return $paper ;
    }

    function getAuthor( $id_koleksi, $tipe ){
      // switch ($tipe) {
      //   case 'B':
      //   case 'E':
      //     $krit = "id_buku='".$koleksi['id_buku']."' AND (tipe='B' OR tipe='E') ";
      //     break;
      //   case 'S':
      //     $krit = "id_buku='".$koleksi['id_skripsi']."' AND tipe='S' ";
      //     break;
      //   case 'P':
      //     $krit = "id_buku='".$koleksi['id_paper']."' AND tipe='P' ";
      //     break;
      // }

      $sql_auth = "SELECT urut, id_author, nama_depan, nama_belakang, singkatdepan
                    FROM bukuauthor LEFT JOIN author USING (id_author)
                    WHERE id_buku='$id_koleksi' AND tipe='$tipe'
                    ORDER BY urut";

      $query = $this->db->query( $sql_auth );
      return $query->result_array();
    }

    // function getAuthor( $koleksi, $tipe){
    //   switch ($tipe) {
    //     case 'B':
    //     case 'E':
    //       $krit = "id_buku='".$koleksi['id_buku']."' AND (tipe='B' OR tipe='E') ";
    //       break;
    //     case 'S':
    //       $krit = "id_buku='".$koleksi['id_skripsi']."' AND tipe='S' ";
    //       break;
    //     case 'P':
    //       $krit = "id_buku='".$koleksi['id_paper']."' AND tipe='P' ";
    //       break;
    //   }
    //
    //   $sql_auth = "SELECT urut, id_author, nama_depan, nama_belakang, singkatdepan
    //                 FROM bukuauthor LEFT JOIN author USING (id_author)
    //                 WHERE $krit  ORDER BY urut";
    //
    //   $query = $this->db->query( $sql_auth );
    //   return $query->result_array();
    // }
    //
    function getPublisher($id_publisher){
        $sql_publ = "SELECT DISTINCT publisher, kota, negara
                     FROM publisher LEFT JOIN buku USING (id_publisher)
                     WHERE id_publisher='$id_publisher'";

      $query = $this->db->query( $sql_publ );
      return $query->result_array();
    }
    // function getPublisher($koleksi, $tipe){
    //   if( $tipe == 'S' ) {   // karena publisher skripsi adalah STMIK KHARISMA
    //     $sql_publ = "SELECT DISTINCT id_publisher, publisher, kota, negara
    //                   FROM publisher
    //                   WHERE id_publisher='ST002'";
    //   } else {
    //     $sql_publ = "SELECT DISTINCT id_publisher, publisher, kota, negara
    //                  FROM publisher LEFT JOIN buku USING (id_publisher)
    //                  WHERE id_buku='".$koleksi['id_buku']."'";
    //
    //   }
    //   $query = $this->db->query( $sql_publ );
    //   return $query->result_array();
    // }

    function getJurnal($paper){
      $jurnal =  array();
      $sql_jurnal = "SELECT id_jurnal, id_publisher, volume, nomor, bulan, tahun,
                            issn, kode_ex, status
                     FROM jurnal
                     WHERE id_buku='".$paper['id_jurnal']."'";
      $query = $this->db->query( $sql_publ );
      $jurnal = $query->result_array();
      $jurnal['publisher'] = getPublisher( $jurnal['id_publisher'] );
      return $jurnal;
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
