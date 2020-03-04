<?php

require_once('klasy.php');
require_once('funkcje.php');
session_start();
if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}
$obiekt = $_SESSION['obiekt'];
if(isset($_POST['zmienna']))
$obiekt -> edytuj_uzytkownika($_POST['zmienna'],$_POST['Imie'],$_POST['Nazwisko'],$_POST['Uprawnienie'],$_POST['Login'],$_POST['Haslo'],$_POST['Email']);	
else
$obiekt -> dodaj_uzytkownika($_POST['Imie'],$_POST['Nazwisko'],$_POST['Uprawnienie'],$_POST['Login'],$_POST['Haslo'],$_POST['Email']);

?>