<?php

define("CLIENT_ID","Aetzy0y0068msubaINMRw9VIioFBM_qXehhY5dC8U1mGO_F9gy-jwDfHFS-vkwe2EMgh0VwjNjllKrxH");
define("CURRENCY","EUR");
define("KEY_TOKEN","APR.wqc-124*");
define("MONEDA","€");

session_start();

$num_cart=0;

if (isset($_SESSION['carrito']['productos'])) {
    $num_cart= count($_SESSION['carrito']['productos']);
}

?>