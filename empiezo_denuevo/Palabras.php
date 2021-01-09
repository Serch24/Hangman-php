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

    /*Crea las cookies de la palabra y los guiones de la palabra*/
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

    public function insertar_letra($letra){
            $tmp_posicion = ""; 
            if(isset($_COOKIE['guiones'])){
               
                    for($i=0;$i<strlen($_COOKIE['guiones']);$i++){
                     
                            if(strcmp(substr($_COOKIE['guiones'],$i,1),$letra)==0){
                              
                                    /*echo "La letra está en el guión";*/
                            }else{
                              
                                    if(strcmp(substr($_COOKIE['palabra'],$i,1),$letra)==0){
                                       
                                            $tmp_posicion .= $i;

                                    }
                            }
                    }
                    /*echo "Las posiciones son: $tmp_posicion";*/
                    $tmp_guiones = "";
                    for($i=0;$i<strlen($_COOKIE['guiones']);$i++){
                            for($j=0;$j<strlen($tmp_posicion);$j++){

                                    if(strcmp($i,substr($tmp_posicion,$j,1))==0){
                                    
                                            $tmp_guiones .= $letra;
                                    }
                                    $tmp_guiones .= "_";
                            }
                    }
                    echo "Así quedo la cadena de caracter de guiones: $tmp_guiones";

                    for($i=0;$i<strlen($_COOKIE['guiones']);$i++){
                            echo substr($tmp_guiones,$i,1). "  ";
                    }
                    /*setcookie('guiones',$tmp_guiones);*/
                     /*Por aqui me quedé para comprobar los guiones*/
                    
            }
    }
}
$st = new Palabras();
$st->inicio();
$st->guiones();
if(isset($_POST['letra'])){
   $st->insertar_letra($_POST['letra']);
}
/*header("Location:index.php");*/
header("refresh:3;url=index.php");
?>
