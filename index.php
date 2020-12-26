<?php
   ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ahorcado</title>
</head>
<body>
<?php
   include_once("Palabras.php");

	$mostrar = new Palabras();
	$mostrar->mostrarPalabra();
   $mostrar->cookie_palabra();
   $mostrar->palabra_guion();
   ?>
</body>
</html>
<?php
   ob_flush();
?>
