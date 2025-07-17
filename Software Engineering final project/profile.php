<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

// Get user info
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'") or die('User query failed');
$user = mysqli_fetch_assoc($user_query);

if (isset($_POST['update_profile'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);

   // Handle profile image
   $profile_image = $_FILES['profile_image']['name'];
   $profile_tmp = $_FILES['profile_image']['tmp_name'];
   $target_dir = "uploaded_images/";
   $target_file = $target_dir . basename($profile_image);
   $file_ext = strtolower(pathinfo($profile_image, PATHINFO_EXTENSION));
   $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

   if (!empty($profile_image)) {
      if (in_array($file_ext, $allowed_ext) && $_FILES['profile_image']['size'] < 2 * 1024 * 1024) {
         move_uploaded_file($profile_tmp, $target_file);
         mysqli_query($conn, "UPDATE users SET image = '$profile_image' WHERE id = '$user_id'") or die('Image update failed');
      } else {
         echo "<script>alert('Only JPG, PNG, or GIF under 2MB allowed.');</script>";
      }
   }

   mysqli_query($conn, "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE id='$user_id'") or die('Update failed');
   echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>User Profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         margin: 0;
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
      }

      .container {
         display: flex;
         min-height: 100vh;
      }

      .sidebar {
         width: 250px;
         background-color: #e84393;
         color: white;
         padding: 20px;
         box-sizing: border-box;
      }

      .sidebar h2 {
         font-size: 18px;
         margin-bottom: 10px;
      }

      .sidebar p {
         font-size: 14px;
         margin-bottom: 20px;
         color: #ccc;
      }

      .sidebar a {
         display: block;
         width: 100%;
         color: white;
         text-decoration: none;
         padding: 10px 0;
         font-size: 16px;
      }

      .sidebar a:hover {
         background-color: #34495e;
         padding-left: 10px;
      }

      .logout-btn {
         background-color: rgb(83, 60, 231);
         color: white;
         padding: 10px;
         text-align: center;
         border-radius: 4px;
         margin-top: 20px;
         display: inline-block;
         text-decoration: none;
      }

      .logout-btn:hover {
         background-color: #c0392b;
      }

      .main-content {
         flex: 1;
         padding: 40px;
         background-color: #fff;
         display: flex;
         justify-content: center;
         align-items: flex-start;
      }

      .profile-card {
         background-color: white;
         padding: 30px;
         border-radius: 12px;
         max-width: 600px;
         width: 100%;
         box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      }

      .profile-card h2 {
         margin-bottom: 20px;
         color: #444;
         text-align: center;
      }

      .profile-card img {
         display: block;
         margin: 0 auto 20px;
         width: 120px;
         height: 120px;
         object-fit: cover;
         border-radius: 50%;
         border: 4px solid #e84393;
      }

      .profile-card input[type="text"],
      .profile-card input[type="email"],
      .profile-card input[type="file"] {
         width: 100%;
         padding: 10px;
         margin-bottom: 15px;
         border: 1px solid #ccc;
         border-radius: 5px;
      }

      .profile-card textarea {
         width: 100%;
         padding: 10px;
         margin-bottom: 15px;
         border: 1px solid #ccc;
         border-radius: 5px;
         resize: vertical;
      }

      .profile-card button {
         width: 100%;
         background-color: #e84393;
         color: white;
         padding: 12px;
         font-size: 16px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }

      .profile-card button:hover {
         background-color: #d32f70;
      }

      @media (max-width: 768px) {
         .container {
            flex-direction: column;
         }
         .sidebar {
            width: 100%;
         }
         .main-content {
            padding: 20px;
         }
      }
   </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
   <div class="sidebar">
      <h2><?php echo $_SESSION['user_name'] ?? 'User'; ?></h2>
      <p><?php echo $_SESSION['user_email'] ?? ''; ?></p>
      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
      <a href="password.php"><i class="fas fa-lock"></i> Password</a>
      <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
      <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log Out</a>
   </div>

   <div class="main-content">
      <form class="profile-card" method="post" enctype="multipart/form-data">
         <h2>Your Profile</h2>
         <?php if (!empty($user['image'])): ?>
            <img src="uploaded_images/<?php echo $user['image']; ?>" alt="Profile Picture">
         <?php else: ?>
            <img src="images/default-avatar.png" alt="Default Profile Picture">
         <?php endif; ?>

         <input type="file" name="profile_image" accept="image/*">
         <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Your Name" required>
         <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Your Email" required>
         <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Phone Number">
         <textarea name="address" rows="3" placeholder="Your Address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

         <button type="submit" name="update_profile">Update Profile</button>
      </form>
   </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
