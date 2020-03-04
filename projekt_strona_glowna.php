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

	if(isset($_POST['id_projektu']))
	$_SESSION['id_projektu'] = $_POST['id_projektu'];
if(isset($_SESSION['id_projektu']))
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
<link rel="stylesheet" type="text/css" href=".style/DataTable/datatables.min.css"/>
 
<script type="text/javascript" src=".style/DataTable/datatables.min.js"></script>


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
	
		<div class="row justify-content-center">
				<h3 > Strona Główna Projektu</h3>
				</div>
				<?php
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("select * from projekt where ID_Projektu = $id_projektu");
				$zapytanie -> execute();
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					echo "<div class='row justify-content-center'><h3>Nazwa: " . $data['Nazwa_Projektu'] . "</h3></div>"; 
					echo "<div class='row justify-content-center'><h3>Data Rozpoczęcia Projektu: " . $data['Data_Rozpoczecia_Projektu'] . "</h3></div>"; 
					if(($data['Data_Zakonczenia_Projektu']) != null)
						echo "<div class='row justify-content-center'><h3>Data Zakończenia Projektu:" . $data['Data_Zakonczenia_Projektu'] . "</h3></div>";
					else
						echo "<span id='success_result'></span>";
					if($data['Link_Dysk_Google'] == 'null')
						echo "<div class='row justify-content-center'><h3> Brak Linku Dysku Google</h3></div>";
					else
						echo "<div class='row justify-content-center'><h3>Link do dysku Google:" . $data['Link_Dysk_Google'] . "</h3></div>";
					}
			
				?>
				
	
							<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Zadania</h5>
				<ul class="list-group">
				<?php
					$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
						if($uprawnienia_pomoc ==1)
						{
						$zapytanie = $polaczenie->prepare("select z.Nazwa_Zadania, count(z.ID_Zadania) as Ilosc from zadania z join zadania_uzytkownicy zu on zu.ID_Zadania=z.ID_Zadania Where zu.ID_Projektu = $id_projektu group by z.Nazwa_Zadania order by Ilosc desc limit 5");
						$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $data['Nazwa_Zadania'];
								echo "<span class='badge badge-primary badge-pill'>" . $data['Ilosc'] ." </span></li>";
								
								}
						}
						else
						{	$id = $obiekt->getid();
							echo "<span id='success_result'></span>";
						$zapytanie_1 = $polaczenie->prepare("select zu.ID_ZadUzy, z.Nazwa_Zadania from zadania_uzytkownicy zu join zadania z on z.ID_Zadania=zu.ID_Zadania where zu.Wykonane_Zadanie = 0 and zu.ID_Uzytkownika = $id and zu.ID_Projektu = $id_projektu limit 5");
					$zapytanie_1 -> execute();
					while($data_1 = $zapytanie_1->fetch(PDO::FETCH_ASSOC))
								{
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $data_1['Nazwa_Zadania'];	
								echo "<form method=POST id='form' ><input type='text' value= " . $data_1['ID_ZadUzy'] ." name='id_Zad' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Zakończ Zadanie</button></form></li>";
								
								}
					echo "</ul>";
						}
				?>
			
  
</ul>
        <a href="./zadania.php" class="btn btn-primary" style="margin-top:10px;">Rozwiń Zadania</a>
		<?php
		if($uprawnienia_pomoc ==1)
		{
			echo "<a href='./dodaj_zadanie.php' class='btn btn-primary'  style='margin-top:10px;'>Dodaj Zadanie</a>";
		 echo "<a href='./zakoncz_zadanie.php' class='btn btn-primary'   style='margin-top:10px; margin-left:10px;'>Zakończ Zadanie</a>";
		}
		?>
		 
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Wydarzenia</h5>
   <div class="list-group">
  <?php
  	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select *, datediff(Data_Zdarzenia,Now()) as Liczba from zdarzenia Where ID_Projektu = $id_projektu and Now() <= Data_Zdarzenia order by Data_Zdarzenia desc limit 3");
						$zapytanie -> execute();
						while($data_1 = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
									echo "<a href='./droga_wydarzenie.php?id_wydarzenia=". $data_1['ID_Zdarzenia'] ."' class='list-group-item list-group-item-action'>";
									echo "<div class='d-flex w-100 justify-content-between'>";
									echo "<h5 class='mb-1'>". $data_1['Nazwa_Zdarzenia'] . "</h5>";
									echo "<small>Wydarzenie za " . $data_1['Liczba'] . " dni</small></div>";
								echo "<p class='mb-1'>Przewidywany czas spotkania: ". $data_1['Przewidywany_Czas'] . " godzin</p></a>";
								}
								?>

			</div>
			<?php
			if($uprawnienia_pomoc == 1)
			echo "<a href='./stworz_wydarzenie.php' class='btn btn-primary' style='margin-top:10px;'>Dodaj Wydarzenie</a>";
			
			?>
			
			<a href="./wydarzenia.php" class="btn btn-primary" style="margin-top:10px;">Wyświetl Wszystkie Wydarzenia</a>
      </div>
    </div>
  </div>
</div><div class="row" style="margin-top:10px;">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Pracownicy</h5>
		<ul class="list-group">
		<?php
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
						$zapytanie = $polaczenie->prepare("select distinct *,Concat(u.Imie,' ',u.Nazwisko) as dane from projekty_uzytkownicy pu join uzytkownicy u on u.ID_Uzytkownika=pu.ID_Uzytkownika where ID_Projektu = $id_projektu");
						$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
								{
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $data['dane'] . " Email: " . $data['Email'] . "</li>";
								echo "<li class='list-group-item d-flex justify-content-between align-items-left'>";
								if($uprawnienia_pomoc == 1)
								echo "<form method=POST action='./przypisz_zadanie.php'><input type=text name='id_pracownika' value='" . $data['ID_Uzytkownika'] . "' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Przypisz Zadanie</button></form>";
								echo "<form method=POST action='./wyslij_maila.php'><input type=text name='id_pracownika' value='" . $data['ID_Uzytkownika'] . "' hidden><button type='submit' class='btn btn-primary' name='SubmitButton'>Wyslij Maila</button></form></li>";
								
								}
        ?>
		</ul>
		<?php
			if($uprawnienia_pomoc == 1)
        echo "<a href='./przypisz_pracownikow.php?tryb=3' class='btn btn-primary' style = 'margin-top:10px;'>Dodaj Użytkownika/ów do Projektu</a>";
		?>
	  </div>
    </div>
  </div>
  <?php
  if($uprawnienia_pomoc == 1)
  {
  echo "<div class='col-sm-6'>";
   echo "<div class='card'>";
    echo "<div class='card-body'>";
     echo "<h5 class='card-title'>Raporty</h5>";
       echo "  <ul class='list-group'>";
		 echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
		  echo " Raport zadań: <a href='./form_raport_zadanie.php' class='btn btn-primary' style = 'margin-top:10px;'>Utwórz Raport</a>";
		 echo "</li>";
		 echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
		 echo "Raport wydarzeń : <a href='./form_raport_wydarzenia.php' class='btn btn-primary' style = 'margin-top:10px;'>Utwórz Raport</a>";
		 echo "</li>";

     echo "  </div>";
    echo " </div>";
   echo "</div>";
  }
  ?>
</div>
<?php
if($uprawnienia_pomoc == 1)
{
 echo "<div class='row justify-content-center'>";
		 echo "<form name='form_1' method='POST' id='mail_form'>";	
			echo "<input type=text name='id_projektu' value='" . $id_projektu . "' hidden>";
				 echo "<button type='submit' style='margin-top:10px;' class='btn btn-primary' name='SubmitButton'>Zakończ Projekt</button>";
				 echo "</form>";		
				 echo "</div>";
}
	?>
	
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
