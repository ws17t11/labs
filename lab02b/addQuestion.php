<?php
    //Formularioko datuak eskuratu
    $eposta = trim($_POST["eposta"]); //trim??
    $galdera = trim($_POST["galdera"]);
    $zuzena = trim($_POST["zuzena"]);
    $okerra1 = trim($_POST["okerra1"]);
    $okerra2 = trim($_POST["okerra2"]);
    $okerra3 = trim($_POST["okerra3"]);
    $zailtasuna = $_POST["zailtasuna"];
    $gaia = trim($_POST["gaia"]);
    //%irudia = ...

    //Formularioaren datuak balidatu
    if(preg_match('/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/' , $eposta)!=1){
      echo "ERROREA! Eposta ez du formatu egokia!<br>" ;
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }
    if(strlen($galdera)<10){
      echo "ERROREA! Galdera gutxienez 10 karaktere izan behar ditu<br>";
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }
    if(strlen($zuzena)==0){
      echo "ERROREA! Erantzun zuzena ezin daiteke hutsik egon!<br>";
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }
    if(strlen($okerra1)==0 || strlen($okerra2)==0 || strlen($okerra3)==0){
      echo "ERROREA! Erantzun okerren bat hutsik dago<br>";
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }
    if($zailtasuna>5 ||$zailtasuna<1){
      echo "ERROREA! Zailtasuna 1 eta 5 tartean egon behar da<br>";
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }
    if(strlen($gaia)==0){
      echo "ERROREA! Galdera gutxienez 10 karaktere izan behar ditu<br>";
      echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"addQuestion.html"' . ">Galdera sartu</a>";
      exit();
    }

    //Datu basearekin konexioa sortu
    $local = 0;
    if($local==1) $link = mysqli_connect("localhost", "root", "", "quiz");
    else $link = mysqli_connect("localhost", "id2921428_ws17t11", "vadisala", "id2921428_quiz");
    //erroreren bat egon bada, mezu bat igorri
    if(mysqli_connect_errno()){ //edo if(!link){
      echo ("Errora datu basearekin konexioa sortzean: " . mysqli_connect_error());
      exit();
    }

    //sartu balioak questions taulan
    $sql = "INSERT INTO questions (eposta, galdera, zuzena, okerra1, okerra2, okerra3, zailtasuna, gaia)
    VALUES ('$eposta', '$galdera', '$zuzena', '$okerra1', '$okerra2', '$okerra3', $zailtasuna,'$gaia')";

    if ($link->query($sql) === TRUE) {
        echo "Datuak datu basean gorde egin dira!<br>";
    } else {
        echo "Errorea datuak sartzean, mesedez, saiatu berriz";
    }

    //itxi konexioa
    mysqli_close($link);
?>
