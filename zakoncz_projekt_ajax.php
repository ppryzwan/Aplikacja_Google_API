<?php


 	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
	

if(isset($_POST["id_projektu"]))
{
	$id_projektu = $_POST['id_projektu'];
	$data_dzis = getdate();
	$data = $data_dzis['year'] . "-" . date('m',strtotime("now")) . "-" . $data_dzis['mday'] . " " . $data_dzis['hours'] . ":" . $data_dzis['minutes'] . ":00";
    $data_date = $data_dzis['year'] . "-" . date('m',strtotime("now")) . "-" . $data_dzis['mday'];
    
          $zapytanie = $polaczenie->prepare("update projekt set Data_Zakonczenia_Projektu = :data where ID_Projektu = :id_pr");
		   $zapytanie ->bindParam(':id_pr',$id_projektu);
		  $zapytanie ->bindParam(':data',$data);

		$zapytanie -> execute();
            
  $zapytanie = $polaczenie->prepare("update zadania_uzytkownicy set Data_Zakonczenia_Zadania = :data, Wykonane_Zadanie = 1 where ID_Projektu = :id_pr");
		   $zapytanie ->bindParam(':id_pr',$id_projektu);
		  $zapytanie ->bindParam(':data',$data_date);

		$zapytanie -> execute();
 echo '<div class="alert alert-success"> Pomyślnie Zakończono</div> ';
    }
	


?>