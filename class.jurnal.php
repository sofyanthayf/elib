<?php

class Jurnal {

public $nama;
public $class;
public $adclass;
public $volume;
public $nomor;
public $bulan;
public $tahun;
public $issn;
public $jumlah_ex;
public $publisher;

public $db;

function Jurnal( $id ){
	$this->db = new MySQLDB();

	$sql = "SELECT * FROM jurnal LEFT JOIN publisher USING (id_publisher) 
			WHERE id_jurnal='".$id."'";

	$this->db->execQuery( $sql );
	$this->db->next();

	$this->class = $this->db->getColumn('class');
	$this->nama = $this->db->getColumn('nama');
	$this->volume = $this->db->getColumn('volume');
	$this->nomor = $this->db->getColumn('nomor');
	$this->bulan = $this->db->getColumn('bulan');
	$this->tahun = $this->db->getColumn('tahun');
	$this->issn = $this->db->getColumn('issn');

	$this->publisher = array( "nama" => $this->db->getColumn('publisher'),
							  "kota" => $this->db->getColumn('kota'),
							  "negara" => $this->db->getColumn('negara')
							);

}



}

?>