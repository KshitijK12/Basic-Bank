<?php
	session_start();
	require_once('PDO.php');
?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="main.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Successful</title>
</head>
<body>
	<section id='top'>
		<img src="cover.png" id='logo-cover'>	
		<div class="header">
  			<div class="header-right">
    				<a href="index.php#home">Home</a>
    				<a href="#contact">Contact</a>
    				<a href="index.php#about">About</a>
  			</div>
		</div>
	</section>
	<section class='mid'>
		<div class="container">	 
			<?php
				if(isset($_SESSION['success']) && $_SESSION['success']!==false)
				{
					echo "<h1>Transaction Receipt</h1>";
					echo "<p style='Color:green;font-size:28px;text-align:center'> Transaction Completed Successfully</p>";
					$_SESSION['success']=false;
					$sql=$pdo->prepare("SELECT * FROM Transfer WHERE Transaction_ID=:tr");
					$sql->execute([':tr'=>$_SESSION['tr_id']]);
					echo "<div class=view_list>";
						while($row=$sql->fetch(PDO::FETCH_ASSOC))
						{
							echo "<pre>Transaction ID- ".$row['Transaction_ID'];
							echo "<br><br>Amount- Rs.".$row['Amount'];
							echo "<br><br>Sender's Account No.- ".$row['acc_from'];
							echo "<br><br>Receiver's Account No.- ".$row['acc_to'];
							echo "<br><br>Transaction Time- ".$row['Transaction_Date']."</pre>";
						}
					echo "</div>";
				}
				else
				{
					echo "<p style='font-size:28px; color:red;text-align:center'>No transaction to display...</p>";
				}
				echo "<div class=return><a href='index.php'>Click here to go to main page</a></div>";
			session_destroy();
			?>
		</div>
	</section>
	<footer id='contact'>
  		<p>Made By-Kshitij Kakkar</p>
  		<a href="https://www.facebook.com/kshitij.kakkar.1" class="fa fa-facebook"></a>
		<a href="https://www.linkedin.com/in/kshitij-kakkar-16846316b/" class="fa fa-linkedin"></a>
		<a href="https://www.instagram.com/kshitij.12/" class="fa fa-instagram"></a>
	</footer>
</body>
</html>
