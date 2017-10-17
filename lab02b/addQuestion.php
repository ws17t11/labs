<?php
    //Formularioaren datuak balidatu
    $eposta = $_POST["eposta"]; //trim??
    $galdera = $_POST["galdera"];
    $zuzena = $_POST["zuzena"];
    $okerra1 = $_POST["okerra1"];
    $okerra2 = $_POST["okerra2"];
    $okerra3 = $_POST["okerra3"];
    $zailtasuna = $_POST["zailtasuna"];
    $gaia = $_POST["gaia"];
    //%irudia = ...

    $link = mysqli_connect("localhost", "root", "", "quiz");
    //erroreren bat egon bada, mezu bat igorri
    if(mysqli_connect_errno()){ //edo if(!link){
      echo ("Errora datu basearekin konexioa sortzean: " . mysqli_connect_error());
      exit();
    }


    //$ema = mysqli_query($link, "SELECT * FROM questions");




    //itxi konexioa
    mysqli_close($link);
?>
