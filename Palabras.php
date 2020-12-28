<?php
	class Palabras{
      private $palabras = [];
      private $palabra_elegida;
      private $cantidad_letras = [];
      private $letras_de_cookies = [];
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
            setcookie('palabra', $this->palabra_elegida);   
      }

      public function cookie_inicio(){
         setcookie('inicio',1);
      }
      
      public function palabra_guion(){

           if(isset($_COOKIE['palabra'])){
             $size = strlen($_COOKIE['palabra']); 
               for($i=0;$i < $size;$i++){
                  echo " _ ";
               }
           }
      }

      /*Si la letra no se encuentra en la cadena devolverá FALSE
       *y si la letra se encuentra devolvera algo diferente a FALSE*/

      public function cookie_letra_repetidas($letra,$cantidad){
              $tmp="";
            if(isset($_COOKIE['letra'])){
            
               $tmp=$_COOKIE['letra'];
            }else{
               header("refresh:0");
            }
            echo "la cookie es $tmp";
            for($i=0;$i<$cantidad;$i++){
                $tmp .= $letra;
            }
            setcookie('letra',$tmp);
      }


      public function comprobar($letra){
           foreach(count_chars($_COOKIE['palabra'],1) as $le => $valor){
                 $this->cantidad_letras[chr($le)] = $valor;    
           }
           if(strpos($_COOKIE['palabra'],$letra)!==false){
              if(isset($_COOKIE['letra'])){

                 if(strpos($_COOKIE['letra'],$letra)===false){
                    $veces_letra_palabra = $this->cantidad_letras[$letra];
                    $this->cookie_letra_repetidas($letra,$veces_letra_palabra);
                    return;
                 }
                 setcookie('error',1);
                 setcookie('vidas_totales',5);

                 foreach(count_chars($_COOKIE['letra'],1) as $k => $v){
                    $this->letras_de_cookies[chr($k)] = $v; 
                 }
                 $size_palabras = count($this->cantidad_letras); 
                 $size_letras = count($this->letras_de_cookies);
                 echo "cant de palabra: $size_palabras <br>";
                 echo "cant de letras: $size_letras<br>";
                 if($size_letras==$size_palabras){
                     setcookie('win',1);
                 }
              }else{
                  /*Si no esxista la cookie letra la crea*/
                  $this->cookie_letra_repetidas($letra,$this->cantidad_letras[$letra]);
              }

          }else{
            setcookie('error',1);
            setcookie('vidas_totales',5);
          }
      }
	}

      $inicio = new Palabras();
      if(isset($_COOKIE['inicio'])){
          echo "<h1>Adivina la palabra</h1>";
          $inicio->palabra_guion();
          if(isset($_POST['letra'])){
               $inicio->comprobar($_POST['letra']);
               header("refresh:6; url=index.php");
          }

      }else{
         $inicio->cookie_inicio();
         $inicio->mostrarPalabra();
         $inicio->cookie_palabra();
         header("Location:index.php");

   }

?>
