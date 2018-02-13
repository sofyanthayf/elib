<?php
/**
*	class MySQLDB
*	untuk melakukan koneksi dan query database MySQL
*	@author	Sofyan Thayf, 2010
*/
class MySQLDB {

	private $dh;
	private $du;
	private $dp;
	private $db;
	
	private $res;
	private $row;
	private $jmlrow;
	private $colslist = array();
	private $query;
	
	/**  constructor   */
	function MySQLDB(){
		/** include database attributes setting */
		include("inc.dbconf.php");
		
		/** lakukan koneksi */
		$c = @mysql_connect( $this->dh, $this->du, $this->dp );
		if(!$c) {
			die( "Koneksi gagal: " . mysql_error() );
		} else {
			$d = @mysql_select_db( $this->db );
			if(!$d) {
				die( "Akses database gagal: " . mysql_error() );		
			}
		}
	}

	/**
	*	eksekusi query
	*	@param 	$qry	String query SELECT
	*/
	function execQuery( $qry ) {
		$this->query = $qry;
		$r = @mysql_query( $qry );
		if( !$r ) {
//			die( "Query gagal dilakukan: " . mysql_error() );
			die( "Query gagal dilakukan: " . mysql_error()."<br>Query: ".$this->query );
		} else {
			$this->res = $r; 
			$this->jmlrow = @mysql_num_rows( $r );
		}
	}
	
	/**
	*	fetch hasil query
	*	memberikan nilai true jika hasil query  masih tersedia
	*/
	function next() {
		$this->row = @mysql_fetch_array( $this->res );
		return $this->row;
	}
	
	/**
	*	memberikan nilai/isi field (column) hasil query setelah di fetch
	*	(eksekusi method next() terlebih dahulu)
	*
	*	@param 	$col	nama field/column atau nomor index field/column
	*/
	function getColumn( $col ) {
		if( $this->row ) {
			return $this->row[$col];
		} else {
//			die( "Fetch gagal: eksekusi method next() terlebih dahulu" );
			
// uncomment next line for debug only
			die( "Fetch gagal: eksekusi method next() terlebih dahulu"."<br>Query: ".$this->query );
		}
	}
	
	/**
	*	memberikan jumlah baris/record hasil query SELECT
	*/
	function getNumRows() {
		return $this->jmlrow;
	}
	
	/**
	*	memberikan daftar nama field/column hasil query SELECT
	*/
	function getColsList(){
		$i = 0;
		while($i < mysql_num_fields($this->res)) {
			$meta = mysql_fetch_field($this->res, $i);
			$this->colslist[$i] = $meta->name; 
			$i++;
		}
		return $this->colslist;
	}
	
	/**
	*	memberikan hasil query SELECT dalam format XML
	*/
	function getXMLData( $strdata ){
		/** ambil nama-nama column/fields */
		$clist = $this->getColsList();
	
		/** output dalam format string XML */
		$retr="<?xml version=".'"1.0"'." encoding=".'"UTF-8"?>'."\n"."<results>\n";
		while( $d = @mysql_fetch_array( $this->res ) ) {
			$retr.="<$strdata>\n";
			foreach( $clist as $cl ){
				$retr .= "<$cl>".$d[$cl]."</$cl>\n";
			}
			$retr.="</$strdata>\n\n";
		}
		$retr.="</results>\n";
		return $retr;
	}
	
	function close(){
		@mysql_close();
	}
	
} /**  end of class MySQLDB  */
?>