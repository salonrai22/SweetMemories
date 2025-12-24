<?php 
include "auth.php"; 
include "navbar.php"; 

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form Page</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: serif;
      background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fbc2eb);
      background-size: cover;
      min-height: 100vh;
    }

    a {
      font: size 25px;
    }

    a:hover {
      padding: 10px;
      margin: 10px;
      font-size: 25px;
    }

    nav.navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.85);
      padding: 15px 0;
      z-index: 1000;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    nav.navbar ul {
      list-style: none;
      display: flex;
      justify-content: space-evenly;
      margin: 0;
      padding: 0;
    }



    nav.navbar ul li {
      margin: 0 20px;
    }

    nav.navbar ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
      padding: 8px 12px;
      transition: 0.3s;
    }

    nav.navbar ul li a:hover {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 5px;
      color: pink;
    }


    .content {
      padding-top: 70px;
      display: flex;
      justify-content: center;
    }


    .form-box {
      background: white;
      max-width: 450px;
      width: 100%;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 10px;

      font-size: 28px;
      color: hotpink;
    }

    .form-box p {
      text-align: center;
      color: blue;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }

    .form-input,
    .form-textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: 0.3s;
    }

    .form-input:focus,
    .form-textarea:focus {
      border-color: #6a5af9;
      outline: none;
      box-shadow: 0 0 5px rgba(106, 90, 249, 0.5);
    }

    .form-textarea {
      min-height: 120px;
      resize: none;
    }

    .form-submit {
      width: 100%;
      background: #6a5af9;
      color: white;
      padding: 12px;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .form-submit:hover {
      background: pink;
    }
  </style>
</head>

<body>

  <nav class="navbar">
    <ul>
      <li><a href="web.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="profile.php">MyProfile</a></li>
    </ul>
  </nav>

  <div class="content">
    <div class="form-box">
      <h2>Get in Touch</h2>
      <p>Fill the form and we'll contact you soon.</p>

      <form action="contact.php" method="POST">
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-input" placeholder="Your Name" required />
        </div>

        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" placeholder="Your Email" required />
        </div>

        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="tel" name="phone" class="form-input" placeholder="+977 00 000 000" />
        </div>

        <div class="form-group">
          <label class="form-label">Message</label>
          <textarea name="message" class="form-textarea" placeholder="Write your message..." required></textarea>
        </div>

        <button class="form-submit" type="submit" name="send">Send Message</button>
      </form>
    </div>
  </div>

  <?php
include "db.php";
if(isset($_POST['send'])){
$name    = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$message = $_POST['message'];

$query = "INSERT INTO contact(name, email, phone, message)
          VALUES ('$name', '$email', '$phone', '$message')";

if(mysqli_query($conn, $query)){
        $messageSent = true; // Set flag to show notification
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<p style="text-align:center;">© 2025 Sweet Memory. All Rights Reserved.</p>

</body>

</html>