<?php



#Conexion base de datos
define('DB_SERVER','10.131.22.160');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASE','empleadosnm');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if($db==true){
 
echo ('<script language="javascript">alert("conectando correctamente")</script>');
#Mostramos el formulario por primera vez
if (!isset($_POST) || empty($_POST)) { 
echo("
    <!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <meta http-equiv='X-UA-Compatible' content='ie=edge' />
    <title>Document</title>
    </head>
    <body>
    <form action='Ejercicio1Empleados.php' method='post'>
      Dni <input type='text' name='dni' id='' /><br />
      Nombre <input type='text' name='nombre' id='' /><br />
      Apellido <input type='text' name='apellido' id='' /><br />
      Fecha Nacimiento <input type='text' name='fecha_nac' id='' /><br />
      Salario <input type='text' name='salario' id='' /><br />
      Fecha Inicio <input name='fecha_inicio'><br>
      Fecha Fin <input name='fecha_fin'><br>
      Departamento <select name='departamentos'><br>
      
     
        ");
        $arraydepartamentos=obtenerDepartamentos($db);
       foreach ($arraydepartamentos as $departamento) {
           echo("<option> $departamento </option>");
       }
        echo("  
                    </select>
                <input type='submit' value='Enviar datos'>
            </form>
        </body>
    </html>
    
");


    }
    else{
if(empty($_POST)){

}
 $nombre=$_POST['nombre'];
 $apellido=$_POST['apellido'];
 $dni=$_POST['dni'];
 $fecha_nac=$_POST['fecha_nac'];
 $salario=$_POST['salario'];
 $nombre_departamento=$_POST['departamentos'];
 $fecha_inicio=$_POST['fecha_inicio'];
 $fecha_fin=$_POST['fecha_fin'];
$result = "SELECT cod_dpto as hola FROM departamentos where nombre_dpto='$nombre_departamento'";

 $idk=mysqli_query($db,$result);
 $fila=mysqli_fetch_assoc($idk);
 $nuevodpto=$fila['hola'];

    
 var_dump($nuevodpto);
    $insertar_empleado="INSERT INTO empleados (dni,nombre,apellido,fecha_nac,salario) VALUES ('$dni','$nombre','$apellido',$fecha_nac,$salario)";
    $insertar_empleado_tabla="INSERT INTO emple_depart (dni,cod_dpto,fecha_ini,fecha_fin) VALUES ('$dni','$nuevodpto',$fecha_inicio,$fecha_fin)";   

if(mysqli_query($db,$insertar_empleado) ){
   if(mysqli_query($db,$insertar_empleado_tabla)){
        echo ('<script language="javascript">alert("BIENPACOOOO")</script>');
   }
   else{
       echo ('<script language="javascript">alert("no se a podido crear revisa tus datos")</script>'.mysqli_error($db));
   }
}
else{
    echo ('<script language="javascript">alert("no se a podido crear revisa tus datos")</script>'.mysqli_error($db));
}  
}
}
else{
    echo ('<script language="javascript">alert("error, no te has podido conectar")</script>');
}



function obtenerDepartamentos($db){
    $departamentos=array();
    $sql = "SELECT nombre_dpto FROM departamentos";
    $resultado=mysqli_query($db,$sql);
    if($resultado){
        while($row=mysqli_fetch_assoc($resultado)){

        $departamentos[]=$row['nombre_dpto'];
            }
    }
    return $departamentos;
}
?>
