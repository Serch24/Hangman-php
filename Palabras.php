<?php
class Palabras
{
    private $palabras = [];
    private $palabra_elegida;
    private $cantidad_letras = [];
    public function __construct()
    {
        $this->palabra_elegida = "";
    }

    public function rellenar()
    {
        if (isset($_COOKIE["palabra"])) {
            return;
        } else {
            $fichero = fopen("./palabras.txt", "r");
            while ($datos = fgets($fichero)) {
                $this->palabras[] = $datos;
            }
            $this->palabras = preg_replace('/\n/i', "", $this->palabras);
            fclose($fichero);
        }
    }

    public function mostrarPalabra()
    {
        $this->rellenar();
        /*Cambia el orden del array*/
        shuffle($this->palabras);
        $this->palabra_elegida = $this->palabras[0];
    }

    public function cookie_palabra()
    {
        setcookie("palabra", $this->palabra_elegida);
    }

    public function cookie_inicio()
    {
        setcookie("inicio", 1);
    }

    public function palabra_guion($letraa, $cantidad)
    {
        if (isset($_COOKIE["palabra"])) {
            $size = strlen($_COOKIE["palabra"]);
            for ($i = 0; $i < $size; $i++) {
                echo " _ ";
            }
            echo "<br>";
            if (isset($_COOKIE["letra"])) {
                echo "<pre>";
                print_r($_COOKIE);
                echo "</pre>";
                $palabra = $_COOKIE["palabra"];
                echo "La letra que me pasan es: $letraa <br>";
                $tmp = 0;
                $a = 0;

                switch ($cantidad) {
                    case 2:
                        $a = strpos($palabra, $letraa);
                        $tmp = strpos($palabra, $letraa, $a + 1);
                        echo $tmp;
                        break;
                    case 3:
                        $a = strpos($palabra, $letraa);
                        $tmp = strpos($palabra, $letraa, $a + 1);
                        break;
                    case 4:
                        $a = strpos($palabra, $letraa);
                        $tmp = strpos($palabra, $letraa, $a + 1);
                        break;
                    default:
                        echo "No pasó";
                }

                $gionyletra = "";
                if (isset($_COOKIE["guionn"])) {
                    $caracter = $_COOKIE["guionn"];
                    for ($i = 0; $i < strlen($caracter); $i++) {
                        $b = substr($_COOKIE["guionn"], $i, 1);
                        if ($i == $a && strcmp($b, "_") == 0) {
                            $gionyletra .= substr($palabra, $i, 1);
                        }
                        if ($i == $tmp && strcmp($b, "_") == 0) {
                            $gionyletra .= substr($palabra, $i, 1);
                        }
                        if (strcmp($b, "_") == 0) {
                            $gionyletra .= "_";
                        } else {
                            $gionyletra .= $b;
                        }
                    }
                    echo "Así quedó: $gionyletra";
                    setcookie("guionn", $gionyletra);
                } else {
                    for ($i = 0; $i < strlen($palabra); $i++) {
                        if ($a == $i) {
                            $gionyletra .= substr($palabra, $i, 1);
                        }
                        if ($i == $tmp) {
                            $gionyletra .= substr($palabra, $i, 1);
                        } else {
                            $gionyletra .= "_";
                        }
                    }
                    setcookie("guionn", $gionyletra);
                }
                /*echo "Así quedó: $gionyletra";*/
            }
        }
    }

    public function reiniciar()
    {
        if (isset($_POST["reset"])) {
            setcookie("inicio", "", time() - 1);
            setcookie("palabra", "", time() - 1);
            setcookie("letra", "", time() - 1);
            setcookie("error", "", time() - 1);
            setcookie("vidas_totales", "", time() - 1);
            setcookie("guionn", "", time() - 1);
            header("Location:index.php");
        }
    }

    /*Si la letra no se encuentra en la cadena devolverá FALSE
     *y si la letra se encuentra devolvera algo diferente a FALSE*/

    public function cookie_letra_repetidas($letra, $cantidad)
    {
        $tmp = $_COOKIE["letra"] ? $_COOKIE["letra"] : "";
        for ($i = 0; $i < $cantidad; $i++) {
            $tmp .= $letra;
        }
        setcookie("letra", $tmp);
        $this->palabra_guion($letra, $cantidad);
        /*header("refresh:4; url=index.php");*/
        header("Location:index.php");
    }

    public function comprobar($letra)
    {
        $letra_min = mb_strtolower($letra);
        foreach (count_chars($_COOKIE["palabra"], 1) as $le => $valor) {
            $this->cantidad_letras[chr($le)] = $valor;
        }
        /*echo "<pre>";
        print_r($this->cantidad_letras);
        echo "<pre>";*/
        if (strpos($_COOKIE["palabra"], $letra_min) !== false) {
            if (isset($_COOKIE["letra"])) {
                if (strpos($_COOKIE["letra"], $letra_min) === false) {
                    $veces_letra_palabra = $this->cantidad_letras[$letra_min];
                    $this->cookie_letra_repetidas(
                        $letra_min,
                        $veces_letra_palabra
                    );
                }
                header("refresh:4;url=index.php");
                /*header("Location:index.php");*/
            } else {
                /*Si no esxista la cookie letra la crea*/
                $this->cookie_letra_repetidas(
                    $letra_min,
                    $this->cantidad_letras[$letra_min]
                );
            }
        } else {
            setcookie("error", 1);
            setcookie("vidas_totales", 5);
            /*header("Location:index.php");*/
            header("refresh:4;url=index.php");
        }
    }
}

/*It starts!*/
$inicio = new Palabras();
if (isset($_COOKIE["inicio"])) {
    echo "<h1>Adivina la palabra</h1>";
    /*$inicio->palabra_guion('');*/
    $inicio->reiniciar();
    if (isset($_POST["enviar"])) {
        $inicio->comprobar($_POST["letra"]);
    }
} else {
    /*Si no se ha iniciado antes una partida entra al "else" y crea las primeras
     * cookies*/
    $inicio->cookie_inicio();
    $inicio->mostrarPalabra();
    $inicio->cookie_palabra();
    header("Location:index.php");
}
