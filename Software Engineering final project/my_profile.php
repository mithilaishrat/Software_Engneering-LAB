<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>User Dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css"> <!-- Optional external style -->
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
      }

      .placeholder {
         font-size: 18px;
         color: gray;
         margin-top: 100px;
         text-align: center;
      }
   </style>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>

<div class="container">
   <!-- Sidebar -->
   <div class="sidebar">
      <h2><?php echo $_SESSION['user_name'] ?? 'User'; ?></h2>
      <p><?php echo $_SESSION['user_email'] ?? ''; ?></p>

      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
      <a href="password.php"><i class="fas fa-lock"></i> Password</a>
      <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
      <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log Out</a>
   </div>

   <!-- Main Content -->
   <div class="main-content" id="main-content">
      <p class="placeholder">Select an option from the sidebar.</p>
   </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>
