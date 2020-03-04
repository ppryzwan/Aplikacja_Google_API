

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
		<div class="containter-fluid bg">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12"></div>
				<div class="col-md-4 col-sm-4 col-xs-12">
				<form class="form-containter" action="logowanie.php" method="POST" >
				<h1>Formularz Logowania</h1>
					<div class="form-group">
					<label for="login">Login</label>
					<input type="text" class="form-control" name="login" id="login" placeholder="Wprowadz Login">
			
					</div>
					<div class="form-group">
					<label for="password">Hasło</label>
					<input type="password" class="form-control"  name="haslo" id="password" placeholder="Hasło">
						</div>
				
			<button type="submit" class="btn btn-success btn-block">Zaloguj</button>
				</form>
				
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12"></div>
		</div>
		</div>	
	</body>


</html>

