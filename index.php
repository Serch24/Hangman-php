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
   if($_SERVER['REQUEST_METHOD'] == 'GET'){
	   $mostrar->mostrarPalabra();
      $mostrar->cookie_palabra();
      $mostrar->palabra_guion();
   }

   /*if(isset($_COOKIE['letra'])){
       echo "<br>".$_COOKIE['letra']."<br>";     
   }*/

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['letra'])){
            $mostrar->cookie_letra($_POST['letra']);
            $mostrar->comprobar();
            $flag = false;
      /*header("Location: /index.php");   */
        }   

   }
   
   if($_SERVER['REQUEST_METHOD'] == 'POST' && $flag){
      echo "<p>u win</p>"; 
   }else{
?>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
      <br><input type="text" name="letra" placeholder="escribe algo"  maxlength="1" required autofocus>
      <button>enviar</button>
  </form>

<?php
   }
?>

</body>
</html>
<?php
   ob_end_flush();
?>
