<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About US</title>
    <style>
        h1 {
            margin: 0;
            padding: 0;
            color: purple;
            font-family: 'Great Vibes', cursive;
        }

        h2 {
            margin: 0;
            padding: 0;
            color: Tomato;
            font-family: serif;
        }

        body {
            background-color: #ffa8c9;
            font-weight: bold;
            font-family: serif;
            background-size: cover;
            width: 100%;
            height: 100%;
            color: black;
            text-align: center;
            padding: 20px;
        }

        .container {
            margin-top: 80px;
            padding: 20px;
        }

        .content {
            font-size: 18px;
        }

        .tagline {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bom {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: brown;
        }

        .mob {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 100px;
            }
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
        }

        nav.navbar ul {
            list-style: none;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
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
            transition: all 0.3s ease;
        }

        nav.navbar ul li a:hover {
            color: #ffcccb;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }


        body {
            padding-top: 80px;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }



        h1 {
            color: white;
            font-weight: bold;
            font-family: serif;
            margin-top: 0px;
            justify-content: center;
            align-items: center;
            font-size: 50px;

        }

        image {
            width: 200px;
            height: 300px;
            border: 1px solid black;
            margin-bottom: 25px;
        }

        .image img {
            width: 100%;
            height: auto;
            object-fit: fill;
        }

        .info p {
            color: white;
            font-size: 18px;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .full-img {
            width: 100%;
            height: auto;
            display: block;
            /* removes small gap */
        }
        .moreabout{
            background-color: #333;
            color: white;
         margin: auto;



        }
        #us{
            font-size: 30px;
            text-decoration: underline;
            justify-content: center;
        }
        a:hover{
        padding:5px;
        margin:5px;
        font-size:25px;
      }
      a{
        font-size:25px;
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
    <div class="image">
        <img src="Jeshika Dongol (3).png" class="full-ing">
    </div>
    <div class="container">
        <img src="Jeshika Dongol (4).png" class="full-img">
        
    </div>
    <div class="team">
        <img src="Jeshika Dongol (5).png " class="full-img">
    </div><br><br><br>
    <div class="why">
        <img src="Jeshika Dongol (6).png" class="full-img">
    </div>
    <div class="moreabout">
        <h1 id="us">contact us</h1>
        <p>📞Phone NO. : +977 9762934070</p>
        <p>📧Email: ssaumayarai@gmail.com</p>
        <p>📍Address: Lainchour, Kathmandu</p>
    </div>
    <p style="text-align:center;">© 2025 Sweet Memory. All Rights Reserved.</p>

</body>

</html>