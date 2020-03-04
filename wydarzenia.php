<?php
require('funkcje.php');
require('klasy.php');
session_start();

if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}
//$id = $_GET['id_wydarzenia'];
$obiekt = $_SESSION['obiekt'];

$id_projektu=$_SESSION['id_projektu'];
$poziom_pomoc = $obiekt->Poziom();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> 
<script src="./style/js/jquery-3.3.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./style/css/bootstrap.min.css">
<script src="./style/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="./style/DataTable/datatables.min.css"/>
 
<script type="text/javascript" src="./style/DataTable/datatables.min.js"></script>


</head>
<body>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
			
			<button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="collapse_target">
			<a class="navbar-brand" href="index.php"><img style="width:80%; " src="./obrazy/home.png"></a>
			<ul class="navbar-nav">
			<li class="nav-item">
					<a class="nav-link" href="index.php">Strona Główna</a>
				</li>
				<?php 
				if($poziom_pomoc == 2)
				{
					echo "<li class='nav-item dropdown'>";
					echo "<a class='nav-link dropdown-toggle' data-toggle='dropdown' data-target='projekty'  href='#'>";
					echo "Zarządzaj Projektami";
					echo "<span class='caret'></span>";
					echo "</a>";
				echo "<div class='dropdown-menu' aria-labelledby='projekty'>";
				echo "<a class='dropdown-item' href='./stworz_nowy_projekt.php'>Stwórz Nowy Projekt</a>";
				echo "<div class='dropdown-divider'></div>";
				echo "<a class='dropdown-item' href='./projekty_wybor.php'>Zarządzaj Projektami</a>";
					echo "<div class='dropdown-divider'></div>";
					echo "<a class='dropdown-item' href='./zakoncz_projekt.php'>Zakończ Projekt</a>";
				echo "</div>";
					
				echo "</li>";
				}
				
				if($poziom_pomoc == 3)
				{
				echo "<li class='nav-item dropdown'>";
				echo "<a class='nav-link dropdown-toggle' data-toggle='dropdown' data-target='uzytkownicy' href='#'>Uzytkownicy</a>";
				echo "<span class='caret'></span>";
				echo "<div class='dropdown-menu' aria-labelledby='uzytkownicy'>";
				echo "<a class='dropdown-item' href='./dodaj_pracownika.php'>Dodaj Nowego Użytkownika</a>";
				echo "<div class='dropdown-divider'></div>";
				echo"<a class='dropdown-item' href ='./uzytkownicy.php'>Zarządzaj Użytkownikiem</a>";				
				echo "</li>";
				}
				?>
				<li class="nav-item">
					<a class="nav-link" href="./edytuj_dane.php">Edytuj Dane Logowania</a>
				</li>
					<li class="nav-item">
					<a class="nav-link" href="wyloguj.php">Wyloguj się</a>
				</li>
			</div>
			
			</ul>
			</div>
		</nav>
		
		<div class="container" style="margin-top:10px;">
				<table class="table table-striped table-bordered table-hover" id="data">
				<thead>
					<tr>
					<th>Nazwa Zdarzenia</td>
					<th>Data Zdarzenia</td>
					<th>Przewidywany Czas</td>
					<th>Dodatkowe</td>
					</tr>
					
				</thead>
				<tfoot>
					<tr>
					<th>Nazwa Zdarzenia</td>
					<th>Data Zdarzenia</td>
					<th>Przewidywany Czas</td>
					<th>Dodatkowe</td>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select *  from zdarzenia Where ID_Projektu = $id_projektu");
						$zapytanie -> execute();
						while($data_1 = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
									echo "<tr><td>" . $data_1['Nazwa_Zdarzenia'] . "<td>" . $data_1['Data_Zdarzenia'] . "<td>" . $data_1['Przewidywany_Czas'] . " godzin";
								
									echo "<td><form method=POST action='./droga_wydarzenie.php'><input type='text' value= " . $data_1['ID_Zdarzenia'] ." name='id_zd' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Wyznacz Droge</button></form>";
								}
				
		
				?>
				</tbody>
				</table>
					<a href="./projekt_strona_glowna.php" class="btn btn-primary" style="margin-top:10px;">Powrót do Strony Głównej Projektu</a>
      
			</div>
		
	</body>

<script>
	$('#data').dataTable();
</script>
</html>
