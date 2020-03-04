<?php

session_start();
$obiekt = $_SESSION['obiekt'];
$id_projektu = $_SESSION['id_projektu'];
 	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');

if(isset($_POST["lat"]))
{

         $zapytanie = $polaczenie->prepare("insert into zdarzenia(Nazwa_Zdarzenia,ID_Projektu,Data_Zdarzenia,Przewidywany_Czas,LatAtt,LongAtt,Adres_Google) values (:nazwa,:id,:data,:czas,:lat,:lng,:adres)");
		  $zapytanie ->bindParam(':nazwa',$_POST['Nazwa_Zdarzenia']);
				  $zapytanie ->bindParam(':id',$id_projektu);
		  $zapytanie ->bindParam(':data',$_POST['data_roz']);
			  $zapytanie ->bindParam(':czas',$_POST['Czas']);
			$zapytanie ->bindParam(':lat',$_POST['lat']);
			  $zapytanie ->bindParam(':lng',$_POST['long']);
		$zapytanie ->bindParam(':adres',$_POST['adres']);
		$zapytanie -> execute();
    
    }
	header("Location: wydarzenia.php");
		exit;
 

?>
		