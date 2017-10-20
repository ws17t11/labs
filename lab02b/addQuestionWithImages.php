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

        $content = file_get_contents($path);

        //$content = mysqli_real_escape_string($link, $content);

        // if ($_FILES['image']['error'] || !is_uploaded_file($path)) {
        //     $formOk = false;
        //     echo "Error: Error in uploading file. Please try again.";
        // }
        // //check file extension
        // if ($formOk && !in_array($type, array('image/png', 'image/x-png', 'image/jpeg', 'image/pjpeg', 'image/gif'))) {
        //     $formOk = false;
        //     echo "Error: Unsupported file extension. Supported extensions are JPG / PNG.";
        // }
        // // check for file size.
        // if ($formOk && filesize($path) > 500000) {
        //     $formOk = false;
        //     echo "Error: File size must be less than 500 KB.";
        // }

        // read file contents
        // $content = file_get_contents($path);
        //
        // //connect to mysql database
        // if ($conn = mysqli_connect('localhost', 'root', 'root', 'test')) {
        //     $content = mysqli_real_escape_string($conn, $content);
        //     //$sql = "insert into images (name, size, type, content) values ('{$name}', '{$size}', '{$type}', '{$content}')";
        //
        //     if (mysqli_query($conn, $sql)) {
        //         $uploadOk = true;
        //         $imageId = mysqli_insert_id($conn);
        //     } else {
        //         echo "Error: Could not save the data to mysql database. Please try again.";
        //     }
        //
        //     mysqli_close($conn);
        // } else {
        //     echo "Error: Could not connect to mysql database. Please try again.";
        // }

        $content = addslashes(file_get_contents($_FILES['irudia']['tmp_name']));
        //you keep your column name setting for insertion. I keep image type Blob.
        //$query = "INSERT INTO products (id,image) VALUES('','$image')";
        //$qry = mysqli_query($db, $query);
    }
    else{
      echo "Ez da irudirik kargatu, baina ez da ezer gertatzen :)<br>";
      $content = "";
    }

    //sartu balioak questions taulan
    $sql = "INSERT INTO questions (eposta, galdera, zuzena, okerra1, okerra2, okerra3, zailtasuna, gaia, irudia)
    VALUES ('$eposta', '$galdera', '$zuzena', '$okerra1', '$okerra2', '$okerra3', $zailtasuna,'$gaia', '$content')";

    if ($link->query($sql) === TRUE) {
        echo "Datuak datu basean gorde egin dira!<br>";
        echo 'Galderen zerrenda ikusteko (irudirik gabe) <a href="showQuestions.php">sakatu hemen</a><br>';
        echo 'Galderen zerrenda ikusteko irudiekin <a href="showQuestionsWithImages.php">sakatu hemen</a><br>';
    } else {
        echo 'Errorea datuak sartzean, mesedez, saiatu berriz <a href="addQuestion.html">esteka honen bidez</a><br>';
    }

    //itxi konexioa
    mysqli_close($link);
?>
