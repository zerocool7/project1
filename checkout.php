<?php
require("mysqli_connect.php");
session_start();
if (isset($_SESSION['buyBook']))
  {
    $bookid= $_SESSION['buyBook'] ;
  }
 ?>

<html>
<head>
<style>
body {
   font-family: Arial;
   font-size: 17px;
   padding: 8px;
}
* {
   box-sizing: border-box;
}
.Fields {
   display: flex;
   flex-wrap: wrap;
   padding: 20px;
   justify-content: space-around;
}
.Fields div {
   margin-right: 10px;
}
label {
   margin: 15px;
}
.formContainer {
   margin: 10px;
   background-color: #D3D3D3;
   padding: 5px 20px 15px 20px;
   border: 1px solid rgb(191, 246, 250);
   border-radius: 3px;
}
input[type="text"] {
   display: inline-block;
   width: 100%;
   margin-bottom: 20px;
   padding: 12px;
   border: 1px solid #ccc;
   border-radius: 3px;
}
label {
   margin-left: 20px;
   display: block;
}
.icon-formContainer {
   margin-bottom: 20px;
   padding: 7px 0;
   font-size: 24px;
}
.checkout {
   background-color: #4caf50;
   color: white;
   padding: 12px;
   margin: 10px 0;
   border: none;
   width: 100%;
   border-radius: 3px;
   cursor: pointer;
   font-size: 17px;
}
.checkout:hover {
   background-color: #45a049;
}
a {
   color: black;
}
span.price {
   float: right;
   color: grey;
}
@media (max-width: 800px) {
.Fields {
   flex-direction: column-reverse;
}
}
</style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Store</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a href="index.html" class="navbar-brand">Home</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="store.php" class="nav-link">Book Store</a>
                </li>
            </ul>
        </div>
    </nav>
<body>
<h1 style="text-align: center;"> Checkout Here</h1>
<div class="Fields">
<div>
<div class="formContainer">
<form action ="checkout.php" method ="post">
<div class="Fields"><?php
$q1="SELECT * FROM books where pid=$bookid";
    $r1=mysqli_query($connection,$q1);
   if (mysqli_num_rows($r1) > 0) {
   while($row = mysqli_fetch_assoc($r1))
   {
   echo '<p>'. $row["Name"].' <span class="price">Rs '. $row["Price"].'</span> </p>';  
 } 

 }
  else {
   echo mysqli_error($connection);
} 
?>
<div>
<h3>Billing Address</h3>
<label for="fname">Full Name</label>
<input type="text" id="fname" name="fullname" required />
<label for="email"> Email</label>
<input type="text" id="email" name="email"  required/>
<label for="adr"> Address</label>
<input type="text" id="adr" name="address" required />
</div>
<div>
<h3>Payment</h3>
<label for="cname">Name on Card</label>
<input type="text" id="cname" name="cardname" required/>
<label for="ccnum">Credit card number</label>
<input type="text" id="ccnum" name="cardnumber" required />
<div class="Fields">
<div>
<label for="expyear">Exp Year</label>
<input type="text" id="expyear" name="expyear" required/>
</div>
<div>
<label for="cvv">CVV</label>
<input type="text" id="cvv" name="cvv" required />
</div>
</div>
</div>
</div>
<input type="submit" value="Continue to checkout"class="checkout"/>
</form>
<footer class="disp-in" role="contentinfo">
            <p>Copyright &copy; 2021 Book Store</p>
            <p>Privacy Policy</p>
            <p>Terms and Conditions</p>
            <p><a href="plans.html">Subscribe</a></p>
        </footer>
</body>
</html>

<?php
if( $_SERVER['REQUEST_METHOD']=='POST'){
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $cardname = $_POST['cardname'];
  $cardnumber = $_POST['cardnumber'];
  $expyear = $_POST['expyear'];
  $cvv = $_POST['cvv'];
  



        $query = "INSERT INTO orders(Full_Name,Email,Address,Name_on_Card, credit_card_number,EXP, CVV) VALUES ('$fullname','$email','$address','$cardname','$cardnumber','$expyear','$cvv')";
        $result = mysqli_query($connection,$query);
        if($result){
        echo "<script type='text/javascript'>alert('order success');</script>";
        $q3="UPDATE books 
        SET Quantity = Quantity - 1
        WHERE PId = $bookid
        and Quantity > 0";
        $r2 = mysqli_query($connection,$q3);
        }
        echo mysqli_error($connection);

        
}
?>

