<?php
session_start();
if(!isset($_SESSION['email'])){
	header("Location: login.php");
}
$mensaje='';

if(isset($_POST['boton'])){
	if($_POST["dominio"]==""){
		$msg='Falta el dominio';
	}else{
		$dominio=$_SESSION['idUsuario'].$_POST["dominio"];
		include 'credentials.php';
		$bd = mysqli_connect(HOST,USER,PASS,BD);
		$sql1 = "SELECT * FROM webs";
		$resultado = mysqli_query($bd,$sql1);
		$existe=true;
		if(mysqli_num_rows($resultado)>0){
			while($f=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
				if($f['dominio']==$dominio){
					$mensaje='El dominio ya esta en uso.';
					$existe=false;
				}	
			}
		}
		if($existe){
			$dia=date("Y-m-d");
			$id=$_SESSION['idUsuario'];
			$sql2='INSERT INTO webs (idUsuario,dominio,fechaCreacion) VALUES ("'.$_SESSION["idUsuario"].'","'. $dominio.'", "'.$dia.'")';
			if(mysqli_query($bd,$sql2)){
				$mensaje='Dominio registrado!';
				echo shell_exec('./wix.sh ../'.$dominio);
				echo $dominio;
			}else{
				$mensaje="Error: No se pudo registrar";
			}
		}
	}
}
include_once 'credentials.php';
$bd = mysqli_connect(HOST,USER,PASS,BD);
$sql3 = "SELECT * FROM webs";
$resultado2 = mysqli_query($bd,$sql3);
$listar="<table>";
if(mysqli_num_rows($resultado2)>0){
	while($f=mysqli_fetch_array($resultado2,MYSQLI_ASSOC)){
		if($f['idUsuario']==$_SESSION['idUsuario']){
			$listar.='<tr><td><a href="../'.$f["dominio"].'">'.$f["dominio"].'</a></td><td><a href="com.php?zip='.$f["dominio"].'">Descargar web</a></td><td><a href="delete.php?dominio='.$f["dominio"].'">Eliminar web</a></td></tr>';
		}
	}
}

$listar.="</table>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<center>
		<h1>Bienvenido al panel!</h1>
		<a href="logout.php">Cerrar la sesión de <?php echo $_SESSION['idUsuario'];?></a>
		<label for="formulario"><h2>Generar Web de: </h2></label>
		<form method="post" id="formulario">
			<input type="text" name="dominio" placeholder="Dominio de la Web" id="">
			<input type="submit" name="boton" value="Crear Web" id="">
		</form>
		<div>
			<?php echo $mensaje; ?>
		</div>
		<?php echo $listar; ?>
	</center>
</body>
</html>