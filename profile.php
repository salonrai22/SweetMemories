<?php
session_start();
include "db.php";

/* =========================
   LOGIN CHECK
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   FETCH USER DATA
========================= */
$stmt = $conn->prepare("SELECT full_name, email, profile_pic FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* =========================
   PROFILE IMAGE UPLOAD
========================= */
if (isset($_POST['upload'])) {

    $file = $_FILES['photo'];
    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $error = "Only JPG, JPEG, PNG allowed";
    } elseif ($file['size'] > 2 * 1024 * 1024) {
        $error = "Max file size 2MB";
    } elseif ($file['error'] !== 0) {
        $error = "Upload error";
    } else {

        if (!is_dir("uploads")) {
            mkdir("uploads", 0755, true);
        }

        $newName = uniqid("profile_", true) . "." . $ext;

        if (move_uploaded_file($file['tmp_name'], "uploads/" . $newName)) {
            $up = $conn->prepare("UPDATE users SET profile_pic=? WHERE id=?");
            $up->bind_param("si", $newName, $user_id);
            $up->execute();
            header("Location: profile.php");
            exit();
        } else {
            $error = "Upload failed";
        }
    }
}

/* =========================
   FETCH FAVOURITES
========================= */
$fav = $conn->prepare("
    SELECT posts.*
    FROM posts
    INNER JOIN favourites ON favourites.post_id = posts.id
    WHERE favourites.user_id = ?
    ORDER BY posts.id DESC
");
$fav->bind_param("i", $user_id);
$fav->execute();
$favourites = $fav->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffe0ec;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: #000;
            padding: 15px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: space-evenly;
            margin: 0px;
            padding: 0px;
        }

        

        a:hover {
            padding: 10px;
            margin: 0px;
            
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding: 8px 12px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            color: pink;
        }



        .profile-box {
            margin: 110px auto;
            width: 400px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        .profile-box img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        button {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            background: #007bff;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }

        .logout {
            background: red;
        }

        .error {
            color: red;
        }

        #preview {
            display: none;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px dashed #007bff;
            margin-top: 15px;
        }

        .fav-box {
            margin-top: 30px;
            text-align: left;
        }

        .fav-post {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a href="web.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="profile.php">MyProfile</a></li>
        </ul>
    </nav>

    <div class="profile-box">

        <h2>My Profile</h2>

        <img src="uploads/<?php echo $user['profile_pic'] ?: 'default.png'; ?>">

        <form method="POST" enctype="multipart/form-data">

            <input type="file" name="photo" id="photoInput" hidden accept="image/*">

            <button type="button" onclick="document.getElementById('photoInput').click()">
                ➕ Add Photo
            </button>

            <br>
            <img id="preview">

            <br>
            <button type="submit" name="upload">Upload</button>
        </form>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <h3>
            <?php echo htmlspecialchars($user['full_name']); ?>
        </h3>
        <p>
            <?php echo htmlspecialchars($user['email']); ?>
        </p>

        <form action="logout.php" method="post">
            <button class="logout">Logout</button>
        </form>

        <!-- =========================
     FAVOURITES SECTION
========================= -->
        <div class="fav-box">
            <h3>⭐ Favourite Posts</h3>

            <?php if ($favourites->num_rows > 0): ?>
            <?php while ($row = $favourites->fetch_assoc()): ?>
            <div class="fav-post">
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" style="width:100%;border-radius:8px;">
                <p>
                    <?php echo htmlspecialchars($row['caption']); ?>
                </p>
                <small>
                    <?php echo date("F d, Y h:i A", strtotime($row['created_at'])); ?>
                </small>
            </div>

            <?php endwhile; ?>
            <?php else: ?>
            <p>No favourites yet.</p>
            <?php endif; ?>
        </div>

    </div>

    <!-- =========================
     IMAGE PREVIEW SCRIPT
========================= -->
    <script>
        document.getElementById('photoInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('preview');
                img.src = e.target.result;
                img.style.display = "block";
            };
            reader.readAsDataURL(file);
        });
    </script>
<p style="text-align:center;">© 2025 Sweet Memory. All Rights Reserved.</p>
</body>

</html>