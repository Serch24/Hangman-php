<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ahorcado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$win = false;

/*Mensaje de bienvenida, crea la cookie de inicio*/
if (!isset($_COOKIE["inicio"])) {
    header("Location:Palabras.php");
} else {
    echo "<h1 class='bienvenida'>Adivina la palabra</h1>";
    if(isset($_COOKIE['error'])){
        echo "<h1 class='cant-vida'>Vidas: ". $_COOKIE['error']. "</h1>";
    }else{
        echo "<h1 class='cant-vida'>Vidas: 5</h1>";
    }
}

/*Determina si las dos cadenas son iguales y ponde WIN en true*/
if (isset($_COOKIE["guiones"], $_COOKIE["palabra"])) {
    $tmp_guiones = $_COOKIE["guiones"];
    $tmp_palabra = $_COOKIE["palabra"];
    if (strcmp($tmp_guiones, $tmp_palabra) == 0) {
        $win = true;
    }
}

/*Muestra los guiones y caracteres si se ha adivinado la letra*/
if (isset($_COOKIE["guiones"])) {
    echo "<div class='guiones'>";
    for ($i = 0; $i < strlen($_COOKIE["guiones"]); $i++) {
        echo "<p>".substr($_COOKIE["guiones"], $i, 1)."</p>";
    }
    echo "</div>";
}

/*Si se equivoca en escribir una palabra muestra un mensaje de error y elimina
 * la cookie de error_actived para que no aparezca mas el mensaje de error.
 * */
if (isset($_COOKIE["error_actived"])) {
    if ($_COOKIE["error"] == 0) {
        echo "<h1 class='todo-cambia'>Pierdes todas las vidas!!!</h1>"; ?>
                     <form method="POST" action="Palabras.php">
                        <input class='form-reiniciar' type="submit" name="reiniciar" value="reiniciar" autofocus>
                     </form>
                  <?php
    } else {
        $vidas = $_COOKIE["error"];
        echo "<h1 class='error'>Te has equivocado, te quedan $vidas vidas.</h1>";
        setcookie("error_actived", "", time() - 1);
    }
}

if ($win) {
    echo "<div class='todo-cambia'>Ganaste!!!!!!!</div>"; ?>
                     <form method="POST" action="Palabras.php">
                        <input class='form-reiniciar' type="submit" name="reiniciar" value="reiniciar" autofocus>
                     </form>
                  <?php
} else {
     ?>
  <form  class="form-inicio" method="POST" action="Palabras.php">
       <input type="text" name="letra" placeholder="escribe algo"  maxlength="1" required autofocus>
     <input type="submit" name="enviar" value="enviar"> 
  </form>

<?php
}
?>

</body>
</html>
