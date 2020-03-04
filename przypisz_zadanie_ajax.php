<?php


 	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
	

if(isset($_POST["zmienna"]))
{
	$tablica_1 = $_POST['zmienna'];

	$tablica = array_unique($_POST['zadania']);
        $zmienna_0 = 0;
       $projekt = $tablica_1[0];
	   $wykonane = 0;
       for($i = 0;$i< count($tablica);$i++)
        {
          $zapytanie = $polaczenie->prepare("insert into zadania_uzytkownicy (ID_Projektu,ID_Zadania,ID_Uzytkownika, Data_Rozpoczecia_Zadania, Wykonane_Zadanie) values (:id_pr,:id_zad,:id_uzy,:data_roz,:wykona) ");
		   $zapytanie ->bindParam(':id_pr',$projekt);
		  $zapytanie ->bindParam(':id_zad',$tablica[$i]);
		  $zapytanie ->bindParam(':id_uzy',$_POST['id_pracownika']);
		  $zapytanie ->bindParam(':data_roz',$_POST['data_roz']);
		  $zapytanie ->bindParam(':wykona', $wykonane);
		$zapytanie -> execute();
            
        }
	
 echo '<div class="alert alert-success"> Pomyślnie przypisano</div> ';
    }

 

?>