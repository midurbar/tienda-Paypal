<?php 

require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

echo '<pre>';
print_r($datos);
echo '</pre>';

if(is_array($datos)) {

    $id_transaccion = $datos['detalles'];

}

?>