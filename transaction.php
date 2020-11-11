<?php
session_start();
require_once('PDO.php');
$_SESSION['failure']=false;
$_SESSION['success']=false;
$_SESSION['failurered']=false;
if(isset($_SESSION['acc_id']))
{
	$a=htmlentities($_SESSION['acc_id']);
	if(isset($_POST['acc2_id']))
	{
		$_SESSION['acc2_id']=$_POST['acc2_id'];
		unset($_POST['acc2_id']);
	}
	if(isset($_SESSION['acc2_id']))
	{
		$b=$_SESSION['acc2_id'];
		$balsql=$pdo->query("SELECT balance FROM Account WHERE account_id=$a");
		$bal=$balsql->fetch(PDO::FETCH_ASSOC);
		if(isset($_POST['amt']))
		{
			$_SESSION['amt']=htmlentities($_POST['amt']);
			unset($_POST['amt']);
		}
		if(isset($_SESSION['amt']))
		{
			if(!is_numeric($_SESSION['amt']))
				$_SESSION['failure']= "Amount should be a number...";
			elseif($_SESSION['amt']<100)
				$_SESSION['failure']="Minimum transaction Account= Rs.100...";
			elseif ($_SESSION['amt']> $bal['balance']) 
				$_SESSION['failure']= "Cannot Proceed, Amount exceeds Account Balance...";
			else
			{
				$amt=$_SESSION['amt'];
				try
				{		
					$acc_upd1="UPDATE Account SET balance=balance-$amt WHERE account_id=$a";
					$acc_upd2="UPDATE Account SET balance=balance+$amt WHERE account_id=$b";
					$pdo->exec($acc_upd1);
					$pdo->exec($acc_upd2);
				}
				catch( Exception $e)
				{
					die("ERROR: Couldnt complete Transaction. Try Again Later...");
				}
				$_SESSION['success']="Transaction Completed !";
				$tr_id=uniqid(mt_rand(), true);
				$_SESSION['tr_id']=$tr_id;
				$dt=date('Y-m-d H:i:s');
				$sql="INSERT INTO Transfer VALUES($a,$b,'$dt',$amt,'$tr_id')";
				$pdo->exec($sql);
			}
		}
	}
}
else
	$_SESSION['failurered']="Please select an acocunt to tranfer from... go back 1 page";
if(isset($_SESSION['success']) && $_SESSION['success']!==false)
{
	unset($_SESSION['acc2_id']);
	unset($_SESSION['amt']);
	unset($_SESSION['acc_id']);
	header("Location: receipt.php");
	return;
}
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
	<title>Processing..</title>
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
		<div class="container">
			<h1>Select the Receiver's Account </h1>
			<?php
			if(isset($_SESSION['failurered']) && $_SESSION['failurered']!==false)
			{
				echo "<p style='color:red;font-size:30px;text-align:center;'>".$_SESSION['failurered']."</p>";unset($_SESSION['failurered']);
				echo "<div class='return'><a href='index.php'>Click here to return</a></div>";
			}
			else
			{
				if(isset($_SESSION['acc2_id']) && $_SESSION['acc2_id']>1 )
					echo "<p style='color:green; font-size:20px;'>Scroll Down to Enter Amount..</p><br>";
				if(isset($_SESSION['failure']) && $_SESSION['failure']!==false)
				{	
					echo "<p style='color:red'>".$_SESSION['failure']."</p>";$_SESSION['failure']=false;unset($_SESSION['amt']);
				}
				$stmt=$pdo->query("SELECT c.customer_id,c.first_name,c.last_name, a.account_id, c.phone from Customers c, Account a 
				Where c.customer_id=a.customer_id AND a.account_id NOT IN ($a)");
				echo "<div><ul class='lst'>";
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$id=$row['account_id'];
					echo "<li><pre>Name- ".$row['first_name']." ".$row['last_name']."<br>Account ID- ".$row['account_id']."</pre>";
					echo "Customer ID- ".$row['customer_id']."<br>Contact No.- ".$row['phone'];
					echo "<form method='POST'><p class='view_button'><input type='hidden' name= 'acc2_id' value='$id'>
						<input type='submit' value='Send'></p></form><br></li>";
				}
				echo "</ul></div>";
				if(isset($_SESSION['acc2_id']))
				{
				echo "<br><br><div class=amt>Sender's Account ID: ".$a."<br>Receiver's Account ID: ".$b."<br><br><form method='POST'>
					<label for='amt'>ENTER AMOUNT TO TRANSFER</label>
					<br><input type='text' name='amt'>
					<input type='submit' value='PAY'>
				  </form></div> ";
				}
			}
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
