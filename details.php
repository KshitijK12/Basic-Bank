<?php
	session_start();
	require_once("PDO.php");
	if(isset($_SESSION['cust_id']))
	{
		$a=$_SESSION['cust_id'];
		if(isset($_POST['acc_id']))
		{
			// unset($_SESSION['cust_id']);
			$_SESSION['acc_id']=$_POST['acc_id'];
			header("Location: transaction.php");return;
		}
	}
?>
<!DOCTYPE html>
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
	<title>Customer Details</title>
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
	<section class="mid">	
		<h1>Select your Account</h1>
		<div class="container">
			<?php
				if(!isset($_SESSION['cust_id']))
				{
					echo "<p style='color:red; font-size:30px;'>Customer ID missing ,please select a customer ID</p>";
					echo "<div class='return'><a href='index.php'>Click here to return</a></div>";
				}
				else
				{
					$stmt=$pdo->prepare("Select * from Account where customer_id=:cust_id");
					$stmt->execute([':cust_id'=>$a]);
					echo "<div>
					<ul class='lst'>";
					while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<li><pre>Account ID- ".$row['account_id']."</pre>Account Type- ".$row['type'].
						"<br>Account Balance- Rs.".$row['balance']."<br>Opening Date- ".$row['opening_date']."<br> ";
			?>
						<form method='POST'>
						<p class='view_button'><input type='hidden' name='acc_id' value="<?php echo $row['account_id']; ?>">
						<input type='submit' value='Transfer Money'></p>
						</form><br><br></li>		
				<?php	}	?>
					</ul>
				</div>
			<?php	}	?>
		</div>
	</section>
	<footer id='contact'>
  		<p>Made By- Kshitij Kakkar</p>
  		<a href="https://www.facebook.com/kshitij.kakkar.1" class="fa fa-facebook"></a>
		<a href="https://www.linkedin.com/in/kshitij-kakkar-16846316b/" class="fa fa-linkedin"></a>
		<a href="https://www.instagram.com/kshitij.12/" class="fa fa-instagram"></a>
	</footer>
</body>
</html>
