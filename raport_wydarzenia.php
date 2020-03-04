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




$pdf = new tFPDF();
	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
	
		$pdf -> AddPage();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(75,15,'',0,0);

		$pdf -> Cell(50,15,'Wydarzenia projektu ' . $id_projektu,0,1,'C');
			$pdf->SetFont('DejaVu','',14);
		$pdf -> Cell(70,8,'Nazwa Zdarzenia',1,0,'L');
		$pdf -> Cell(30,8,"Czas",1,0,'L');
		$pdf -> Cell(90,8,'Adres',1,1,'L');
		
		$zapytanie = $polaczenie->prepare("select Nazwa_Zdarzenia, Przewidywany_Czas, Adres_Google,Data_Zdarzenia from zdarzenia where ID_Projektu = $id_projektu and Data_Zdarzenia >= '$poczatek' and Data_Zdarzenia <= '$koniec' order by Data_Zdarzenia desc");
		$zapytanie -> execute();
		while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$pdf -> Cell(70,8,$data['Nazwa_Zdarzenia'] ,1,0,'L');
						$pdf -> Cell(30,8,$data['Przewidywany_Czas'] . " godzin",1,0,'L');
						$pdf -> Cell(90,8,$data['Adres_Google'],1,1,'L');
						$pdf -> SetFillColor(255,255,255);
						
							
					}
		
	
	
		

$pdf -> Output();

?>