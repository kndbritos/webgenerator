<?php 
	session_start();
	$usuario = $_SESSION['id'];
	$estado = true;
	if (!isset($usuario)) {
		$estado = false;
		header("Location: login.php");
	}
?>

<?php
    include 'credentials.php';
	$bd = mysqli_connect(HOST,USER,PASS,BD);
	$dominio = $_GET['dominio'];
	// $Connection = mysqli_connect("mattprofe.com.ar", "3837", "3837", "3837");
	$Sql = mysqli_query($bd, "DELETE FROM `webs` WHERE dominio = '$dominio'");
	header("Location: panel.php");
?>