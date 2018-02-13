<?php

if( !isset( $_GET['c'] ) ) {
	setcookie("catalog","1");
} else {
	setcookie("catalog");
}

header("location: index.php");

?>