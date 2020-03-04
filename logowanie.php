<?php 
require('klasy.php');
session_start();


$polaczenie = new mysqli('localhost', 'root','','praca');

if (mysqli_connect_errno() !=0)
	{
	echo 'Jest blad polaczenia '.mysqli_connect_error();
	exit;
	}
	
	$login = $_POST['login'];
	$password = md5($_POST['haslo']);
	
	$sql = "Select * from uzytkownicy where Login = '$login' and Haslo = '$password'";
	$wynik = $polaczenie -> query($sql);
   //czy liczba wierszy jest rowna 0
	$ilerowsow = $wynik->num_rows;
	
	if($ilerowsow ==  0)
	{
		header("Location: formularz_logowania.php");
		exit;
	}
	else
	{		

		$rekord = $wynik -> fetch_assoc();
	
		if($rekord['Poziom_Uprawnien'] == 2)
		{
			$obiekt = new Kierownik($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
		else if($rekord['Poziom_Uprawnien'] == 1)
		{
			$obiekt = new Pracownik($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
		else if($rekord['Poziom_Uprawnien'] == 3)
		{
			$obiekt = new Admin($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
			header("Location: index.php");
			exit;
	}
	
	if (!isset($_SESSION['obiekt'])) 
{
header("Location: formularz_logowania.php");
   exit;
}


?>

