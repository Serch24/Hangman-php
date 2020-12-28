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

   /*echo "<pre>";
   print_r($_COOKIE);
   echo "</pre>";*/

    if(isset($_COOKIE['palabra'])){
      echo "<pre>";
      print_r($_COOKIE);
      echo "</pre>";
    }   
    if(isset($_COOKIE['error'])){
         echo "</h3>Esa letra no está, pierdes un punto!</h3>"; 
         setcookie('error',1,time()-1);
    }
    if(isset($_COOKIE['win'])){
         echo "<h1>Ganaste!!!!!!!!!!!!!</h1"; 
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
