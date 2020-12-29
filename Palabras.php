<?php
	class Palabras{
      private $palabras = [];
      private $palabra_elegida;
      private $cantidad_letras = [];
		public function __construct(){
         $this->palabra_elegida = "";
		}

		public function rellenar(){
			$fichero = fopen("./palabras.txt","r");
         while($datos = fgets($fichero)){
            $this->palabras[] = $datos;      
         }
         $this->palabras = preg_replace('/\n/i',"",$this->palabras);
         fclose($fichero);
		}

      public function mostrarPalabra(){
         $this->rellenar();
         /*Cambia el orden del array*/
         shuffle($this->palabras);
         $this->palabra_elegida = $this->palabras[0];
      }

      public function cookie_palabra(){
            setcookie('palabra', $this->palabra_elegida);   
      }

      public function cookie_inicio(){
         setcookie('inicio',1);
      }
      
      public function palabra_guion($veces){

           if(isset($_COOKIE['palabra'])){
             $size = strlen($_COOKIE['palabra']); 
               for($i=0;$i < $size;$i++){
                  /*echo substr($_COOKIE['palabra'],$i,1);*/
                  echo " _ ";
               }
               echo "<br>";
               if(isset($_COOKIE['letra'])){
                  $palabra = $_COOKIE['palabra'];
                  $letra = $_COOKIE['letra'];
                  echo "Palabra: $palabra y tamaño:".strlen($palabra)." <br>";
                  echo "letra: $letra y tamaño: ".strlen($letra)."<br>";
                  $tmp = "";
                  for($i=0;$i<strlen($palabra);$i++){
                     for($j=0;$j<strlen($letra);$j++){
                        if(strcmp(substr($palabra,$i,1),substr($letra,$j,1))==0){
                           $tmp .= substr($palabra,$i,1); 
                        }else{
                           $tmp .= "";
                        }
                     }
                     /*$tmp .= "_";*/
                  }
                  echo "La cadena quedó así: ".$tmp ."<br>";

               }
           }
      }

      public function reiniciar(){
         if(isset($_POST['reset'])){
            setcookie('inicio','',time()-1);
            setcookie('palabra','',time()-1);
            setcookie('letra','',time()-1);
            setcookie('error','',time()-1);
            setcookie('vidas_totales','',time()-1);
            header("Location:index.php");
         }
      
      }

      /*Si la letra no se encuentra en la cadena devolverá FALSE
       *y si la letra se encuentra devolvera algo diferente a FALSE*/

      public function cookie_letra_repetidas($letra,$cantidad){
            $tmp= $_COOKIE['letra'];
            for($i=0;$i<$cantidad;$i++){
                $tmp .= $letra;
            }
            setcookie('letra',$tmp);
            $this->palabra_guion($cantidad);
            header("Location:index.php");
      }


      public function comprobar($letra){
           $letra_min = mb_strtolower($letra);
           foreach(count_chars($_COOKIE['palabra'],1) as $le => $valor){
                 $this->cantidad_letras[chr($le)] = $valor;    
           }
           if(strpos($_COOKIE['palabra'],$letra_min)!==false){
              if(isset($_COOKIE['letra'])){

                 if(strpos($_COOKIE['letra'],$letra_min)===false){
                    $veces_letra_palabra = $this->cantidad_letras[$letra_min];
                    $this->cookie_letra_repetidas($letra_min,$veces_letra_palabra);
                 }
                 header("Location:index.php");
                 
              }else{
                  /*Si no esxista la cookie letra la crea*/
                  $this->cookie_letra_repetidas($letra_min,$this->cantidad_letras[$letra_min]);
              }

          }else{
            setcookie('error',1);
            setcookie('vidas_totales',5);
            header("Location:index.php");
          }
      }
	}

      $inicio = new Palabras();
      if(isset($_COOKIE['inicio'])){
          echo "<h1>Adivina la palabra</h1>";
          $inicio->palabra_guion(0);
          $inicio->reiniciar();
          if(isset($_POST['enviar'])){
               $inicio->comprobar($_POST['letra']);
          }

      }else{
         $inicio->cookie_inicio();
         $inicio->mostrarPalabra();
         $inicio->cookie_palabra();
         header("Location:index.php");

   }

?>
