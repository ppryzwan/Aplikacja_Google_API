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

	if($obiekt->Poziom() == 1 or $obiekt->Poziom() == 2)
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
		<div style="margin-top:10px;" class="container">
		<span id="success_result"></span>
			<h2>Dodaj nowego użytkownika</h2>
								
				<form name="form_1" method="POST" id="dodaj">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="inputLogin">Login</label>
						  <input type="text" class="form-control" id="inputLogin" name="Login" placeholder="Login">
						</div>
						<div class="form-group col-md-6">
						  <label for="inputHaslo">Hasło</label>
						  <input type="password" class="form-control" id="inputHaslo" name="Haslo" placeholder="Hasło">
						</div>
					</div>
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="Imie">Imie</label>
						  <input type="text" class="form-control" id="Imie" name="Imie" placeholder="Imie">
						</div>
						<div class="form-group col-md-6">
						  <label for="Nazwisko">Nazwisko</label>
						  <input type="text" class="form-control" id="Nazwisko" name="Nazwisko" placeholder="Nazwisko">
						</div>
					</div>
					 <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="Email">Email</label>
						  <input type="text" class="form-control" id="Email" name="Email" placeholder="Email">
						</div>
						 <select class="form-control" name="Uprawnienie" required>
						 <option value = 2>Kierownictwo</option>
						 <option value = 1>Pracownik</option>
						 </select>
						</div>
					
					<button type="submit" class="btn btn-primary" style="margin-top:10px;" name="SubmitButton">Dodaj Użytkownika</button>
					</form>
		</div>
		
	</body>
 <script>
    $(document).ready(function(){

    
        $('#dodaj').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"dodaj_uzytkownika_ajax.php",
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


