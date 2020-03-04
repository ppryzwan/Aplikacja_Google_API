<?php
require('klasy.php');
require('funkcje.php');
session_start();

if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}
$obiekt = $_SESSION['obiekt'];

	
$id_obiektu = $obiekt->getid();

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
			<?php
			echo "<h5 style='margin-top:10px;'> Aktywne Projekty</h5>";
			echo "<span id='success_result'></span>";
			$id = $obiekt->getid();
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select p.ID_Projektu, p.Nazwa_Projektu, pu.Uprawnienia from projekty_uzytkownicy pu join projekt p on p.ID_Projektu=pu.ID_Projektu where pu.ID_Uzytkownika = $id and p.Data_Zakonczenia_Projektu is null order by pu.Uprawnienia desc ");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$id_projektu = $data['ID_Projektu'];
					echo "<div class='card' style='margin-top:10px;' ><div class='card-body'>";
					echo "<h5 class='class-title'>Nazwa Projektu: " . $data['Nazwa_Projektu'] . "</h5>";
					$zapytanie_1 = $polaczenie->prepare("select zu.ID_ZadUzy, z.Nazwa_Zadania from zadania_uzytkownicy zu join zadania z on z.ID_Zadania=zu.ID_Zadania where zu.Wykonane_Zadanie = 0 and zu.ID_Uzytkownika = $id and zu.ID_Projektu = $id_projektu");
					$zapytanie_1 -> execute();
					echo "<h5>Zadania</h5>";
					echo "<ul class='list-group'>";
					while($data_1 = $zapytanie_1->fetch(PDO::FETCH_ASSOC))
								{
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $data_1['Nazwa_Zadania'];	
								echo "<form method=POST id='form' ><input type='text' value= " . $data_1['ID_ZadUzy'] ." name='id_Zad' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Zakończ Zadanie</button></form></li>";
								
								}
					echo "</ul>";
					echo "<h5 style='margin-top:10px;'>Wydarzenia</h5>";
					echo "<div class='list-group'>";
					$zapytanie_2 = $polaczenie->prepare("select *, datediff(Data_Zdarzenia,Now()) as Liczba from zdarzenia Where ID_Projektu = $id_projektu and Now() <= Data_Zdarzenia order by Data_Zdarzenia desc limit 3");
					$zapytanie_2 -> execute();
						while($data_3 = $zapytanie_2->fetch(PDO::FETCH_ASSOC))
								{
									echo "<a href='./droga_wydarzenie.php?id_wydarzenia=". $data_3['ID_Zdarzenia'] ."' class='list-group-item list-group-item-action'>";
									echo "<div class='d-flex w-100 justify-content-between'>";
									echo "<h5 class='mb-1'>". $data_3['Nazwa_Zdarzenia'] . "</h5>";
									echo "<small>Wydarzenie za " . $data_3['Liczba'] . " dni</small></div>";
								echo "<p class='mb-1'>Przewidywany czas spotkania: ". $data_3['Przewidywany_Czas'] . " godzin</p></a>";
								}
					echo "</div></div>";
					echo "<form method=POST action='./projekt_strona_glowna.php' ><input type='text' value= " . $id_projektu ." name='id_projektu' hidden><button style='margin:10px;' type='submit' class='btn btn-primary' name='SubmitButton'>Przejdz do strony głównej projektu</button></form>";
								
					
					echo "</div>";
					}
				if($obiekt->Poziom() == 2)
				{
					echo "<h5> Zakończone Projekty</h5>";
					$zapytanie = $polaczenie->prepare("select p.ID_Projektu, p.Nazwa_Projektu, pu.Uprawnienia from projekty_uzytkownicy pu join projekt p on p.ID_Projektu=pu.ID_Projektu where pu.ID_Uzytkownika = $id and p.Data_Zakonczenia_Projektu is not null order by pu.Uprawnienia desc ");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					$id_projektu_1 = $data['ID_Projektu'];
					echo "<div class='card' style='margin-top:10px;' ><div class='card-body'>";
					echo "<h5 class='class-title'>Nazwa Projektu: " . $data['Nazwa_Projektu'] . "</h5>";
					$zapytanie_1 = $polaczenie->prepare("select zu.ID_ZadUzy, z.Nazwa_Zadania from zadania_uzytkownicy zu join zadania z on z.ID_Zadania=zu.ID_Zadania where zu.Wykonane_Zadanie = 0 and zu.ID_Uzytkownika = $id and zu.ID_Projektu = $id_projektu_1");
					$zapytanie_1 -> execute();
					echo "<h5>Zadania</h5>";
					echo "<ul class='list-group'>";
					while($data_1 = $zapytanie_1->fetch(PDO::FETCH_ASSOC))
								{
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $data_1['Nazwa_Zadania'];	
								echo "<form method=POST id='form' ><input type='text' value= " . $data_1['ID_ZadUzy'] ." name='id_Zad' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Zakończ Zadanie</button></form></li>";
								
								}
					echo "</ul>";
					echo "<h5 style='margin-top:10px;'>Wydarzenia</h5>";
					echo "<div class='list-group'>";
					$zapytanie_2 = $polaczenie->prepare("select *, datediff(Data_Zdarzenia,Now()) as Liczba from zdarzenia Where ID_Projektu = $id_projektu_1 and Now() <= Data_Zdarzenia order by Data_Zdarzenia desc limit 3");
					$zapytanie_2 -> execute();
						while($data_3 = $zapytanie_2->fetch(PDO::FETCH_ASSOC))
								{
									echo "<a href='./droga_wydarzenie.php?id_wydarzenia=". $data_3['ID_Zdarzenia'] ."' class='list-group-item list-group-item-action'>";
									echo "<div class='d-flex w-100 justify-content-between'>";
									echo "<h5 class='mb-1'>". $data_3['Nazwa_Zdarzenia'] . "</h5>";
									echo "<small>Wydarzenie za " . $data_3['Liczba'] . " dni</small></div>";
								echo "<p class='mb-1'>Przewidywany czas spotkania: ". $data_3['Przewidywany_Czas'] . " godzin</p></a>";
								}
					echo "</div></div>";
					echo "<form method=POST action='./projekt_strona_glowna.php' ><input type='text' value= " . $id_projektu_1 ." name='id_projektu' hidden><button style='margin:10px;' type='submit' class='btn btn-primary' name='SubmitButton'>Przejdz do strony głównej projektu</button></form>";
								
					
					echo "</div>";
					}
				}
				?>
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
</script>
</html>


