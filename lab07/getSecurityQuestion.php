<?php

  $eposta = $_GET['eposta'];

  //Formularioaren datuak balidatu
  if(preg_match('/^[a-zA-Z]+[0-9]{3}@(ikasle\.)?ehu\.(es|eus)$/' , $eposta)!=1){
      echo 'ERROREA: Eposta desegokia';
      exit();
  }

  //Datu basearekin konexioa sortu
  include 'connect.php';

  //datuak zuzenak direla ikusi
  $galdera_query = "SELECT * FROM securityquestion WHERE eposta='$eposta'";
  $galdera_result = $link->query($galdera_query);

  $nrows = mysqli_num_rows($galdera_result);
  if($nrows==1){
      $galdera_info = $galdera_result->fetch_assoc();

      session_start();

      $_SESSION['mota'] = 1; // 1: ikaslea
      if(preg_match('/^web000@ehu\.es$/' , $eposta)==1) {
        $_SESSION['mota'] = 2; // 2: irakaslea
      }
      $_SESSION['SID'] = session_id();
      $_SESSION['eposta'] = $eposta;

      echo "".$galdera_info['galdera'];
  }
  else{
      echo 'ERROREA: Eposta hori ez dago erregistratuta';
  }
?>
