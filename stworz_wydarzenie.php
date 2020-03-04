
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
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> 
<script src="./style/js/jquery-3.3.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./style/css/bootstrap.min.css">
<script src="./style/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7tJYiv7H64cBrmugqyVgAZMXl6C2nbg&libraries=places"> 
</script>

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
			<h2>Stwórz Nowe Zdarzenie</h2>
								
				<form name="form_1" method="POST" action="./dodaj_wydarzenie_query.php">
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label for="inputZdarzenie">Nazwa Zdarzenia</label>
						  <input type="text" class="form-control" id="inputZdarzenie" name="Nazwa Zdarzenia" placeholder="Nazwa Zdarzenia">
						</div>
						<div class="form-group col-md-6">
						  <label for="inputCzas">Przewidywany Czas</label>
						  <input type="number" class="form-control" id="inputCzas" min="0" max="10" name="Czas" placeholder="Przewidywany Czas">
						</div>
					</div>
				 <div class="form-group">

					<?php 
	
					echo "<input type='datetime-local' class='form-control'  min='". Date('Y-m-d') .'T' . Date('H:i') . "' name = 'data_roz'  required >
					<span class='validity'></span>";
					?>
					</div>
					    <input id="pac-input" name="adres"
							class="controls"
								type="text"
									placeholder="Wpisz Lokalizacje">
					<input type="text" name="lat" id="lat" hidden>
				<input type="text" name="long" id="long" hidden>
					<button type="submit" class="btn btn-primary" name="SubmitButton" style="margin:10px;">Dodaj Wydarzenie</button>
					</form>
					
						<div id="map"></div>
							<a href="./projekt_strona_glowna.php" class="btn btn-primary" style="margin-top:10px;">Powrót do Strony Głównej Projektu</a>
      
		</div>
		
		
	</body>
 <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 52.237049, lng: 21.017532},
          zoom: 7
     });

        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

      
        autocomplete.setFields(['place_id', 'geometry', 'name']);

        var marker = new google.maps.Marker({map: map});

     

        autocomplete.addListener('place_changed', function() {
         

          var place = autocomplete.getPlace();
			document.getElementById('lat').value = place.geometry.location.lat();
			document.getElementById('long').value = place.geometry.location.lng();
			
          if (!place.geometry) {
            return;
          }

          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
          }

          // Set the position of the marker using the place ID and location.
          marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
          });

          marker.setVisible(true);

        });
      }
	  
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7tJYiv7H64cBrmugqyVgAZMXl6C2nbg&libraries=places&callback=initMap">
    </script>

</html>


