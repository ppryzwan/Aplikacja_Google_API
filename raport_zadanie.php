<?php
error_reporting(E_ERROR);
require('./tfpdf/tfpdf.php');
require('klasy.php');
session_start();
if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}

$obiekt = $_SESSION['obiekt'];
$id_projektu = $_SESSION['id_projektu'];
$poczatek = substr($_POST['datefilter'],0,10);
$koniec = substr($_POST['datefilter'],14);
$id_pracownika = $_POST['ID_Pracownika'];
$pdf = new tFPDF();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			$pdf->SetFont('DejaVu','',14);
	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
		if($id_pracownika == 0)	
		{			
		$pdf -> AddPage();
	$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(75,15,'',0,0);

		$pdf -> Cell(50,15,'Wszyscy',0,1,'C');
	$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(80,8,'Pracownik',1,0,'L');
		$pdf -> Cell(70,8,"Nazwa Zadania",1,0,'L');
		$pdf -> Cell(40,8,'Ilosc Przypisanych',1,1,'L');
		
		$zapytanie = $polaczenie->prepare("select Concat(u.Imie,' ',u.Nazwisko) as Dane,z.Nazwa_Zadania, count(z.ID_Zadania) as ile from zadania_uzytkownicy zu join uzytkownicy u on u.ID_Uzytkownika=zu.ID_Uzytkownika join zadania z on z.ID_Zadania=zu.ID_Zadania  where zu.ID_Projektu = $id_projektu and zu.Data_Rozpoczecia_Zadania >= '$poczatek' and (zu.Data_Zakonczenia_Zadania <= '$koniec' or isnull(zu.Data_Zakonczenia_Zadania)) group by  Concat(u.Imie,' ',u.Nazwisko),z.Nazwa_Zadania");
			$zapytanie -> execute();
		while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$pdf -> Cell(80,8,$data['Dane'],1,0,'L');
						$pdf -> Cell(70,8,$data['Nazwa_Zadania'],1,0,'L');
						$pdf -> Cell(40,8,$data['ile'],1,1,'L');
						$pdf -> SetFillColor(255,255,255);
						
							
					}
		
		}
	else
	{
		$pdf -> AddPage();
		$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(75,15,'',0,0);
		$zapytanie = $polaczenie->prepare("select Concat(u.Imie,' ',u.Nazwisko) as Dane from  uzytkownicy u where u.ID_Uzytkownika = $id_pracownika");
		$zapytanie -> execute();
	while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					$pdf -> Cell(50,15,$data['Dane'],0,1,'C');		
					}

		
		$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(80,8,"Nazwa Zadania",1,0,'L');
		$pdf -> Cell(40,8,'Ilosc Przypisanych',1,1,'L');
		
		$zapytanie = $polaczenie->prepare("select z.Nazwa_Zadania, count(z.ID_Zadania) as ile from zadania_uzytkownicy zu join zadania z on z.ID_Zadania=zu.ID_Zadania  where zu.ID_Projektu = $id_projektu and zu.Data_Rozpoczecia_Zadania >= '$poczatek' and (zu.Data_Zakonczenia_Zadania <= '$koniec' or isnull(zu.Data_Zakonczenia_Zadania)) and zu.ID_Uzytkownika = $id_pracownika group by z.Nazwa_Zadania");
			$zapytanie -> execute();
		while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
						$pdf -> Cell(80,8,$data['Nazwa_Zadania'],1,0,'L');
						$pdf -> Cell(40,8,$data['ile'],1,1,'L');
						$pdf -> SetFillColor(255,255,255);
						
							
					}
	}
	
		

$pdf -> Output();

?>