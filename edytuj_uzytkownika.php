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
$id_uzy = $_POST['id_uzy'];
$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select * from uzytkownicy where ID_Uzytkownika = $id_uzy");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$imie = $data['Imie'];
						$nazwisko = $data['Nazwisko'];
						$login = $data['Login'];
						$haslo = $data['Haslo'];
						$poziom = $data['Poziom_Uprawnien'];
						$email = $data['Email'];
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
			<h2>Edytuj Użytkownika</h2>
								
				<form name="form_1" method="POST" id="dodaj">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="inputLogin">Login</label>
							<?php
								echo "<input type='text' class='form-control' id='inputLogin' name='Login' value=". $login .">";
							?>
						</div>
						<div class="form-group col-md-6">
						  <label for="inputHaslo">Hasło</label>
						  <?php
						  echo "<input type='password' class='form-control' id='inputHaslo' name='Haslo' value = ". $haslo .">";
						  	  echo "<input type='text' name='zmienna' value = " . $id_uzy . " hidden>";
						  ?>
						  
						</div>
					</div>
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="Imie">Imie</label>
						  <?php
								echo "<input type='text' class='form-control' id='Imie' name='Imie' value=". $imie .">";
							?>
						 </div>
						<div class="form-group col-md-6">
						  <label for="Nazwisko">Nazwisko</label>
						  <?php
								echo "<input type='text' class='form-control' id='Nazwisko' name='Nazwisko' value=". $nazwisko .">";
							?>
						  </div>
					</div>
					 <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="Email">Email</label>
						    <?php
								echo "<input type='text' class='form-control' id='Email' name='Email' value=". $email .">";
							?>
						</div>
						 <select class="form-control" name="Uprawnienie" required>
						 <?php
						 if($poziom == 2)
						 {
						echo "<option value = 2 selected>Kierownictwo</option>";
						 echo "<option value = 1>Pracownik</option>";
						 }
						 else
						 {
						echo "<option value = 2 >Kierownictwo</option>";
						 echo "<option value = 1 selected>Pracownik</option>";
						 }
						 ?>
						
						 </select>
						</div>
					
					<button type="submit" class="btn btn-primary" style="margin-top:10px;" name="SubmitButton">Edytuj Użytkownika</button>
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


