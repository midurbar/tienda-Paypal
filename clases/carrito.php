<?php

require '../config/config.php';

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $token = $_POST['token'];

    $token_tmp = hash_hmac('sha256', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $_SESSION

    } else {
        $datos['ok'] = false;
    }

} else {
    $datos['ok'] = false;
}

?>