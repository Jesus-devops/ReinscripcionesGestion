<?php 
session_start(); 

$con = $mysql= new mysqli("localhost", "root","", "reinscripciones");
if ($mysql-> connect_error) {
    die("problemas con la conexion a la base de datos");
}
mysqli_set_charset($con, 'utf8');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Horario</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>

<body>    
	<center>
    <header>            
        <nav class="menu2">
        <ul>
<?php 
if (isset($_SESSION['noControl'])) {
    echo '<a href="cerrar.php"><li>Salir</li></a>';
}else{
    echo '<a href="login.php"><li>Login</li></a>';
}
 ?>        
        <a href="kardex.php"><li>Kardex</li></a>
        <a href="consultar_carga.php"><li>Consultar carga</li></a>
        <a href="rs.php"><li>Estado de Reinscripcion</li></a>
        <a href="captura_horario.php"><li>Capturar horarios</li></a>
        <a href="consulta_horarios.php"><li>Consultar horarios</li></a>
        <a href="captura_carga.php"><li>Capturar carga</li></a>

        </ul> 
        </nav>
    </header>
<h1>Horario</h1> <br> <h2>ingrese datos</h2>
<br>
<form id="formulario" method="GET" >
    
    <select name="idCarrera">
        <option value="">Seleccionar Carrera</option>
    <?php
    $idCarrera;    
    $urlc="http://127.0.0.1:8181/reinscripciones/carreras";
    $jsonc=file_get_contents($urlc);
    $datosc=json_decode($jsonc,true);
    if ($datosc>0) {    
    $longc=count($datosc);
        for ($i=0; $i < $longc; $i++) { 
            echo '<option value="'.$datosc[$i]['idCarrera'].'">'.$datosc[$i]['carrera'].'</option>';
        }       
    }
    ?> 
    </select>
    
    <select name="año">
        <option value="">Año</option>    
        <option value="<?php echo date('Y')+1;?>"><?php echo date("Y")+1;?></option>
        <option value="<?php echo date('Y')+1;?>"><?php echo date("Y");?></option>
        <option value="<?php echo date('Y')+1;?>"><?php echo date("Y")-1;?></option>
    </select>
    <select name="periodo">        
        <option value="">Periodo escolar</option>
        <option value="enero-junio">Enero-Junio</option>
        <option value="agosto-diciembre">agosto-diciembre</option>
    </select>
    <select name="semestre">        
        <option value="">Semestre</option>
        <option value="1ro">1ro</option>
        <option value="2do">2do</option>
        <option value="3ro">3ro</option>
        <option value="4to">4to</option>
        <option value="5to">5to</option>
        <option value="6to">6to</option>
        <option value="7mo">7mo</option>
        <option value="8vo">8vo</option>
    </select>
    <select name="turno">       
        <option value="">Turno</option>
        <option value="v">Vespertino</option>
        <option value="m">Matutino</option>
    </select>
    <br><br>

<input type="submit" name="button" value="Enviar" class="aceptar">

</form> 

<?php
$idH=0;
$re2=$mysql->query("select idHorario from horarios order by idHorario desc limit 1")or die($mysql-> error);

    while ($f=$re2->fetch_array()) {  $idH=$f['idHorario']; $idH=$idH+1;   }

if (isset($_REQUEST['semestre'])&&isset($_REQUEST['turno'])&&isset($_REQUEST['año'])&&isset($_REQUEST['periodo'])&&isset($_REQUEST['idCarrera'])) {
  
    $re=$mysql->query("insert into horarios values ($idH,'$_REQUEST[semestre]','$_REQUEST[turno]',$_REQUEST[año],'$_REQUEST[periodo]',$_REQUEST[idCarrera])") or die($mysql -> error);

        header("Location: ./captura_horarios.php?idHorario=".$idH."&idCarrera=".$_REQUEST[idCarrera]);

}

  ?>








</center>
</body>
</html>