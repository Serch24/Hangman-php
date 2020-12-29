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

    if(isset($_COOKIE['error'])){
         echo "<br></h3>Esa letra no está, pierdes un punto!</h3>"; 
         setcookie('error',1,time()-1);
    }

    if(isset($_COOKIE['palabra'],$_COOKIE['letra'])){
         $size_palabra = $_COOKIE['palabra'];
         $size_letra = $_COOKIE['letra'];
         if(strlen($size_palabra)=== strlen($size_letra)){
             echo "<h1>Ganaste!!!!!!!!!!!!!</h1>"; 
             ?>
             <form method="POST" action="Palabras.php">
               <input type='submit' name='reset' value='reiniciar' class='reset'>
             </form>
    <?php
         }
    }
   
   if($_SERVER['REQUEST_METHOD'] == 'POST' && FALSE){
      echo "<p>u win</p>"; 
   }else{
?>
  <form method="POST" action="Palabras.php">
      <br><input type="text" name="letra" placeholder="escribe algo"  maxlength="1" required autofocus>
     <input type="submit" name="enviar" value="enviar"> 
  </form>

<?php
   }
?>

</body>
</html>
