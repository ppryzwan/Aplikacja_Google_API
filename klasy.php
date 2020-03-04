<?php 

class Kierownik
{
	private $ID_User;
	private $login;
	private $haslo;
	private $poziom = 2;

	public function __construct($id,$login,$haslo)
	{
		$this->ID_User = $id;
		$this->login = $login;
		$this->haslo = $haslo;
	}
	public function getid()
	{
		return $this->ID_User;
	}
	public function WypiszLogin()
	{
	echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
	public function Poziom()
	{
		return $this->poziom;
	}
	public function edytuj_dane($login,$haslo)
	{
		$pomoc = 0;
		$id = $this->ID_Usera;
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
			$zapytanie = $polaczenie->prepare("select * from uzytkownicy where ID_Uzytkownika = $id and Haslo = '$haslo'");
				$zapytanie -> execute();
				
				$count = $zapytanie->rowCount();
				if($count >0)
					$pomoc = 1;
				
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("update uzytkownicy set Login = :login, Haslo=:haslo  where ID_Uzytkownika = :id");
				 $zapytanie ->bindParam(':id',$id);

				   $zapytanie ->bindParam(':login',$login);
				   if($pomoc == 0)
					   $haselko = md5($haslo);
				   else
					   $haselko = $haslo;
				   
				    $zapytanie ->bindParam(':haslo',$haselko);
		
				$zapytanie -> execute();
				 echo "<div class='alert alert-success'>Pomyślnie zmieniono</div> ";	
		
				 
	}
	
}

class Pracownik
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 1;

		
		public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
	
	}
	public function getid()
	{
		return $this->ID_Usera;
	}
		public function Poziom()
	{
		return $this->poziom;
	}
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	
}	public function edytuj_dane($login,$haslo)
	{
		$pomoc = 0;
		$id = $this->ID_Usera;
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
			$zapytanie = $polaczenie->prepare("select * from uzytkownicy where ID_Uzytkownika = $id and Haslo = '$haslo'");
				$zapytanie -> execute();
				
				$count = $zapytanie->rowCount();
				if($count >0)
					$pomoc = 1;
				
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("update uzytkownicy set Login = :login, Haslo=:haslo  where ID_Uzytkownika = :id");
				 $zapytanie ->bindParam(':id',$id);

				   $zapytanie ->bindParam(':login',$login);
				   if($pomoc == 0)
					   $haselko = md5($haslo);
				   else
					   $haselko = $haslo;
				   
				    $zapytanie ->bindParam(':haslo',$haselko);
		
				$zapytanie -> execute();
				 echo "<div class='alert alert-success'>Pomyślnie zmieniono</div> ";	
		
				 
	}
	
	}


class Admin	
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 3;

		
		public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
	}
public function getid()
	{
		return $this->ID_Usera;
	}
	
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
		public function Poziom()
	{
		return $this->poziom;
	}
	public function dodaj_uzytkownika($imie,$nazwisko,$poziom,$login,$haslo,$email)
	{
		$pomoc = 0;
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
			$zapytanie = $polaczenie->prepare("select * from uzytkownicy where Login = $login");
				$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
						{
							$pomoc = 1;
						}
		if($pomoc == 1)
			 echo '<div class="alert alert-warning">Istnieje w bazie użytkownik o takim loginie</div> ';
			else
			{
				$haselko = md5($haslo);
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("insert into uzytkownicy (Imie,Nazwisko,Poziom_Uprawnien,Login,Haslo,Email) values(:imie,:nazwi,:poziom,:login,:haslo,:email)");
				 $zapytanie ->bindParam(':imie',$imie);
				 $zapytanie ->bindParam(':nazwi',$nazwisko);
				  $zapytanie ->bindParam(':poziom',$poziom);
				   $zapytanie ->bindParam(':login',$login);
				    $zapytanie ->bindParam(':haslo',$haselko);
					 $zapytanie ->bindParam(':email',$email);
					
				$zapytanie -> execute();
				 echo '<div class="alert alert-success"> Pomyślnie dodano</div> ';	}
	}
	public function edytuj_uzytkownika($id,$imie,$nazwisko,$poziom,$login,$haslo,$email)
	{
		$pomoc = 0;
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
			$zapytanie = $polaczenie->prepare("select * from uzytkownicy where ID_Uzytkownika = $id and Haslo = '$haslo'");
				$zapytanie -> execute();
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
						{
							$pomoc = 1;
						}
	
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("update uzytkownicy set Imie=:imie, Nazwisko=:nazwi, Poziom_Uprawnien = :poziom, Login = :login, Haslo=:haslo,Email=:email where ID_Uzytkownika = :id");
				 $zapytanie ->bindParam(':id',$id);
				$zapytanie ->bindParam(':imie',$imie);
				 $zapytanie ->bindParam(':nazwi',$nazwisko);
				  $zapytanie ->bindParam(':poziom',$poziom);
				   $zapytanie ->bindParam(':login',$login);
				   if($pomoc == 0)
					   $haselko = md5($haslo);
				   else
					   $haselko = $haslo;
				   
				    $zapytanie ->bindParam(':haslo',$haselko);
					 $zapytanie ->bindParam(':email',$email);
					
				$zapytanie -> execute();
				 echo '<div class="alert alert-success"> Pomyślnie zmieniono</div> ';	
		
				 
	}
		public function edytuj_dane($login,$haslo)
	{
		$pomoc = 0;
		$id = $this->ID_Usera;
			$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
			$zapytanie = $polaczenie->prepare("select * from uzytkownicy where ID_Uzytkownika = $id and Haslo = '$haslo'");
				$zapytanie -> execute();
				
				$count = $zapytanie->rowCount();
				if($count >0)
					$pomoc = 1;
				
				$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
				$zapytanie = $polaczenie->prepare("update uzytkownicy set Login = :login, Haslo=:haslo  where ID_Uzytkownika = :id");
				 $zapytanie ->bindParam(':id',$id);

				   $zapytanie ->bindParam(':login',$login);
				   if($pomoc == 0)
					   $haselko = md5($haslo);
				   else
					   $haselko = $haslo;
				   
				    $zapytanie ->bindParam(':haslo',$haselko);
		
				$zapytanie -> execute();
				 echo "<div class='alert alert-success'>Pomyślnie zmieniono</div> ";	
		
				 
	}
	
	}			
?>
