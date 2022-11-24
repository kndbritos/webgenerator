<?php
session_start();
if(isset($_SESSION['email'])){
	header("Location: panel.php");
}
$mensaje='';
if(isset($_GET['login'])){
	$email=$_GET['email'];
	$pass=$_GET['pass'];
	if($email=="admin@server.com" && $pass=="serveradmin"){
		$mensaje='Bienvenido';
		session_start();
		$_SESSION['email']="admin@server.com";
		$_SESSION['password']="serveradmin";
		header("Location: paneladmin.php");
	}else{
	include 'credentials.php';
	$bd = mysqli_connect(HOST,USER,PASS,BD);
	

	$sql  = "SELECT * FROM Usuarios";
	$resultado=mysqli_query($bd,$sql);
	if(!empty($resultado) AND mysqli_num_rows($resultado)>0){
		while($fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
			if($fila['email']==$email && $fila['password']==$pass){
				$mensaje='Bienvenido';
				session_start();
				$_SESSION['idUsuario']=$fila['idUsuario'];
				$_SESSION['email']=$fila['idUsuario'];
				header("Location: panel.php");
			}else{
				$mensaje='Usuario/Contraseña incorrectas';
			}
		}
	}else{
		$mensaje='No existe este usuario, por favor registrarse.';
	}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<h1 align="center">Web Generator Candela Britos</h1>
	<form action="">
		<center>
		<p>Email <input type="text" name="email" placeholder="Email"></p>
		<p>Password <input type="password" name="pass" id=""></p>
		<input type="submit" value="Login" name="login">
	</center>
	</form>
	<center><a href="register.php">¿Aun no tienes cuenta?</a></center>
	<div>
		<?php
			echo $mensaje;
		?>
	</div>
</body>
</html>
