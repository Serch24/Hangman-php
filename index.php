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
   if(isset($_GET['letra'])){
       if(!empty($_GET['letra'])) {
           $mostrar->comprobar_palabra($_GET['letra']);
       }else{
         echo "<h1>Hay un campo vacio</h1>";
       }
   }
?>
  <form method="GET" action="<?php echo $_SERVER['PHP_SELF']?>">
      <input type="text" name="letra" placeholder="escribe algo" autofocus>
      <button>enviar</button>
  </form>
<?php

   ?>
</body>
</html>
<?php
   ob_flush();
?>
