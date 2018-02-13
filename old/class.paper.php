<?php

class Paper {

public $judul;	
public $id_paper;
public $tipe;
public $abstrak;
public $halamanawal;
public $halamanakhir;

public $author;	
public $jurnal; //object Jurnal

public $db;

function Paper( $id ){

	$this->db = new MySQLDB();

	$sql = "SELECT * FROM paper LEFT JOIN jurnal USING(id_jurnal) 
			WHERE id_paper='".$id."'";
//echo $sql;

	$this->db->execQuery( $sql );
	$this->db->next();

	$this->id_paper = $this->db->getColumn('id_paper');
	$this->judul = $this->db->getColumn('judul');
	$this->tipe = $this->db->getColumn('tipe');
	$this->abstrak = $this->db->getColumn('abstrak');
	$this->halamanawal = $this->db->getColumn('awal');
	$this->halamanakhir = $this->db->getColumn('akhir');

	$this->jurnal = new Jurnal($this->db->getColumn('id_jurnal'));

	$this->author = array();
	$sqla = "SELECT * FROM bukuauthor LEFT JOIN author USING (id_author) 
			 WHERE id_buku='".$this->id_paper."' 
			 AND tipe='P' 
			 ORDER BY urut";
			 
	$this->db->execQuery( $sqla );
	while ( $this->db->next() ) {
		$this->author[] = array( 'namadepan' => $this->db->getColumn('nama_depan'),
								 'namabelakang' => $this->db->getColumn('nama_belakang'),
								 'singkatan' => $this->db->getColumn('singkatdepan'),
								 'id' => $this->db->getColumn('id_author'));
	}


	$this->db->close();

}

function gotSearch(){
	$this->db = new MySQLDB();
	$this->db->execQuery( "UPDATE paper SET searched=searched+1 WHERE id_paper='".$this->id_paper."'");
	$this->db->close();
}

	
}

?>