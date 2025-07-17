<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit;
}

// Get user info
$user_query = mysqli_query($conn, "SELECT name, email FROM users WHERE id = '$user_id'") or die('User query failed');
$user = mysqli_fetch_assoc($user_query);
$username = $user ? $user['name'] : 'User';
$_SESSION['user_name'] = $username;
$_SESSION['user_email'] = $user['email'] ?? '';

// Get order statistics using payment_status
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE user_id = '$user_id'"))['total'];
$completed_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS completed FROM orders WHERE user_id = '$user_id' AND payment_status = 'Completed'"))['completed'];
$cancelled_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cancelled FROM orders WHERE user_id = '$user_id' AND payment_status = 'Cancelled'"))['cancelled'];
$dispatched_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS dispatched FROM orders WHERE user_id = '$user_id' AND payment_status = 'Dispatched'"))['dispatched'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS pending FROM orders WHERE user_id = '$user_id' AND payment_status = 'Pending'"))['pending'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>User Dashboard</title>
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
      }

      .welcome-message {
         font-size: 24px;
         font-weight: bold;
         margin-bottom: 10px;
         color: #333;
      }

      .dashboard-subtext {
         margin-bottom: 30px;
         font-size: 16px;
         color: #666;
      }

      .cards-container {
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
      }

      .card {
         background-color: #fff;
         border-radius: 10px;
         box-shadow: 0 2px 10px rgba(0,0,0,0.1);
         padding: 20px;
         width: 220px;
         text-align: center;
         border-left: 6px solid #e91e63;
      }

      .card h3 {
         font-size: 18px;
         color: #444;
         margin-bottom: 10px;
      }

      .card p {
         font-size: 26px;
         font-weight: bold;
         color: #000;
      }
   </style>
</head>
<body>

<?php @include 'header.php'; ?>

<div class="container">
   <?php @include 'sidebar.php'; ?>

   <div class="main-content">
      <div class="welcome-message">Hey <?php echo htmlspecialchars($username); ?>, welcome to your dashboard!</div>
      <div class="dashboard-subtext">Here is your order summary:</div>

      <div class="cards-container">
         <div class="card">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
         </div>
         <div class="card">
            <h3>Completed</h3>
            <p><?php echo $completed_orders; ?></p>
         </div>
         <div class="card">
            <h3>Dispatched</h3>
            <p><?php echo $dispatched_orders; ?></p>
         </div>
         <div class="card">
            <h3>Cancelled</h3>
            <p><?php echo $cancelled_orders; ?></p>
         </div>
         <div class="card">
            <h3>Pending</h3>
            <p><?php echo $pending_orders; ?></p>
         </div>
      </div>
   </div>
</div>

<?php @include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>
