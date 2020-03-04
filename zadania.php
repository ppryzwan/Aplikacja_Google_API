<?php
require('funkcje.php');
require('klasy.php');
session_start();

if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}

$obiekt = $_SESSION['obiekt'];

$id_projektu=$_SESSION['id_projektu'];
	
$id_obiektu = $obiekt->getid();
	
	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select * from projekty_uzytkownicy where ID_Projektu = $id_projektu and ID_Uzytkownika = $id_obiektu");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$uprawnienia_pomoc = $data['Uprawnienia'];
					}
					
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
		<span id='success_result'></span>
				<table class="table table-striped table-bordered table-hover" id="data">
				<thead>
					<tr>
					<th>Nazwa Zadania</th>
					<?php
						if($uprawnienia_pomoc == 1)
							echo "<th>Dane Pracownika</th>";
					?>
					
					<th>Data Rozpoczecia Zadania</th>
					<th>Data Zakonczenia Zadania</th>
					<th>Wykonane Zadanie</th>
					<th>Dodatkowe</th>
					</tr>
					
				</thead>
				<tfoot>
					<tr>
					<th>Nazwa Zadania</th>
				<?php
						if($uprawnienia_pomoc == 1)
							echo "<th>Dane Pracownika</th>";
					?>
					<th>Data Rozpoczecia Zadania</th>
					<th>Data Zakonczenia Zadania</th>
					<th>Wykonane Zadanie</th>
					<th>Dodatkowe</th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				if($uprawnienia_pomoc == 1)
				{
					$zapytanie = $polaczenie->prepare("select zu.ID_ZadUzy ,z.Nazwa_Zadania,Concat(u.Imie,' ',u.Nazwisko) as Dane,zu.Data_Rozpoczecia_Zadania,zu.Data_Zakonczenia_Zadania,zu.Wykonane_Zadanie from zadania z join zadania_uzytkownicy zu on zu.ID_Zadania=z.ID_Zadania join uzytkownicy u on u.ID_Uzytkownika=zu.ID_Uzytkownika  where zu.ID_Projektu =$id_projektu");
						$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo "<tr><td>" . $data['Nazwa_Zadania'] . "<td>" . $data['Dane'] . "<td>" . $data['Data_Rozpoczecia_Zadania'];
								if($data['Data_Zakonczenia_Zadania'] == null)
									echo "<td> Brak";
								else
									echo "<td>" . $data['Data_Zakonczenia_Zadania'];
								if($data['Wykonane_Zadanie'] == 1)
								{
									echo "<td> Tak";
									echo "<td>";
								}
								else	
								{
									echo "<td> Nie";
									echo "<td><form method=POST id='form' ><input type='text' value= " . $data['ID_ZadUzy'] ." name='id_Zad' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Zakończ Zadanie</button></form>";
								
								}
								}
				}
				else
				{
					$zapytanie = $polaczenie->prepare("select zu.ID_ZadUzy ,z.Nazwa_Zadania, zu.Data_Rozpoczecia_Zadania,zu.Data_Zakonczenia_Zadania,zu.Wykonane_Zadanie from zadania z join zadania_uzytkownicy zu on zu.ID_Zadania=z.ID_Zadania join uzytkownicy u on u.ID_Uzytkownika=zu.ID_Uzytkownika  where zu.ID_Projektu =$id_projektu and zu.ID_Uzytkownika = $id_obiektu");
						$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo "<tr><td>" . $data['Nazwa_Zadania'] .  "<td>" . $data['Data_Rozpoczecia_Zadania'];
								if($data['Data_Zakonczenia_Zadania'] == null)
									echo "<td> Brak";
								else
									echo "<td>" . $data['Data_Zakonczenia_Zadania'];
								if($data['Wykonane_Zadanie'] == 1)
								{
									echo "<td> Tak";
									echo "<td>";
								}
								else	
								{
									echo "<td> Nie";
									echo "<td><form method=POST id='form' ><input type='text' value= " . $data['ID_ZadUzy'] ." name='id_Zad' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Zakończ Zadanie</button></form>";
								
								}
								}
					
					
				}
				?>
				</tbody>
				</table>
				
			<a href="./projekt_strona_glowna.php" class="btn btn-primary" style="margin-top:10px;">Powrót do Strony Głównej Projektu</a>
      
			</div>
		
	</body>
<script>
    $(document).ready(function(){

        $('#form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"zakoncz_zadanie_ajax.php",
                method:"POST",
                data:$(this).serialize(),
                success:function(data)
                {
       
                    $('#success_result').html(data);
                    /*setInterval(function(){
                        location.reload();
                    }, 3000);*/
                }
            });
        });

    });
	$('#data').dataTable();
	
</script>
</html>
