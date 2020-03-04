<!DOCTYPE html>
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
$id_projektu = $_SESSION['id_projektu'];
$_SESSION['id_projektu'] = $id_projektu;
$id_obiektu = $obiekt->getid();
	
	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select * from projekty_uzytkownicy where ID_Projektu = $id_projektu and ID_Uzytkownika = $id_obiektu");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$uprawnienia_pomoc = $data['Uprawnienia'];
					}
					
					if($uprawnienia_pomoc != 1)
					{
							header("Location: index.php");
							exit;
					}
					$poziom_pomoc = $obiekt->Poziom();
?>

<html>
<head>
<meta charset="UTF-8"> 
<script src="./style/js/jquery-3.3.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./style/css/bootstrap.min.css">
<script src="./style/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">



</head>
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
		<div class="container">
			<h2>Stwórz Nowe Zadanie</h2>
								
				<form name="form_1" method="POST" action="./przypisz_pracownikow.php">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="inputZadanie">Nazwa Zadanie</label>
						  <input type="text" class="form-control" id="inputZadanie" name="Nazwa_Zadania" placeholder="Nazwa Zadania">
						</div>
							</div>
					<button type="submit" class="btn btn-primary" name="SubmitButtonZadanie">Dodaj Zadanie</button>
						<a href="./projekt_strona_glowna.php" class="btn btn-primary" >Powrót do Strony Głównej Projektu</a>
      
					</form>
	
		</div>
		
	</body>


</html>


