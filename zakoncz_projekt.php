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
			<span id='success_result'></span>
			<h2>Zakończ Projekt</h2>
								
				<form name="form_1" method="POST" id="mail_form">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="inputProjekt">Projekt</label>
							<select class="form-control" name="id_projektu" required>
                                               <?php 
											$zm = $obiekt->getid();
											  	$polaczenie = new PDO('mysql:host=localhost;dbname=praca','root','');
												$zapytanie = $polaczenie->prepare("Select * from projekt p join projekty_uzytkownicy pu on p.ID_Projektu=pu.ID_Projektu where pu.ID_Uzytkownika = $zm and pu.Uprawnienia=1");
												$zapytanie -> execute();
												while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
												{
												echo "<option value='" . $data['ID_Projektu'] . "' >". $data['Nazwa_Projektu'] . "</option>";
												}
												?>
                                                </select>
							
							</div>
						
					</div>
	
					<button type="submit" class="btn btn-primary" name="SubmitButton">Zakończ Projekt</button>
					</form>
		</div>
		
	</body>

	<script>
    $(document).ready(function(){
        $('#mail_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"zakoncz_projekt_ajax.php",
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
