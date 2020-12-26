<?php
	class Palabras{
      private $palabras = [];
      private $palabra_elegida;
		public function __construct(){
         $this->palabra_elegida = "";
		}

		public function rellenar(){
			$fichero = fopen("./palabras.txt","r");
         while($datos = fgets($fichero)){
            $this->palabras[] = $datos;      
         }
         $this->palabras = preg_replace('/\n/i',"",$this->palabras);
		}

      public function mostrarPalabra(){
         $this->rellenar();
         /*Cambia el orden del array*/
         shuffle($this->palabras);
         $this->palabra_elegida = $this->palabras[0];
      }

      public function cookie_palabra(){
         if(!isset($_COOKIE['palabra'])){
            setcookie('palabra', $this->palabra_elegida);   
            header("refresh:0");
         }else{
            echo $_COOKIE['palabra'];
         }
      }
      
      public function palabra_guion(){
        $size = $_COOKIE['palabra'];
        for($i=0;$i< strlen($size);$i++){
            echo " _ ";
        }
      }

      public function comprobar_palabra($palabra){
         if(strpos($_COOKIE['palabra'],$palabra)!== FALSE){
            echo "<br>si está la letra {$palabra}";
         }else{
            echo "no se encuentra esa letra";
         }
      }

	}








?>
