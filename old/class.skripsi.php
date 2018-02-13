<?php

class Skripsi {

public $judul;	
public $author;	//object Author
public $id_skripsi;
public $class;
public $adclass;
public $tahun;
public $nim;
public $tipe;
public $abstrak;
public $jumlah_ex;

public $db;

function Skripsi( $id ){

	$this->db = new MySQLDB();

	$sql = "SELECT *, COUNT(*) jumlaheks 
			FROM skripsi WHERE id_skripsi='".$id."'
			GROUP BY id_skripsi";

	$this->db->execQuery( $sql );
	$this->db->next();

	$this->id_skripsi = $this->db->getColumn('id_skripsi');
	$this->judul = $this->db->getColumn('judul');
	$this->class = $this->db->getColumn('class');
	$this->tahun = $this->db->getColumn('tahun');
	$this->nim = $this->db->getColumn('nim');
	$this->abstrak = $this->db->getColumn('abstrak');
	$this->jumlah_ex = $this->db->getColumn('jumlaheks');

	$sql = "SELECT * FROM bukuauthor LEFT JOIN author USING (id_author) 
			WHERE id_buku='".$this->id_skripsi."' 
			AND tipe='S'
			ORDER BY urut";

	$this->db->execQuery( $sql );

	$this->author = array();
	while ( $this->db->next() ) {
		$this->author[] = array( 'namadepan' => $this->db->getColumn('nama_depan'),
								 'namabelakang' => $this->db->getColumn('nama_belakang'),
								 'singkatan' => $this->db->getColumn('singkatdepan'),
								 'id' => $this->db->getColumn('id_author'));
	}


	$this->adclass = strtoupper(substr( $this->author[0]['namadepan'], 0, 3 ))." ".
					 strtolower(substr( $this->judul, 0, 1 ));


	$this->db->close();

}

function gotSearch(){
	$this->db = new MySQLDB();
	$this->db->execQuery( "UPDATE skripsi SET searched=searched+1 WHERE id_skripsi='".$this->id_skripsi."'");
	$this->db->close();
}

	
}

?>