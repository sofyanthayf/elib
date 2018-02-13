<?php

class Buku {

public $judul;	
public $author;	//object Author
public $id_buku;
public $class;
public $adclass;
public $tahun;
public $isbn;
public $tipe;
public $sinopsis;
public $publisher;
public $id_publisher;
public $jumlah_ex;

public $db;

function Buku( $idbuku ){

	$this->db = new MySQLDB();

	$sql = "SELECT *, COUNT(*) jumlaheks 
			FROM buku LEFT JOIN publisher USING(id_publisher) 
			WHERE id_buku='".$idbuku."'
			GROUP BY id_buku";

	$this->db->execQuery( $sql );
	$this->db->next();

	$this->id_buku = $this->db->getColumn('id_buku');
	$this->judul = $this->db->getColumn('judul');
	$this->class = $this->db->getColumn('class');
	$this->tahun = $this->db->getColumn('tahun');
	$this->isbn = $this->db->getColumn('isbn');
	$this->tipe = $this->db->getColumn('tipe');
	$this->sinopsis = $this->db->getColumn('sinopsis');
	$this->jumlah_ex = $this->db->getColumn('jumlaheks');

	$this->publisher = $this->db->getColumn('publisher');
	$this->id_publisher = $this->db->getColumn('id_publisher');
	$this->tempat = $this->db->getColumn('tempat');

	$sql = "SELECT * FROM bukuauthor LEFT JOIN author USING (id_author) 
			WHERE id_buku='".$this->id_buku."'
			AND tipe='B' OR tipe='E' 
			ORDER BY urut";

	$this->db->execQuery( $sql );

	$this->author = array();
	while ( $this->db->next() ) {
		$this->author[] = array( 'namadepan' => $this->db->getColumn('nama_depan'),
								 'namabelakang' => $this->db->getColumn('nama_belakang'),
								 'singkatan' => $this->db->getColumn('singkatdepan'),
								 'id' => $this->db->getColumn('id_author'));
	}


	if( count( $this->author ) > 0  ) {
		$this->adclass = strtoupper(substr( $this->author[0]['namabelakang'], 0, 3 ))." ".
						 strtolower(substr( $this->judul, 0, 1 ));
	} else {
		$this->adclass = strtoupper(substr( $this->publisher, 0, 3 ))." ".
						 strtolower(substr( $this->judul, 0, 1 ));
	}


	$this->db->close();

}

function gotSearch(){
	$this->db = new MySQLDB();
	$this->db->execQuery( "UPDATE buku SET searched=searched+1 WHERE id_buku='".$this->id_buku."'");
	$this->db->close();
}

	
}

?>