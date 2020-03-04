<?php
require('funkcje.php');
require('klasy.php');
session_start();

if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}
if (isset($_GET['id_wydarzenia'])) 
{
$id = $_GET['id_wydarzenia'];
}
else
{
	$id = $_POST['id_zd'];
}
$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select * from zdarzenia where ID_Zdarzenia = $id");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
						$id_projektu = $data['ID_Projektu'];
					}
						
$obiekt = $_SESSION['obiekt'];
$_SESSION['id_projektu'] = $id_projektu;

if(isset($_POST['id_projektu']))
	$_SESSION['id_projektu'] = $_POST['id_projektu'];
if(isset($_SESSION['id_projektu']))
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
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7tJYiv7H64cBrmugqyVgAZMXl6C2nbg&libraries=places"> 
</script>
<script type="text/javascript" src="./style/DataTable/datatables.min.js"></script>
<style>

      #map {
        height: 100%;
		width:100%;
      }
    
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  
	  .mapa{
		  padding-top:20px;
		  height:400px;
		  margin:0 auto;
	  }
    </style>

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
			<div class="container mapa">
				<div id="map"></div>
			<form name="form_1" method="POST" action="droga_wydarzenie_direction.php">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="adres">Adres</label>
						  <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" required>
						</div>
					</div>
						
					<?php echo 	
					"<input type=text name='id_wydarzenia' value=$id hidden>";
					?>
				
					<button type="submit" class="btn btn-primary" name="SubmitButton">Wyznacz Droge</button>
						
					</form>
			
			
				<a href="./projekt_strona_glowna.php" class="btn btn-primary" style="margin-top:10px;">Powrót do Strony Głównej Projektu</a>
      
		
			</div>
    <script>
      function initMap() {
		  initAutocomplete();
        var wydarzenie = {lat: 
		<?php
		$polaczenie = new PDO('mysql:host=localhost;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select *  from zdarzenia Where ID_Zdarzenia = $id");
						$zapytanie -> execute();
						while($data_1 = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo " " . $data_1['LatAtt'] . ", lng: " . $data_1['LongAtt'] . "};";
							}
		?>
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: wydarzenie
        });
	
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
           
				<?php
		$polaczenie = new PDO('mysql:host=localhost;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select *  from zdarzenia Where ID_Zdarzenia = $id");
						$zapytanie -> execute();
						while($data_1 = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo "'<h1 id=firstHeading class=firstHeading>". $data_1['Nazwa_Zdarzenia'] . "</h1>'+";
								echo "'<div id=bodyContent>' +";
								echo "'<p>Przewidywany czas: " . $data_1['Przewidywany_Czas'] . " Odbywa się w : " . $data_1['Data_Zdarzenia'] . "</p>' +";
							}
		?>
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
        });

        var marker = new google.maps.Marker({
          position: wydarzenie,
          map: map,
          title: 'Wydarzenie'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
	   function initAutocomplete() {
 
    autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('adres')),
        {types: ['geocode']});

    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

  }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7tJYiv7H64cBrmugqyVgAZMXl6C2nbg&libraries=places&callback=initMap">
    </script>
  </body>
</html>
