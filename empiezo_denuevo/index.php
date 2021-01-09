<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ahorcado</title>
</head>
<body>
<?php
echo "<pre>";
print_r($_COOKIE);
echo "<pre>";
if (!isset($_COOKIE["inicio"])) {
    header("Location:Palabras.php");
} else {
    echo "<h1>Bienvenido</h1>";
}

if (isset($_COOKIE["guiones"])) {
    for ($i = 0; $i < strlen($_COOKIE["guiones"]); $i++) {
        echo substr($_COOKIE["guiones"],$i,1) . "   ";
    }
    echo "<br>" . $_COOKIE["palabra"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && false) {
    echo "<p>u win</p>";
} else {
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
