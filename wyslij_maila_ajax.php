<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$smtpUsername = "licencjackapraca7@gmail.com";
$smtpPassword = "matrixx123";
$emailFrom = "licencjackapraca7@gmail.com";
$id_pracownika = $_POST['id_pracownika'];

	$polaczenie = new PDO('mysql:host=localhost;charset=utf8;dbname=praca','root','');
	$zapytanie = $polaczenie->prepare("select *,Concat(Imie,' ',Nazwisko) as Dane from uzytkownicy where ID_Uzytkownika = $id_pracownika");
	$zapytanie -> execute();
	while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
	{
		$email = $data['Email'];
		$dane = $data['Dane'];
	}
$tresc = $_POST['Tresc'];
$mail = new PHPMailer;  //Tworzenie obiektu klasy
$mail->isSMTP(); 
$mail->SMTPDebug = 0; //Ustawienie wiadomości zwrotnych, 0 wyłącza je
$mail->Host = "smtp.gmail.com"; // ustanowienie hosta
$mail->Port = 587; //ustanowienie portu
$mail->SMTPAutoTLS = false;  
$mail->SMTPSecure = 'tls'; 
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername; //ustanowienie emailu od którego mail ma wychodzić
$mail->Password = $smtpPassword; //podanie hasła do tego maila
$mail->setFrom($emailFrom, $emailFrom); //ustawienie odbiorcy
$mail->addAddress($email, $dane); 	
$mail->Subject = $_POST['Temat']; 	//ustawienie tematu maila
$mail->Body = $tresc; //ustawienie tresci maila
$mail->AltBody = 'HTML messaging not supported'; //ustanowienie alternatywnej treści
$mail->send(); //uruchomienie funkcji wysłania maila
 echo "<div class='alert alert-success'> Pomyślnie wysłano</div> ";
 

?>
