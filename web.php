<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

/* ADD POST */
if (isset($_POST['add'])) {
    $caption = trim($_POST['caption']);
    $file = $_FILES['photo'];

    if ($file['error'] === 0) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        $allowedMime = ['image/jpeg', 'image/png'];

        if (in_array($ext, $allowed) && in_array($mime, $allowedMime) && $file['size'] <= 2*1024*1024) {
            $name = uniqid("post_", true) . "." . $ext;

            if (move_uploaded_file($file['tmp_name'], $uploadDir . $name)) {
                $stmt = $conn->prepare("INSERT INTO posts (user_id, image, caption) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $user_id, $name, $caption);
                $stmt->execute();
            }
        }
    }
    header("Location: web.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("SELECT image FROM posts WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $img = $stmt->get_result()->fetch_assoc();

    if ($img) {
        @unlink($uploadDir . $img['image']);
        $del = $conn->prepare("DELETE FROM posts WHERE id=?");
        $del->bind_param("i", $id);
        $del->execute();
    }
    header("Location: web.php");
    exit();
}

/* EDIT */
if (isset($_POST['edit'])) {
    $stmt = $conn->prepare("UPDATE posts SET caption=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sii", $_POST['caption'], $_POST['post_id'], $user_id);
    $stmt->execute();
    header("Location: web.php");
    exit();
}

/* FAVOURITE */
if (isset($_GET['fav'])) {
    $post_id = (int)$_GET['fav'];

    $check = $conn->prepare("SELECT id FROM favourites WHERE user_id=? AND post_id=?");
    $check->bind_param("ii", $user_id, $post_id);
    $check->execute();

    if ($check->get_result()->num_rows) {
        $del = $conn->prepare("DELETE FROM favourites WHERE user_id=? AND post_id=?");
        $del->bind_param("ii", $user_id, $post_id);
        $del->execute();
    } else {
        $ins = $conn->prepare("INSERT INTO favourites (user_id, post_id) VALUES (?, ?)");
        $ins->bind_param("ii", $user_id, $post_id);
        $ins->execute();
    }

    header("Location: web.php");
    exit();
}

/* FETCH POSTS */
$posts = $conn->prepare("
    SELECT posts.*,
    (SELECT id FROM favourites WHERE favourites.post_id = posts.id AND favourites.user_id = ?) AS liked
    FROM posts
    WHERE posts.user_id = ?
    ORDER BY posts.created_at DESC
");
$posts->bind_param("ii", $user_id, $user_id);
$posts->execute();
$result = $posts->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Feed</title>

<style>
body {
    margin: 0;
    background: #ffa8c9;
    font-family: Arial, sans-serif;
}
.nav {
    background: white;
    padding: 15px;
    text-align: center;
    font-weight: bold;
    margin-top:50px;
}
.container {
    max-width: 600px;
    margin: 25px auto;
}
.card, .upload-box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}
.card img {
    width: 95%;
    margin-left:17px;
}
.card-header {
    padding: 15px;
    font-weight: bold;
}
.card-body {
    padding: 15px;
}
textarea {
    width: 100%;
    height: 160px;
    resize: none;
    border-radius: 10px;

}
button, .fav-btn, .delete-btn {
    padding: 14px;
    border-radius: 20px;
    border: none;
    color: white;
    cursor: pointer;
    text-decoration: none;
    margin-top:10px;
}
button { background: #1877f2; }
.fav-btn { background: #ff4081; }
.delete-btn { background: #ff4d4d; }

.upload-box {
    padding: 15px;
}



a{
        font: size 25px;
    }
    a:hover{
    padding:10px;
    margin:10px;
    font-size:25px;
   }

    nav.mathiko {
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

    nav.mathiko ul {
      list-style: none;
      display: flex;
      justify-content: space-evenly;
      margin: 0;
      padding: 0;
    }



    nav.mathiko ul li {
      margin: 0 20px;
    }

    nav.mathiko ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
      padding: 8px 12px;
      transition: 0.3s;
    }

    nav.mathiko ul li a:hover {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 5px;
      color: pink;
    }

a .fav-btn:hover{
 padding:20px;
}
button{
        width: 80%;
    justify-content: center;
    text-align: center;
    justify-items: center;
    align-content: center;
    align-items: center;
    margin-left: 50px;
    height: 60px;
}
</style>
</head>

<body>
<nav class="mathiko">
    <ul>
      <li><a href="web.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="profile.php">MyProfile</a></li>
    </ul>
  </nav>



<div class="nav">📸 My Social Feed</div><br><br>

<h1 style="font-weight:bold; justify-content:center; color:#004b84; text-align:center; font-family:system_ui; margin-top:0px; margin-buttom:20px; padding:20px;"  >ADD YOUR MEMORY</h1>

<div class="container">

<!-- ADD POST -->
<div class="upload-box">
<form method="POST" enctype="multipart/form-data">

    <input type="file" name="photo" id="photoInput" hidden required>

    <button type="button" onclick="document.getElementById('photoInput').click()">
        ➕ Add Photo
    </button>

    <!-- ✅ IMAGE PREVIEW -->
    <img id="photoPreview" style="
        display:none;
        width:100%;
        max-height:400px;
        object-fit:cover;
        border-radius:10px;
        margin-top:15px;
    ">

    <br><br>

    <textarea name="caption" placeholder="What's on your mind?"></textarea><br><br>

    <button name="add">Post</button>
</form>
</div>

<!-- POSTS -->
<?php while ($row = $result->fetch_assoc()) { ?>
<div class="card">

    <div class="card-header">You</div>

    <img src="uploads/<?php echo $row['image']; ?>">

    <div class="card-body">
        <p><?php echo htmlspecialchars($row['caption']); ?></p>
        <small><?php echo date("F d, Y h:i A", strtotime($row['created_at'])); ?></small>

        <div class="actions" style="padding:20px; ">
            <a href="web.php?fav=<?php echo $row['id']; ?>" class="fav-btn" style="margin-right:250px">
                <?php echo $row['liked'] ? '❤️ Favourited' : '🤍 Favourite'; ?>
            </a>

            <a href="web.php?delete=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete post?')"
               class="delete-btn">Delete</a>
        </div>

        <form method="POST" class="actions">
            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
            <textarea name="caption"><?php echo htmlspecialchars($row['caption']); ?></textarea>
            <button name="edit">Edit</button>
        </form>
    </div>
</div>
<?php } ?>

</div>

<!-- ✅ PREVIEW SCRIPT -->
<script>
document.getElementById('photoInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const img = document.getElementById('photoPreview');
        img.src = e.target.result;
        img.style.display = "block";
    };
    reader.readAsDataURL(file);
});
</script>
<p style="text-align:center;">© 2025 Sweet Memory. All Rights Reserved.</p>

</body>
</html>
