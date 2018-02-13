<?php
$hasilbuku = array();	
$hasilskripsi = array();
$hasilpaper = array();

$kriteria = "";

if( isset( $_POST['author'] ) && !empty( $_POST['author'] ) ) {
	$keyauthor = addslashes($_POST['author']);
	$kriteria .= "AND (".keywords( 'namaauthor1', $keyauthor ).
					   " OR (".keywords( 'namaauthor2', $keyauthor ).") ".
					   " OR (".keywords( 'namaauthor3', $keyauthor ).") ".
					   " OR (".keywords( 'namaauthor4', $keyauthor ).") ".
				 	  ") ";
}

if( isset( $_POST['judul'] )  &&  !empty( $_POST['judul'] ) ) {
	$keyjudul = addslashes($_POST['judul']);
	$kriteria .= "AND (".keywords( 'judul', $keyjudul ).") ";
}

if( isset( $_POST['dkeyword'] ) &&  !empty( $_POST['dkeyword'] ) ) {
	$keyword = addslashes($_POST['dkeyword']);
	$kriteria .= "AND (".keywords( 'keywords', $keyword ).") ";
}

$sign = array('eq'=>'=', 'gt'=>'>=', 'lt'=>'<=');

if( isset( $_POST['year_param'] ) &&  !empty( $_POST['tahun'] ) ) 
	$kriteria .= "AND tahun".$sign[ $_POST['year_param'] ]."'".$_POST['tahun']."' ";

//if( isset( $_POST['chkbuku'] ) ) array_merge( $hasil, queryBuku( "tipe='B' ".$kriteria ) );
//if( isset( $_POST['chkbuku'] ) ) array_merge( $hasil, querySkripsi( "1 ".$kriteria ) );

//echo "TEST: ".$kriteria."</br>";
if( isset( $_POST['chkbuku'] ) ) 		$hasilbuku = queryBuku( "tipe='B' ".$kriteria );
if( isset( $_POST['chkpaper'] ) )		$hasilpaper = queryPaper( "1 ".$kriteria );
if( isset( $_POST['chkskripsi'] ) )		$hasilskripsi = querySkripsi( "1 ".$kriteria );

$hasil = array_merge( $hasilbuku, $hasilpaper, $hasilskripsi  );

//print_r( $hasil );

tampilkanHasil( $hasil );


?>