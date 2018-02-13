<?php

$keyword = addslashes($_POST['keyword']);

$hasilbuku = array();	// array('tipe','id')
$hasilskripsi = array();	// array('tipe','id')
$hasiljurnal = array();	// array('tipe','id')
$hasilprosiding = array();	// array('tipe','id')

switch ( $_POST['search_param'] ) {
	case 'all':
		if( isset( $_SESSION['uid'] ) ){
			$hasilbuku = queryBuku( keywords( 'judul', $keyword) );
			$hasilskripsi = querySkripsi( keywords('judul', $keyword) );
			$hasiljurnal = queryPaper( keywords('judul', $keyword) );

			$hasil = array_merge( $hasilbuku, $hasilskripsi, $hasiljurnal );
		} else {
			$hasil = queryBuku( "tipe='B' AND ".keywords('judul', $keyword) );
		}
		break;

	case 'buku':
		if( isset( $_SESSION['uid'] ) ){
			$hasil = queryBuku( keywords('judul', $keyword) );
		} else {
			$hasil = queryBuku( "tipe='B' AND ".keywords('judul', $keyword) );
		}
		break;

	case 'ebook':
			$hasil = queryBuku( "tipe='E' AND ".keywords('judul', $keyword) ) ;
		break;

	case 'paper':
			$hasil = queryPaper( keywords('judul', $keyword) );
		break;

	case 'skripsi':
			$hasil = querySkripsi( keywords('judul', $keyword) );
		break;

	case 'laporan':
			$hasil = queryLaporan( $_POST['keyword'] );
		break;

}

tampilkanHasil( $hasil );

?>
