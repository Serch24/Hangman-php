<?php
	class Palabras{
      private $palabras = [];
		public function __construct(){
		}
		public function rellenar(){
			$fichero = fopen("./palabras.txt","r");
         while($datos = fgets($fichero)){
            $this->palabras[] = $datos;      
         }
		}

      public function mostrarPalabra(){
         $this->rellenar();
         /*Cambia el orden del array*/
         shuffle($this->palabras);

         return $this->palabras[0];
      }

      public function palabra_guardada(){
         if($_COOKIE['palabra']){
            echo $_COOKIE['palabra'];
         }else{
            echo "no";
         }
      }




	}

?>
