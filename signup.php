<?php
include "db.php";

$msg = "";

if (isset($_POST['signup'])) {

    $name  = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $msg = "User already exists. Please login.";
    } else {
        mysqli_query($conn,
            "INSERT INTO users (full_name,email,phone,password)
             VALUES ('$name','$email','$phone','$pass')"
        );
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stay Tuned | Login</title>


  <style>
    nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.85);
      padding: 15px 0;
      z-index: 1000;
    }

    nav ul {
      list-style: none;
      display: flex;
      justify-content: space-evenly;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      margin: 0 35px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
      padding: 8px 12px;
      transition: all 0.3s ease;
    }

    nav ul li a:hover {
      color: pink;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
    }

    body {
      padding-top: 27px;
    }

    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image: url('bg.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
    }

    .wrapper {
      width: 370px;
      max-width: 90%;
      background: rgba(255, 182, 193, 0.25);
      border-radius: 50px;
      backdrop-filter: blur(15px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
      padding: 50px;
      color: #fff;
      text-align: center;
      transition: all 0.3s ease;
      margin-top:180px;
    }

    .wrapper h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 25px;
      letter-spacing: 1px;
      color: #ff69b4;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-size: 18px;
      font-weight: bold;
      text-align: left;
      margin-bottom: 10px;
      display: block;
      color: #d63384;
    }

    input,
    select {
      width: 100%;
      padding: 10px 12px;
      border-radius: 12px;
      border: none;
      outline: none;
      background: rgba(255, 192, 203, 0.85);
      color: #333;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    input:focus,
    select:focus {
      background: #ffc0cb;
      box-shadow: 0 0 8px rgba(255, 182, 193, 0.7);
      transform: scale(1.02);
    }


    button {
      margin-top: 10px;
      background: #ff69b4;
      color: #fff;
      border: none;
      padding: 10px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      background: #ff1493;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
    }

    footer {
      margin-top: 20px;
      font-size: 14px;
      opacity: 1;
      color:black;
    }

  

      @media (max-height: 200px) {
      .wrapper {
        transform: scale(0.9);
      }
    }

    @media (max-width: 250px) {
      .wrapper {
        width: 90%;
        padding: 25px 20px;
      }
    }
    a{
      text-decoration:none;
      color:18526B;
      font-size:20px;
    }
   p{
    color:black;
    padding:0px;
   }
   a:hover{
    padding:5px;
    margin:5px;
    font-size:25px;
   }
  </style>
</head>

<body>

 

  <div class="wrapper">
    <h1>Sign Up</h1>

    <!-- ✅ FORM CONNECTED TO PHP -->
    <form action="signup.php" method="POST">

      <div>
        <label>Full Name</label>
        <input type="text" name="full_name" required>
      </div>

      <div>
        <label>Phone No</label>
        <input type="tel" name="phone" required>
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit" name="signup">signup</button>
      <p>Do you have an account?<a href="login.php">       Login</a></p>
    </form>
   
    <footer >© 2025 Stay Tuned</footer>
  </div>




</body>

</html>