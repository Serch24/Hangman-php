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
            header("refresh: 0; url='index.php'");
         }
      }
      
      public function palabra_guion(){
           if(isset($_COOKIE['palabra'])){
             $size = strlen($_COOKIE['palabra']); 
               for($i=0;$i < $size;$i++){
                  echo " _ ";
               }
           }
      }

      /*Si la letra no se encuentra en la cadena devolverá FALSE, y si la letra se encuentra devolvera algo diferente a FALSE*/
      public function cookie_letra($letra){
         if(strpos($_COOKIE['palabra'],$letra)!== FALSE){
            if(!isset($_COOKIE['letra'])){
               setcookie('letra',$letra);
            }else{
                  $tmp = $_COOKIE['letra'];
                  setcookie('letra',$tmp,time()-1);
                  setcookie('letra',$tmp.$letra);
            }
         }

         /*header("refresh: 0; url='index.php'");*/
      }

      public function comprobar(){
          if(isset($_COOKIE['letra'])&& isset($_COOKIE['palabra'])){
               $letra = $_COOKIE['letra'];
               $palabra = $_COOKIE['palabra'];
               echo "<p>Letra: {$letra}</p><p>Palabra: {$palabra}</p>";
               /*for($i=0;$i<count($arrai);$i++){
                  for($j=0;$j<count($arrai);$j++){

                  }
               }*/
          }
      }
      
      






	}

?>
