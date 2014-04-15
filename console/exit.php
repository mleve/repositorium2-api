<?php
//Archivo para el logOut
session_start();
session_destroy();
header('Location: index.php' );
?>