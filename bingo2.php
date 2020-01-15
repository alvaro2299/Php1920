@@ -0,0 +1,184 @@
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
    
</head>
<body>
<?php


												//Declaraciones Previas
//Inicializamos el array bingo que contendrá números no repetidos de manera desordenada
$bingo=array();

//Número de Jugadores
$contarjugadore=5;

//Número de Cartones para todos los jugadores
$contarcartones=9;

//Declaramos un array auxiliar que tendrá la misma longitud que el array jugadores y su mismo número de cartones, pero que llevará en vez de números de bingo, una puntuación --> Ésto en futuro será un array multidimensional anexado al propio array $juego
$puntos=array();

//Inicializamos las variables donde se guardarán las posiciones en las que se encuentran el ganador y con que cartón ha ganado en sus respectivos arrays
$posicionganador=0;
$cartonganador=0;

//Contador que se incrementará cada vez que se saque un bola y podrá determinar el fin del programa si este contador llega a 60
$contadorbolas=0;

													//Programa 

//Inicializamos juego que es el array que contendrá un array jugadores y cada jugadores contendrá un array con sus respectivos cartones
$juego = array();
$juego=añadirjugadores($contarjugadore);

//Bucle que inicializará primero los cartones de cada jugador y después los rellenará con números aleatorios no repetidos
for ($i=0; $i <count($juego) ; $i++) { 
    $juego[$i]=añadircartones($contarcartones);//Inicializa a cada jugador (juego[i]) sus array con cartones con el método añadircartones
    for ($j=0; $j <count($juego[$i]) ; $j++) { 
        $juego[$i][$j]=rellenar();//Rellena los cartones con números aleatorios
    }
}

//Creación del bingo, un array de 60 posiciones que tendrá números en cada una de sus posiciones, con un número que será único y no se podrá repetir más en el array
$bingo=rellenarbingo();


//Creamos un array auxiliar que tendrá la misma cantidad de jugadores que el propio juego
$puntos=añadirjugadores($contarjugadore);

//Rellenamos el dicho array, pero ahora en vez de que los cartones (puntos[$i][$j]) tengan un array con números para el bingo, solo tendrán un número que será la puntuación que tendrá cada cartón, inicializado a 0. La puntuación será 1 por cada número que coincida juego con bingo, y ganará cuando la puntuacion sea 15, es decir, cuando todos los números que hay en el array cartones hayan coincidido con el bingo
for ($i=0; $i <count($puntos) ; $i++) { 
    $puntos[$i]=añadircartones($contarcartones);
    for ($j=0; $j <count($puntos[$i]) ; $j++) { 
        $puntos[$i][$j]=0;
    }
}



$i=0;//Indice para el bingo
$ganador=false;//Boolean que servirá para que, cuando se encuentre un ganador, detenga el programa

//Bucle que sacará una bola y terminará cuando no queden más bolas por sacar, es decir, que se haya recorrido todo el array
while ($i <count($bingo) && $ganador==false) { 
    
    $bola=sacarbola($bingo,$contadorbolas);//Variable bola, que será el número que haya retornado la funcion sacarbola
    
   
    $j=0;//Indice para los jugadores
//Bucle que recorrerá los jugadores (juego[i]), sus cartones (juego[j][z]), y comprobará si $bola coincide con el número de cada cartón de cada jugador (juego[j][z][y]),
									//y cuando éste coincida se añadirán los puntos en el array $puntos ya que al tener la misma longitud podremos tomar de referencia las variables $i,$j,$z, para ambos arrays, $juego, $puntos (Ésto en un futuro será un array multidimensional)
    while ($j <count($juego) && $ganador==false) { 
        $z=0;//Indice para los cartones

        while ($z <count($juego[$j]) && $ganador==false) { 
            $y=0;//Indice para los números de los cartones

            while ($y <count($juego[$j][$z]) && $ganador==false) { 
                
                    if ($bola==$juego[$j][$z][$y]) {//Comprueba la bola con cada número de cada cartón
                        $puntos[$j][$z]++;//Si $bola coincide con el numero del carton (juego[j][z][y]), se aumentará el contador en el array $puntos, y al tener la misma longitud podremos usar las mismas posiciones que hay en $juego
                        if ($puntos[$j][$z]==15) {//Si se ha alcanzado el limite de puntos, es decir, todos los números del cartón han salido en el bingo, se ha encontrado ganador, se recoge su posición y con el cartón que ha ganado y termina el bucle -->En nuestro caso no puede haber 2 ganadores a la vez
                           $ganador=true;
                           $posicionganador=$j;
                           $cartonganador=$z;
                        }
                    }
                    $y++;
                    }
                    $z++;
                }
                $j++;
            }
            $contadorbolas++;
            $i++;
        }
    
    var_dump($puntos);

echo "Ha ganado el jugador".$posicionganador." con el carton  ".$cartonganador;





												//Funciones

//Función que devolverá un cartón con 15 números aleatorios en un rango del 1 al 60
function rellenar(){

    $numeros = range(1, 60);//variable que contiene un rango de números ordenados del 1 al 60
    shuffle($numeros);//Método que desordera aleatoriamente el array de números
    $carton=array();//Inicializamos el cartón el cuál deberá retornar la función

//rellenamos el array cartón con 15 números anteriormente desordenados
    for ($i=0; $i <15 ; $i++) { 
    $carton[$i]=$numeros[$i];     
    }

    return $carton ;
}

//Función que devuelve un array en cada posición del array juego, el cuál podrá considerar como juego[$i] cada jugadores y a su vez contiene un array que más adelante contendrá el número de cartones asignado
function añadirjugadores ($contarjugadores){
    
    for ($i=0; $i < $contarjugadores ; $i++) { 
    $juego[$i]=array();
    
    }
    return $juego;
}

//Función que devuelve un array en el que tendrá inicializado en cada jugador un array vacío, pero que será los futuros cartones
function añadircartones($contarcartones){
        
    for ($j=0; $j <$contarcartones ; $j++) { 
            $juego[$j]=array();
            
        
    }
    return $juego;
}


//Función que devolverá un bingo, es decir, un array de 60 posiciones el cuál tendrá en cada posición un número único y de manera desordenada
function rellenarbingo(){
    $numeros = range(1, 60);//Array con un rango de números de manera ordenada
    shuffle($numeros);//Desordena el array $numeros con números desordenados en cada posición

    $bingo=array();

//Rellena el array bingo con números de manera desordenada en sus distintas posiciones
    for ($i=0; $i <60 ; $i++) { 
 	   $bingo[$i]=$numeros[$i];     
    }

    return $bingo ;
}


//Función que devolverá un número del array $bingo, en el que además de pasarle el array $bingo, debemos pasarle un contador el cuál será el indice que recorrerá el array y que se irá incrementando más adelante
function sacarbola($bingo,$contadorbolas){
    $bola;
    $bola=$bingo[$contadorbolas];
    return $bola;  
}

?>








</body>
</html>  