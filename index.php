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

   
   if($_SERVER['REQUEST_METHOD'] == 'POST' && FALSE){
      echo "<p>u win</p>"; 
   }else{
?>
  <form method="POST" action="Palabras.php">
      <br><input type="text" name="letra" placeholder="escribe algo"  maxlength="1" required autofocus>
      <button>enviar</button>
  </form>

<?php
   }
?>

</body>
</html>
