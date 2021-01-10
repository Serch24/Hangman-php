<?php
class Palabras
{
    private $palabras_recogidas;

    public function __construct()
    {
        $this->palabras_recogidas = [];
    }

    /*Crea una cookie de inicio para dar la bienvenida*/
    public function inicio()
    {
        setcookie("inicio", 1);
    }

    /*Obtiene las palabras del fichero*/
    public function recoger_palabras()
    {
        if (!isset($_COOKIE["palabras_recogidas"])) {
            $fichero = fopen("./palabras.txt", "r");
            while ($datos = fgets($fichero)) {
                $this->palabras_recogidas[] = $datos;
            }
            /*Preg_replace escapa todos los saltos de linea del fichero*/
            $this->palabras_recogidas = preg_replace(
                '/\n/i',
                "",
                $this->palabras_recogidas
            );
            fclose($fichero);
            shuffle($this->palabras_recogidas);
            setcookie("palabras_recogidas", true);
        }
    }

    /*Crea las cookies de la palabra y los guiones de la palabra.(Solo se usa una vez...)*/
    public function guiones()
    {
        if (!isset($_COOKIE["guiones"])) {
            $this->recoger_palabras();
            $palabra = $this->palabras_recogidas[0];
            $guiones = "";

            for ($i = 0; $i < strlen($palabra); $i++) {
                $guiones .= "_";
            }
            setcookie("guiones", $guiones);
            setcookie("palabra", $palabra);
        }
    }

    /*actualiza la cookie de guiones con la letra que se ha escrito
     *, ademas crea la cookie de vida si se ha equivocado en escribir
     * la letra correcta.
     */
    public function insertar_letra($letra)
    {
        $letra_lower = mb_strtolower($letra);
        $tmp_posicion = "";
        if (isset($_COOKIE["guiones"])) {
            if (strpos($_COOKIE["palabra"], $letra_lower) !== false) {
                for ($i = 0; $i < strlen($_COOKIE["guiones"]); $i++) {
                    if (
                        strcmp(
                            substr($_COOKIE["guiones"], $i, 1),
                            $letra_lower
                        ) !== 0
                    ) {
                        if (
                            strcmp(
                                substr($_COOKIE["palabra"], $i, 1),
                                $letra_lower
                            ) === 0
                        ) {
                            $tmp_posicion .= $i;
                        }
                    }
                }
            } else {
                if (isset($_COOKIE["error"])) {
                    $tmp_error = $_COOKIE["error"];
                    setcookie("error", $tmp_error - 1);
                } else {
                    setcookie("error", 4);
                }
                setcookie("error_actived", 1);
            }

            /*Convierte la cadena en un array para manejar mejor las pociones
             * y así insertar la letra;
             */
            $tmp_array = str_split($_COOKIE["guiones"]);
            for ($i = 0; $i < count($tmp_array); $i++) {
                for ($j = 0; $j < strlen($tmp_posicion); $j++) {
                    if ($i == substr($tmp_posicion, $j, 1)) {
                        $tmp_array[$i] = $letra_lower;
                    }
                }
            }
            /*Con implode convierto el array ya modificado en una cadena*/
            setcookie("guiones", implode("", $tmp_array));
        }
    }

    /*Elimina todas las cookies que se han creado!*/
    public function reiniciar()
    {
        if (isset($_POST["reiniciar"])) {
            setcookie("inicio", "", time() - 1);
            setcookie("guiones", "", time() - 1);
            setcookie("palabras_recogidas", "", time() - 1);
            setcookie("palabra", "", time() - 1);
            setcookie("error_actived", "", time() - 1);
            setcookie("error", "", time() - 1);
        }
    }
}
$st = new Palabras();
$st->inicio();
$st->guiones();
if (isset($_POST["letra"])) {
    $st->insertar_letra($_POST["letra"]);
}
$st->reiniciar();
header("Location:index.php");
?>
