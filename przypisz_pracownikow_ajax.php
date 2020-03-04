<?php


 	$polaczenie = new PDO('mysql:host=localhost;dbname=praca','root','');
	
if(isset($_POST['zadania']))
{
$tablica_1 = $_POST['zmienna'];

	$tablica = array_unique($_POST['pracownicy']);
        $zmienna_0 = 0;
       $projekt = $tablica_1[0];
	   $wykonane = 0;
       for($i = 0;$i< count($tablica);$i++)
        {
          $zapytanie = $polaczenie->prepare("insert into zadania_uzytkownicy (ID_Projektu,ID_Zadania,ID_Uzytkownika, Data_Rozpoczecia_Zadania, Wykonane_Zadanie) values (:id_pr,:id_zad,:id_uzy,:data_roz,:wykona) ");
		   $zapytanie ->bindParam(':id_pr',$projekt);
		  $zapytanie ->bindParam(':id_zad',$_POST['zadania']);
		  $zapytanie ->bindParam(':id_uzy',$tablica[$i]);
		  $zapytanie ->bindParam(':data_roz',$_POST['data_roz']);
		  $zapytanie ->bindParam(':wykona', $wykonane);
		$zapytanie -> execute();
		}
		 echo '<div class="alert alert-success"> Pomyślnie przypisano</div> ';
}
else if(isset($_POST['pomoc3']))
{
	$tablica_1 = $_POST['zmienna'];
	$tablica = array_unique($_POST['pracownicy']);
        $zmienna_0 = 0;
       $projekt = $tablica_1[0];
       for($i = 0;$i< count($tablica);$i++)
        {
          $zapytanie = $polaczenie->prepare("insert into projekty_uzytkownicy(ID_Uzytkownika,ID_Projektu,Uprawnienia) values(:id_u,:id_pr,:up)");
		  $zapytanie ->bindParam(':id_u',$tablica[$i]);
		   $zapytanie ->bindParam(':id_pr',$projekt);
		   	   $zapytanie ->bindValue(':up',$zmienna_0);
		$zapytanie -> execute();
	
}
 echo '<div class="alert alert-success"> Pomyślnie przypisano</div> ';
}


else
{
	$tablica_1 = $_POST['zmienna'];
	$tablica = array_unique($_POST['pracownicy']);
        $zmienna_0 = 0;
       $projekt = $tablica_1[0];
       for($i = 0;$i< count($tablica);$i++)
        {
          $zapytanie = $polaczenie->prepare("insert into projekty_uzytkownicy(ID_Uzytkownika,ID_Projektu,Uprawnienia) values(:id_u,:id_pr,:up)");
		  $zapytanie ->bindParam(':id_u',$tablica[$i]);
		   $zapytanie ->bindParam(':id_pr',$projekt);
		   	   $zapytanie ->bindValue(':up',$zmienna_0);
		$zapytanie -> execute();
            
        }
	
 echo "<div class='alert alert-success'> Pomyślnie przypisano";								
 echo "<form method=POST action='./projekt_strona_glowna.php'><input type=text name='id_projektu' value='" . $projekt. "' hidden><button  class='btn btn-primary' name='SubmitButton12'>Strona Główna Projektu</button></form>";
echo"</div>";
    }
	

 

?>