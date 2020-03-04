<?php
          
function dodajProjekt($nazwa,$data,$id,$link_dysk_google = "null")
{
$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');

$dodanie = $polaczenie->prepare('insert into projekt (Nazwa_Projektu,Data_Rozpoczecia_Projektu,Link_Dysk_Google) values (:nazwa,:data,:dysk)');
$dodanie ->bindParam(':nazwa',$nazwa);
$dodanie ->bindParam(':data',$data);
$dodanie ->bindParam(':dysk',$link_dysk_google);
$dodanie ->execute();
$ostatni_dodany_rekord = $polaczenie -> lastInsertId();


$dodanie_1 = $polaczenie->prepare('insert into projekty_uzytkownicy (ID_Uzytkownika,ID_Projektu,Uprawnienia) values (:id_u,:id_p,:uprawnienia)');
$dodanie_1 ->bindParam(':id_u',$id);
$dodanie_1 ->bindParam(':id_p',$ostatni_dodany_rekord);
$uprawnienie = 1;
$dodanie_1 ->bindParam(':uprawnienia',$uprawnienie);
$dodanie_1 ->execute();

return $ostatni_dodany_rekord;
}

     			   
	function dodajZadanie($nazwa)
{
$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');

$dodanie = $polaczenie->prepare('insert into zadania (Nazwa_Zadania) values (:nazwa)');
$dodanie ->bindParam(':nazwa',$nazwa);
$dodanie ->execute();

$ostatni_dodany_rekord = $polaczenie -> lastInsertId();

return $ostatni_dodany_rekord;
}


		?>
