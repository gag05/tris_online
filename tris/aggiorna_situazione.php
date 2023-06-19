<?php

    session_start();

    $row = json_decode($_POST["row"])-1;
    $col = json_decode($_POST["col"])-1;
    $val = json_decode($_POST["val"]);

    var_dump($_SESSION["situation"]);

    $_SESSION["situation"][$row*3+$col] = $val;

    var_dump($_SESSION["situation"]);

?>