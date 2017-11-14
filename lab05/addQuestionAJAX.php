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
    //begiratu irudirik bidali den???

    //Formularioaren datuak balidatu
    if(preg_match('/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/' , $eposta)!=1){
      echo "ERROREA! Eposta ez du formatu egokia!<br>" ;
      echo "Mesedez, saiatu berriz";
      exit();
    }
    if(strlen(str_replace(' ', '', $galdera))<10){
      echo "ERROREA! Galdera gutxienez 10 karaktere izan behar ditu<br>";
      echo "Mesedez, saiatu berriz";
      exit();
    }
    if(strlen($zuzena)==0){
      echo "ERROREA! Erantzun zuzena ezin daiteke hutsik egon!<br>";
      echo "Mesedez, saiatu berriz";
      exit();
    }
    if(strlen($okerra1)==0 || strlen($okerra2)==0 || strlen($okerra3)==0){
      echo "ERROREA! Erantzun okerren bat hutsik dago<br>";
      echo "Mesedez, saiatu berriz";
      exit();
    }
    if($zailtasuna>5 ||$zailtasuna<1){
      echo "ERROREA! Zailtasuna 1 eta 5 tartean egon behar da<br>";
      echo "Mesedez, saiatu berriz";
      exit();
    }
    if(strlen($gaia)==0){
      echo "ERROREA! Galdera gutxienez 10 karaktere izan behar ditu<br>";
      echo "Mesedez, saiatu berriz";
      exit();
    }


    //Datu basearekin konexioa sortu
    $local = 1;
    if($local==1) $link = mysqli_connect("localhost", "root", "", "quiz");
    else $link = mysqli_connect("localhost", "id3302669_ws17t11", "", "id3302669_quiz"); //pasahitza ezkutu da
    //erroreren bat egon bada, mezu bat igorri
    if(mysqli_connect_errno()){ //edo if(!link){
      echo ("Errora datu basearekin konexioa sortzean: " . mysqli_connect_error());
      exit();
    }

    //Ziurtatu irudia kargatu dela
    if(isset($_FILES['irudia']['tmp_name']) && $_FILES['irudia']['tmp_name']!=""){

        $path = $_FILES['irudia']['tmp_name'];
        $name = $_FILES['irudia']['name'];
        $size = $_FILES['irudia']['size'];
        $type = $_FILES['irudia']['type'];

        $content = addslashes(file_get_contents($_FILES['irudia']['tmp_name']));
    }
    else{
      //echo "Ez da irudirik kargatu, baina ez da ezer gertatzen :)<br>";
      $content = "";
    }

    //sartu balioak questions taulan
    $sql = "INSERT INTO questions (eposta, galdera, zuzena, okerra1, okerra2, okerra3, zailtasuna, gaia, irudia)
    VALUES ('$eposta', '$galdera', '$zuzena', '$okerra1', '$okerra2', '$okerra3', $zailtasuna,'$gaia', '$content')";

    // datu basean sartu bada, XML fitxategian ere gordeko dugu
    if ($link->query($sql) === TRUE) {

        echo "Datuak datu basean gorde egin dira!<br>";
        $xml = simplexml_load_file('xml/questions.xml');

        if ($xml) {
          $question = $xml->addChild('assessmentItem');

          $question->addAttribute('complexity', $zailtasuna);
          $question->addAttribute('subject', $gaia);
          $question->addAttribute('author', $eposta);

          $body = $question->addChild('itemBody');
          $body->addChild('p', $galdera);

          $correct = $question->addChild('correctResponse');
          $correct->addChild('value', $zuzena);

          $wrong = $question->addChild('incorrectResponses');
          $wrong->addChild('value', $okerra1);
          $wrong->addChild('value', $okerra2);
          $wrong->addChild('value', $okerra3);

          $xml->asXML('xml/questions.xml');
          echo "Datuak XML fitxategian gorde dira ere!<br>";
          
        } else {
          echo "Hala ere, arazoak egon dira XML fitxategian gordetzeko... :(<br>";
        }

        /*echo 'Galderen zerrenda ikusteko (irudirik gabe) <a href="showQuestions.php">sakatu hemen</a><br>';
        echo 'Galderen zerrenda ikusteko irudiekin <a href="showQuestionsWithImages.php">sakatu hemen</a><br>';
        echo 'XML fitxategiko galderak ikusteko <a href="showXMLQuestions.php">sakatu hemen</a><br>';*/
    } else {
        echo 'Errorea datuak sartzean, mesedez, saiatu berriz <a href="addQuestion.html">esteka honen bidez</a><br>';
    }

    //itxi konexioa
    mysqli_close($link);
?>
