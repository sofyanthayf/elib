<?php


function queryBuku( $kriteria ){
	$hasil = array();

	$sql = "SELECT tipe, id_buku, tahun, judul,
				   IF(nama IS NULL, publisher, nama) namaauthor, 
				   namaauthor1, namaauthor2, namaauthor3, namaauthor4
			FROM 
				(SELECT DISTINCT id_buku, id, judul, tahun, tipe, publisher 
					FROM buku LEFT JOIN publisher USING (id_publisher) 
					GROUP BY id_buku) b 
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					IF(nama_belakang='', nama_depan, nama_belakang) nama,
					CONCAT(nama_depan,' ',nama_belakang) namaauthor1
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=1 
						AND tipe='B' OR tipe='E') a1 
			USING(id_buku)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor2
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=2 
						AND tipe='B' OR tipe='E') a2 
			USING(id_buku) 
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor3
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=3 
						AND tipe='B' OR tipe='E') a3
			USING(id_buku) 
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor4
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=4 
						AND tipe='B' OR tipe='E') a4 
			USING(id_buku) 
			WHERE ".$kriteria.
			"ORDER BY namaauthor, tahun DESC, judul";
//echo $sql;
	$db = new MySQLDB();
	$db->execQuery( $sql );
	while ( $db->next() ) {
		$hasil[] = array('tipe' => $db->getColumn('tipe'),
						 'id' => $db->getColumn('id_buku') );
	}

	$db->close();

	return $hasil;
}


function queryPaper( $kriteria ){
	$hasil = array();

	$sql = "SELECT tipe, id_paper, tahun, judul, namaauthor, 
				   namaauthor1, namaauthor2, namaauthor3, namaauthor4
			FROM 
				(SELECT DISTINCT id_paper, judul, jurnal.tipe tipe, tahun
					FROM paper LEFT JOIN jurnal USING (id_jurnal) 
					GROUP BY id_paper) b 
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					IF(nama_belakang='', nama_depan, nama_belakang) namaauthor,
					CONCAT(nama_depan,' ',nama_belakang) namaauthor1
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=1 AND tipe='P') a1 
			ON (a1.id_buku=id_paper)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor2
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=2 AND tipe='P') a2 
			ON (a2.id_buku=id_paper)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor3
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=3 AND tipe='P') a3
			ON (a3.id_buku=id_paper)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor4
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=4 AND tipe='P') a4 
			ON (a4.id_buku=id_paper)
			WHERE ".$kriteria.
			"ORDER BY tipe DESC, namaauthor, tahun DESC, judul";
//echo $sql;
	$db = new MySQLDB();
	$db->execQuery( $sql );
	while ( $db->next() ) {
		$hasil[] = array('tipe' => $db->getColumn('tipe'),
						 'id' => $db->getColumn('id_paper') );
	}

	$db->close();


	return $hasil;
}

function querySkripsi( $kriteria ){
	$hasil = array();

	$sql = "SELECT 'S' tipe, id_skripsi, tahun, judul, namaauthor, 
				   namaauthor1, namaauthor2, namaauthor3, namaauthor4
			FROM 
				(SELECT DISTINCT id_skripsi, id, judul, tahun
					FROM skripsi 
					GROUP BY id_skripsi) b 
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					IF(nama_belakang='', nama_depan, nama_belakang) namaauthor,
					CONCAT(nama_depan,' ',nama_belakang) namaauthor1
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=1 AND tipe='S') a1 
			ON (a1.id_buku=id_skripsi)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor2
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=2 AND tipe='S') a2 
			ON (a2.id_buku=id_skripsi)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor3
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=3 AND tipe='S') a3
			ON (a3.id_buku=id_skripsi)
			LEFT JOIN 
				(SELECT id_author, id_buku, 
					CONCAT(nama_depan,' ',nama_belakang) namaauthor4
					FROM bukuauthor LEFT JOIN author USING (id_author) 
						WHERE urut=4 AND tipe='S') a4 
			ON (a4.id_buku=id_skripsi)
			WHERE ".$kriteria.
			"ORDER BY namaauthor, tahun DESC, judul";
//echo $sql;
	$db = new MySQLDB();
	$db->execQuery( $sql );
	while ( $db->next() ) {
		$hasil[] = array('tipe' => $db->getColumn('tipe'),
						 'id' => $db->getColumn('id_skripsi') );
	}

	$db->close();

	return $hasil;
}

function queryLaporan(){
	$hasil = array();

	return $hasil;
}

function keywords( $field, $keys ){
	if( strpos($keys, "\\") !== false ||
		strpos($keys, "'") !== false   ) {

		$keys = stripslashes($keys);
		$keys = str_replace("\"", "", $keys);
		$keys = str_replace("'", "", $keys);
		$stringkriteria = $field." LIKE '%$keys%' ";
		
	} else {

		$keys = str_replace("+ ", "+", $keys);
		$keys = str_replace("~ ", "~", $keys);

		$keys = str_replace("+", " +", $keys);
		$keys = str_replace("~", " ~", $keys);
		$keys = str_replace("  ", " ", $keys);
		$akey = explode(" ", $keys);

		$keys = str_replace("+", "", $keys);
		$keys = str_replace("~", "", $keys);
		$stringkriteria = $field." LIKE '%$keys%' ";
	
		foreach ($akey as $k) {
			if( trim( $k ) != "" ) {
				if( strpos($k, "+") !== false ){
					$k = trim( str_replace("+", "", $k) );
					$stringkriteria .= "AND ".$field." LIKE '%$k%' ";
				} elseif( strpos($k, "~") !== false ){
					$k = trim( str_replace("~", "", $k) );
					$stringkriteria .= "AND ".$field." NOT LIKE '%$k%' ";
				} else {
					$stringkriteria .= "OR ".$field." LIKE '%$k%' ";		
				}			
			}
		}

	}

	return $stringkriteria;
}

function tampilkanHasil( $hasil ){

	$kat = array( 'B' => array( 'Buku', 0 ),
				  'E' => array( 'E-Book', 0 ),
				  'J' => array( 'Jurnal', 0 ),
				  'C' => array( 'Prosiding', 0 ),
				  'S' => array( 'Skripsi/Tugas Akhir', 0 ),
				  'L' => array( 'Laporan', 0 )
				);

	if( count($hasil) == 0 ) {
		echo "<h4>Tidak ditemukan</h4>";
	} else {
		foreach ($hasil as $h ) {	
			// hitung jumlah tiap kategori
			$kat[ $h['tipe'] ][1]++;
			//echo $h['tipe']."-".$h['id']."<br>";
		}

?>

<div class="bs-component">
	<ul id="resulttab" class="nav nav-tabs">

<?php

		$tab = 1;
		$tip = '';
		foreach ($hasil as $h ) {
			
			if( $h['tipe'] != $tip ){

				if( $tab==1 ) {
					$act =  "class=\"active\"";
				} else {
					$act =  "";
				}

				echo "<li ".$act."><a data-toggle=\"tab\" href=\"#restab".$tab."\">".$kat[ $h['tipe'] ][0].
					 " (".$kat[ $h['tipe'] ][1].")</a></li>";

				$tip = $h['tipe'];
				$tab++;
			}
		}

?>

	</ul>

<div class="tab-content clearfix">
    <div id="restab1" class="tab-pane fade in active">
		<table id="tabelhasil" class="table table-hover">
		<thead>
			<tr>
				<th><div class='text-right'>No.</div></th>
				<th><div class='text-center'>Pustaka</div></th>
				<th><div class='text-center' style='width:80px;'>Class</div></th>
				<th><div class='text-center'>Status</div></th>
			<tr>
		</thead>
		<tbody>
		

<?php

$n = 0;
$t = 1;
$tip = $hasil[0]['tipe'];

foreach ($hasil as $h ) {

	if( $h['tipe'] != $tip ){
		$tip = $h['tipe'];
		$t++;
		$n = 0;

?>

		</tbody>
		</table>
	</div>

	<div id="restab<?php echo $t; ?>" class="tab-pane fade">
		<table id="tabelhasil" class="table table-hover">
		<thead>
			<tr>
				<th><div class='text-right'>No.</div></th>
				<th><div class='text-center'>Pustaka</div></th>
				<th><div class='text-center' style='width:80px;'>Class</div></th>
				<th><div class='text-center'>Status</div></th>
			<tr>
		</thead>
		<tbody>

<?php

	}

	$output="<p class='hangingindent'>";

	switch ( $h['tipe'] ) {
		case 'B':
			$buku = new Buku( $h['id'] );
			$class = $buku->class;
			if( count( $buku->author ) > 0  ) {
				$output .= stringAuthors( $buku->author );	
			} else {
				$output .= $buku->publisher;
			}

			if( !empty( $buku->tahun ) && $buku->tahun != 0 ){
				$output .= " (".$buku->tahun.") "; 
			} else {
				if( count($buku->author) == 0 || !empty($buku->publisher) )	$output .= ", ";
			}

			$output .= "<b>".$buku->judul."</b>";

			if( !empty( $buku->publisher ) ) $output .= ", ".$buku->publisher.", ".$buku->tempat.".";

			$output .= "<div class='isbn'>ISBN: ".$buku->isbn."</div>";

			$adclass = $buku->adclass;

			$datadetail = "data-tipe=\"".$buku->tipe."\"
						   data-id=\"".$buku->id_buku."\"
						   data-judul=\"".$buku->judul."\"
						   data-publ=\"".$buku->publisher."\"
						   data-tahun=\"".$buku->tahun."\"
						   data-auth=\"".stringListAuthor($buku->author)."\"
						   data-isbn=\"ISBN: ".$buku->isbn."\"
						   data-klas=\"".$buku->class."\"
						   data-addklas=\"".$adclass."\"";


			$buku->gotSearch();
			break;
		
		case 'J':
		case 'C':
			$paper = new Paper( $h['id'] );
			$class = $paper->jurnal->class;

			$output .= stringAuthors( $paper->author );	
			$output .= " (".$paper->jurnal->tahun."), "; 
			$output .= "<b>".$paper->judul."</b>, ";
			$output .= "<i>".$paper->jurnal->nama."</i>, ";

			if( $paper->tipe == 'J') $output .= " vol.".$paper->jurnal->volume.",no.".$paper->jurnal->nomor.", ";

			$output .= "pp.".$paper->halamanawal."-".$paper->halamanakhir.".";

			$output .= "<div class='isbn'>ISSN: ".$paper->jurnal->issn."</div>";

			$adclass = $paper->jurnal->adclass;

			$datadetail = "data-tipe=\"".$paper->tipe."\"
						   data-id=\"".$paper->id_paper."\"
						   data-judul=\"".$paper->judul."\"
						   data-publ=\"".$paper->jurnal->publisher['nama']."\"
						   data-tahun=\"".$paper->jurnal->tahun."\"
						   data-auth=\"".stringListAuthor($paper->author)."\"
						   data-isbn=\"ISSN: ".$paper->jurnal->issn."\"
						   data-klas=\"".$paper->jurnal->class."\"
						   data-addklas=\"".$adclass."\"";

			$paper->gotSearch();
		
			break;
	
		case 'S':
			$skripsi = new Skripsi( $h['id'] );
			$class = $skripsi->class;

			$output .= stringAuthors( $skripsi->author );	
			$output .= " (".$skripsi->tahun."), "; 
			$output .= "<b>".$skripsi->judul."</b>";

			if( substr($skripsi->class,0,3) == "SKR" ) {
				$skr = 'Skripsi';
			} else {
				$skr = 'Tugas Akhir';
			}

			$output .= ", $skr, STMIK KHARISMA, Makassar.";

			$output .= "<div class='isbn'>NIM: ".$skripsi->nim."</div>";

			$adclass = $skripsi->adclass;

			$datadetail = "data-tipe=\"S\"
						   data-id=\"".$skripsi->id_skripsi."\"
						   data-judul=\"".$skripsi->judul."\"
						   data-publ=\"STMIK KHARISMA Makassar\"
						   data-tahun=\"".$skripsi->tahun."\"
						   data-auth=\"".stringListAuthor($skripsi->author)."\"
						   data-isbn=\"NIM: ".$skripsi->nim."\"
						   data-klas=\"".$skripsi->class."\"
						   data-addklas=\"".$adclass."\"";

			$skripsi->gotSearch();
			break;
	}

	$output .= "</p>";

	$n++;
	echo "<tr data-toggle=\"modal\" data-target=\"#detailPustaka\" ".$datadetail.">".
		 "	<td><div class='text-right'>$n.</class></td>".
		 "  <td>".$output."</td>".
		 "  <td><h5 class='text-center'>".$class."<br>".$adclass."</h5></td>".
		 "  <td></td>".
		 "</tr>\n";
}

?>
		</tbody>
		</table>
	</div>
</div>
</div>

<?php
	}
}


function stringAuthors( $listauthor ){

	$authorsstring = "";

	if( count( $listauthor ) >= 4 ) {
		$authorsstring .= getNama( $listauthor[0] )." et al.";
	} elseif ( count( $listauthor ) == 3 ) {
		$authorsstring .= getNama( $listauthor[0] ).", ";
		$authorsstring .= getNama( $listauthor[1] ).", ";
		$authorsstring .= getNama( $listauthor[2] );	

	} elseif ( count( $listauthor ) == 2 ) {
		$authorsstring .= getNama( $listauthor[0] )." & ";
		$authorsstring .= getNama( $listauthor[1] );	
	} else {
		$authorsstring .= getNama( $listauthor[0] );
	}

	return $authorsstring;
}


function stringListAuthor( $author ){
	$strauth = "";
	foreach ($author as $auth) {
		$strauth .= $auth['namadepan']." ".$auth['namabelakang'].";";
	}
	return $strauth;
}


function getNama( $author ){
	$l1 = "<span class='text-info' title='".$author['namadepan']." ".$author['namabelakang']."\n'>";
	$l2 = "</span>";

	if( empty( $author['namabelakang'] ) ) {
		$nama = $author['namadepan'];
	} else {
		$nama = $author['namabelakang'].", ".$author['singkatan'];
	}

	return $l1.$nama.$l2;
}


function loggedIn(){
	if( $_SESSION['libroom'] == "admin" ){
		$who = 'adm';
	} else {
		$who = $_SESSION['who'];
	}

	if( isset( $_COOKIE['catalog'] ) && $_COOKIE['catalog'] == 1 ){
		$_SESSION['lib_last_ip'] = 'CATALOG';
	}

	$db = new MySQLDB();
	$sql  = "INSERT INTO logins SET 
				user='".$_SESSION['uid']."',
				nama='".$_SESSION['nama']."',
				who='".$who."',
				login_time=NOW(),
				ip_address='".$_SESSION['lib_last_ip']."',
				id=MD5(CONCAT(user,login_time))";

	$db->execQuery( $sql );
	$db->close();

	$_SESSION['saved'] = '1'; 	// flag, session sudah di simpan, mencegah logging berulang

}


?>