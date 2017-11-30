<?php

//Datu basearekin konexioa sortu
include 'connect.php';



$eposta = 'jvadillo005@ikasle.ehu.eus';
$galdera = 'Zein da zure unibertsitateko lehen suspentsoa jarri zizun irakaslearen abizena?';
$erantzuna = "Garcia";

$login_query = "INSERT INTO securityquestion (eposta, galdera, erantzuna) VALUES ('$eposta','$galdera','$erantzuna')";
$login_result = $link->query($login_query);

?>
