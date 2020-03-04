<?php
require('funkcje.php');
require('klasy.php');
session_start();

if (!isset($_SESSION['obiekt'])) 
{
	header("Location: formularz_logowania.php");
		exit;
}
$id = $_POST['id_wydarzenia'];
$obiekt = $_SESSION['obiekt'];

$id_projektu=$_SESSION['id_projektu'];


$ulica_poczatkowa = $_POST['adres'];


		$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select *  from zdarzenia Where ID_Zdarzenia = $id");
						$zapytanie -> execute();
						while($data_1 = $zapytanie->fetch(PDO::FETCH_ASSOC))
						{
							$ulica_koncowa = $data_1['Adres_Google'];
						$lat = $data_1['LatAtt'];
						$long = $data_1['LongAtt'];
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
<style>
 
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 20px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      #right-panel {
        height: 100%;
        float: right;
        width: 250px;
        overflow: auto;
      }
      #map {
        height: 100%;
		width:70%;
		
		  
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
				<div id="floating-panel">
    </div>
    <div id="right-panel"></div>
    <div id="map"></div>
	<a href="./wydarzenia.php" class="btn btn-primary" style="margin-top:10px;">Powrót do wyświetlenia wszystkich wydarzeń</a>
			</div>
    <script>
      function initMap() {
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: <?php 
		  echo $lat . ", lng: ". $long . "}";
		  ?>
        });
			calculateAndDisplayRoute(directionsService, directionsDisplay);
        directionsDisplay.setMap(map);
      
	  directionsDisplay.setPanel(document.getElementById('right-panel'));
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var start = <?php 
		echo "'" . $ulica_poczatkowa . "';";
		echo "var end = '" . $ulica_koncowa . "';";
		?>
        directionsService.route({
          origin: start,
          destination: end,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7tJYiv7H64cBrmugqyVgAZMXl6C2nbg&callback=initMap">
    </script>
  </body>
</html>
