<?php
session_start();
include "db.php";

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    // Bind result variables
    $stmt->bind_result($id, $hashed_password);
    
    if ($stmt->fetch()) {
        // User found, check password
        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: web.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        // No user found
        $error = "Invalid user! Account not found.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stay Tuned | Login</title>
  <link rel="stylesheet" href="style.css">

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
      overflow: hidden;
    }

    .wrapper {
      width: 360px;
      max-width: 90%;
      background: rgba(255, 182, 193, 0.25);
      border-radius: 25px;
      backdrop-filter: blur(15px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
      padding: 45px;
      color: #fff;
      text-align: center;
      transition: all 0.3s ease;
      animation: fadeIn 0.6s ease-in-out;
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
      font-weight: 500px;
      text-align: left;
      margin-bottom: 10px;
      display: block;
      color: #d63384;
    }

    input,
    select {
      width: 100%;
      padding: 8px 12px;
      border-radius: 12px;
      border: none;
      outline: none;
      background: rgba(255, 192, 203, 0.85);
      color: #333;
      font-size: 14px;
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
      color: black;
    }

    @media (max-height: 700px) {
      .wrapper {
        transform: scale(0.9);
      }
    }

    @media (max-width: 450px) {
      .wrapper {
        width: 90%;
        padding: 25px 20px;
      }

    }

    a {
      text-decoration: none;
      color: 18526B;
      font-size: 25px;
    }

    a:hover {
      font-size: 25px;
      margin: 20px;
    }
    .error {
            color: #ff0000; /* bright red */
            font-weight: bold;
            background: #ffe6e6; /* light red background */
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ff0000;
            border-radius: 6px;
        }
  </style>
</head>


<body>



  <div class="wrapper">
    <h1>Login</h1>

    <!-- ✅ FORM CONNECTED TO PHP -->
    <form action="login.php" method="POST">
     <?php
    if ($error != "") {
    echo "<div class='error'>$error</div>";
  }
?>
      <div>
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit" name="login">Login</button>
      
      
      
      <p id="back"><a href="signup.php">Back→</a> </p>
    </form>


    <footer>© 2025 Stay Tuned</footer>
  </div>




</body>

</html>