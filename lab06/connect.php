<?php

	$local = 1;

	if($local==1) $link = mysqli_connect("localhost", "root", "", "quiz");
	else $link = mysqli_connect("localhost", "id3302669_ws17t11", "", "id3302669_quiz"); //pasahitza ezkutu da

    //erroreren bat egon bada, mezu bat igorri
    if(mysqli_connect_errno()){ //edo if(!link){
		echo ("Errora datu basearekin konexioa sortzean: " . mysqli_connect_error());
		exit();
    }
    
?>