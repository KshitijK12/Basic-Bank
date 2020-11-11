<?php
	session_start();
	require_once('PDO.php');
	if(isset($_POST['cust_id']))
	{
		$_SESSION['cust_id']=htmlentities($_POST['cust_id']);
		header("Location: details.php");return;
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
	<title>Customers</title>
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
		<h1>Customer List</h1>
		<div class="container">
			<?php
				$stmt=$pdo->query("SELECT * from Customers");
				echo "<table class='table table-hover' width='100%' cell-spacing='0'>
						<tr>
							<th>Customer ID</th>
							<th>Name</th>
							<th>Phone No.</th>
							<th>Email ID</th>
							<th>View Accounts</th>
						</tr>";
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						{
							echo "<tr>
								<td>".$row['customer_id']."</td>";
								echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
								echo "<td>".$row['phone']."</td>";
								echo "<td>".$row['email']."</td>";
								echo "<td><form method='POST' class='view_button'><input type='hidden' name= 'cust_id' value=".$row['customer_id'];
								echo "><input type='submit' value='View'></form></td>
							</tr>";
						}
					echo "</table>";
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
