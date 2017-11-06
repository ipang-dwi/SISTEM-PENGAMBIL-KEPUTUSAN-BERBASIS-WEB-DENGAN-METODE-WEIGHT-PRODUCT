<?php
	@session_start();
	$_SESSION['judul'] = 'SPK WP GITAR';
	$_SESSION['welcome'] = 'SISTEM PENGAMBIL KEPUTUSAN BERBASIS WEB DENGAN METODE WEIGHT PRODUCT';
	$_SESSION['by'] = 'R1O';
	$mysqli = new mysqli('localhost','root','1717','spk-wp');
	if($mysqli->connect_errno){
		echo $mysqli->connect_errno." - ".$mysqli->connect_error;
		exit();
	}
?>