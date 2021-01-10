<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ahorcado</title>
</head>
<body>
<?php
$win = false;
if (!isset($_COOKIE["inicio"])) {
    header("Location:Palabras.php");
} else {
    echo "<h1>Bienvenido, Adivina la palabra</h1>";
}

if (isset($_COOKIE["guiones"], $_COOKIE["palabra"])) {
    $tmp_guiones = $_COOKIE["guiones"];
    $tmp_palabra = $_COOKIE["palabra"];
    if (strcmp($tmp_guiones, $tmp_palabra) == 0) {
        $win = true;
    }
}

if (isset($_COOKIE["guiones"])) {
    for ($i = 0; $i < strlen($_COOKIE["guiones"]); $i++) {
        echo substr($_COOKIE["guiones"], $i, 1) . "   ";
    }
}

if ($win) {
    echo "<h1>Ganaste!!!!!!!</h1>"; ?>
                     <form method="POST" action="Palabras.php">
                        <input type="submit" name="reiniciar" value="reiniciar" autofocus>
                     </form>
                  <?php
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
