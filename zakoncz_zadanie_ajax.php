<?php


 	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
	if(isset($_POST['id_Zad']))
	{
	$data_dzis = getdate();
    $data_date = $data_dzis['year'] . "-" . date('m',strtotime("now")) . "-" . $data_dzis['mday'];

	$wykonane = 1;
	  $zapytanie = $polaczenie->prepare("update zadania_uzytkownicy set Data_Zakonczenia_Zadania = :data, Wykonane_Zadanie = :wykona where ID_ZadUzy = :id");
		 $zapytanie ->bindParam(':id',$_POST['id_Zad']);
		 $zapytanie ->bindParam(':data',$data_date);
		 $zapytanie ->bindParam(':wykona', $wykonane);
		$zapytanie -> execute();
		 echo '<div class="alert alert-success"> Pomyślnie zakończono zadanie</div> ';
	}
	else
	{
	$data_dzis = getdate();
    $data_date = $data_dzis['year'] . "-" . date('m',strtotime("now")) . "-" . $data_dzis['mday'];
	$tablica = array_unique($_POST['zadania']);
	$wykonane = 1;
       for($i = 0;$i< count($tablica);$i++)
        {
         $zapytanie = $polaczenie->prepare("update zadania_uzytkownicy set Data_Zakonczenia_Zadania = :data, Wykonane_Zadanie = :wykona where ID_ZadUzy = :id");
		 $zapytanie ->bindParam(':id',$tablica[$i]);
		 $zapytanie ->bindParam(':data',$data_date);
		 $zapytanie ->bindParam(':wykona', $wykonane);
		$zapytanie -> execute();
            
        }
	
 echo '<div class="alert alert-success"> Pomyślnie zakończono zadania</div> ';
	}

 

?>