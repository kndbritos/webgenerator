<?php
session_start();
if(isset($_SESSION['email'])){
	header("Location: panel.php");
}
$mensaje='';
if(isset($_GET['login'])){
	include 'credentials.php';
	$bd = mysqli_connect(HOST,USER,PASS,BD);
	$email=$_GET['email'];
	$pass=$_GET['pass'];
	$pass2=$_GET['pass2'];
	$sql  = "SELECT * FROM Usuarios";
	$resultado=mysqli_query($bd,$sql);
	var_dump($bd);
	if(mysqli_num_rows($resultado)>0){
		while($fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
			if($fila['email']==$email){
				$mensaje='Este email esta en uso, prueba otro!';
			}else{
				if($pass==$pass2){
					$dia=date("Y-m-d");
					$sql='INSERT INTO Usuarios (email,password,fechaRegistro) VALUES ("'.$email.'","'.$pass.'","'.$dia.'")';
					$response=mysqli_query($bd,$sql);
					if($response){
						$mensaje='Se creo exitosamente su usuario.';
						header("Location: login.php");
					}else{
						$mensaje='No se pudo crear su usuario';
					}
				}else{
					$mensaje='No hay similitud encontrada entre las contraseñas.';
				}
			}
		}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro</title>
</head>
<body>
	<h1 align="center">Registro de cuenta.</h1>
	<form action="register.php" method="GET">
		<p align="center">Email <input type="text" name="email" placeholder="Email"></p>
		<p align="center">Password <input type="password" name="pass" id=""></p>
		<p align="center">Repetir Password <input type="password" name="pass2" id=""></p>
		<center><input type="submit" value="Registrar" name="login"></center>
	</form>
	<div>
		<?php
			echo $mensaje;
		?>
	</div>
</body>
</html>