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
<script src="./style/js/repeater.js" type="text/javascript"></script>

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
			        <div style="width:100%; max-width: 900px; margin:0 auto;">
							<div class="card">
							<div class="card-header">Zakończ Zadania</div>
								<div class="card-body">
									<span id="success_result"></span>
										<form method="post" id="repeater_form">
										<div id="repeater">
										<div class="repeater-heading" align="center">
										<button type="button" class="btn btn-primary repeater-add-btn">Dodaj Kolejne Zadanie do Zakończenia</button>
										</div>
										<div class="clearfix"></div>
										<div class="items" data-group="zmienna">
										<div class="item-content">
										<div class="form-group">
										  <div class="row">
										   <div class="col-md-9">
													<label>Wybierz Zadanie (puste pole wskazuje ze nie ma zadania do którego nie był pracownik przypisany)</label>
                                                <select class="form-control" data-skip-name="true" data-name="zadania[]" required>
                                               <?php 
											   
											  	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
												$zapytanie = $polaczenie->prepare("select Concat('Pracownik: ',u.Imie,' ',u.Nazwisko) as Dane_P, Concat('Nazwa Zadania: ',z.Nazwa_Zadania) as Dane_Z, zu.ID_ZadUzy  from zadania_uzytkownicy zu join uzytkownicy u on u.ID_Uzytkownika=zu.ID_Uzytkownika join zadania z on z.ID_Zadania=zu.ID_Zadania where zu.ID_Projektu = $id_projektu and zu.Wykonane_Zadanie = 0");
												$zapytanie -> execute();
												while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
												{
												echo "<option value='" . $data['ID_ZadUzy'] . "' >". $data['Dane_P'] . " " . $data['Dane_Z']. "</option>";
												}
												?>
                                                </select>
                                            </div>
                                            <div class="col-md-3" style="margin-top:52px;" align="center">
                                                <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">Usuń</button>
                                            </div>
          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
							<div class="clearfix"></div>
									<div class="form-group" align="center">
										<br /><br />
										<input type="submit" name="insert" class="btn btn-success" value="Zakończ Zadania" />
                        </div>
                    </form>
						
                </div>
				
            </div>
				<a href="./projekt_strona_glowna.php" class="btn btn-primary" style="margin-top:10px;">Powrót do Strony Głównej Projektu</a>
      
        </div>
			
		</div>
		
	</body>
 <script>
    $(document).ready(function(){

        $("#repeater").createRepeater();

        $('#repeater_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"zakoncz_zadanie_ajax.php",
                method:"POST",
                data:$(this).serialize(),
                success:function(data)
                {
                    $('#repeater_form')[0].reset();
                    $("#repeater").createRepeater();
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


