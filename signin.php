<?php 
		session_start();
		if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['login'])){
			/* Afficher le formulaire */
		}else{
			/* Ne pas afficher le formulaire */
			/* Renvoyer vers une page d'erreur? */ 
			header('Location: index.php');
		}
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Signin</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <!-- Mon css -->
        <link rel="stylesheet" href="form.css">
	</head>
	<?php include('header.php') ?>
	<body>
		<div class="container">
			<div class="message">
				<?php 
					if(isset($_SESSION['message']) && $_SESSION['message']!=null){
						echo '<blockquote class="red-text"> '.$_SESSION['message'].' </blockquote>';
					}
				?>
			</div>
			<h1>Signin</h1>
			<form action="authenticate.php" method="POST" id="auth_form">
			<div class="row">
				<div class="input-field col s3">
					<input placeholder="Login" id="input_login" type="text" class="validate" name="login">
					<label for="input_login">Login</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s3">
					<input placeholder="Password" id="input_password" type="text" class="validate" name="password">
					<label for="input_password">Password</label>
				</div>
			</div>
				<input type="submit" value="Connect me" class="btn">
			</form>
		</div>
	</body>
</html>
