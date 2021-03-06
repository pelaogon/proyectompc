<?php include 'conexion.php'; ?>
<?@session_start();
if($_SESSION["autentica"] != "SIP"){
	header("Location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no"/>
	<title>MPC registros</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/jquery.dataTables.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/jquery-ui.css">
	<link rel="stylesheet" href="../css/estilo.css">

	<script src="../scripts/jquery.min.js"></script>
	<script src="../scripts/functions.js"></script>
	<script src="../scripts/prefixfree.min.js"></script>
	<script src="../scripts/jquery.dataTables.js"></script>
	<script src="../scripts/jquery-barcode.js"></script>
	<script src="../scripts/reloj.js"></script>
	<script src="../scripts/jquery-ui.js"></script>

	<script>
        function entrar(rut, visitado, empresa)
        {
          $.ajax({

            url: "procesarvisita_entrada.php",
            type: "POST",
            data: "rut="+rut+"&visitado="+visitado+"&empresa="+empresa,
            success: function(resp){
              $('#resultado').html(resp);
              return false;

            }
          });
        }
        function salir(rut)
        {
          $.ajax({
            url: "procesarvisita_salida.php",
            type: "POST",
            data: "rut="+rut,
            success: function(resp){
              $('#resultado').html(resp);
              return false;

            }
          });
        }
		$(function() {
			//autocomplete
			$(".auto").autocomplete({
				source: "search.php",
				minLength: 1
			});

		});
	</script>
</head>
<body onload="Comenzar()">
	<div id="mainWrapper">
		<header>
			<figure id="logo">
				<img src="../img/logompc.png" alt="mpc" width="100" />
			</figure>
			<div class="titulos">
				<h1>Sistema de Control de <br>Acceso y Asistencia.</h1>
			</div>
			<div class="usuario">
				<strong><?php
					$guardia = $_SESSION["usuarioactual"];
					$encontrar = mysqli_query($conexion, "SELECT nombre_guardia, apellido_guardia FROM guardia WHERE rut_guardia = '$guardia'");
					$buscar = mysqli_query($conexion, "SELECT nro_garita, jornada FROM turno_guardia WHERE rut_guardia = '$guardia'");

					$columna = mysqli_fetch_array($encontrar);
					$fila = mysqli_fetch_array($buscar);

					echo 'Guardia: '.$columna["nombre_guardia"].' '.$columna["apellido_guardia"];
				?></strong>
				<p><?php echo 'Rut: ' .$guardia; ?><br>
				<?php echo 'Garita: '.$fila["nro_garita"];?></p>
				<a href="logout.php">Cerrar Sesión</a>
			</div>

		</header>
		<h3>Módulo Guardia</h3>
		<nav>
			<ul class="nav nav-tabs">
				<li>
					<a href="index.php">Acceso Empleado</a>
				</li>
				<li>
					<a href="visita.php">Registrar Visita</a>
				</li>
				<li class="active">
					<a href="#">Acceso Visita</a>
				</li>

			</ul>
		</nav>
		<header id="titleContent">
			<h4>Acceso de Entrada y Salida Visita</h4>
			<div id="reloj"></div>

			<hr></header>
		<section>
			<article id="aRegister">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-md-8">
							<h3>Código</h3>
							<?php include 'formvisita.php'; ?>

						</div>
						<div class="col-md-2">
						</div>
					</div>
				</div>
			</article>
		</section>
	</div>
	<footer>
		<p>
			- © Copyright 2014 -
		</p>
	</footer>
</body>
</html>
