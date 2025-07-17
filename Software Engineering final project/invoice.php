<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid Invoice ID.";
    exit();
}

$order_id = intval($_GET['id']);

$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '{$_SESSION['user_id']}'") or die('Query failed');

if (mysqli_num_rows($order_query) === 0) {
    echo "Order not found.";
    exit();
}

$order = mysqli_fetch_assoc($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Invoice #<?php echo $order['id']; ?></title>
   <style>
      body {
         font-family: Arial, sans-serif;
         padding: 40px;
         background-color: #f9f9f9;
         color: #333;
      }

      .invoice-box {
         background: #fff;
         padding: 30px;
         border: 1px solid #ddd;
         border-radius: 10px;
         max-width: 700px;
         margin: auto;
         box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      }

      .invoice-box h2 {
         text-align: center;
         color: #e84393;
         margin-bottom: 30px;
      }

      .invoice-box p {
         font-size: 16px;
         margin: 8px 0;
      }

      .invoice-box span {
         font-weight: bold;
         color: #000;
      }

      .print-btn {
         display: block;
         text-align: center;
         margin-top: 30px;
      }

      .print-btn button {
         padding: 10px 20px;
         background-color: #3498db;
         color: white;
         border: none;
         border-radius: 6px;
         cursor: pointer;
         font-size: 16px;
      }

      .print-btn button:hover {
         background-color: #2c80b4;
      }

      @media print {
         .print-btn {
            display: none;
         }
      }
   </style>
</head>
<body>

<div class="invoice-box">
   <h2>Invoice #<?php echo $order['id']; ?></h2>
   <p>Date: <span><?php echo $order['placed_on']; ?></span></p>
   <p>Name: <span><?php echo $order['name']; ?></span></p>
   <p>Phone: <span><?php echo $order['number']; ?></span></p>
   <p>Email: <span><?php echo $order['email']; ?></span></p>
   <p>Address: <span><?php echo $order['address']; ?></span></p>
   <hr>
   <p>Payment Method: <span><?php echo $order['method']; ?></span></p>
   <p>Ordered Items: <span><?php echo $order['total_products']; ?></span></p>
   <p>Total Price: <span>$<?php echo $order['total_price']; ?>/-</span></p>
   <p>Status:
      <span style="color:<?php echo ($order['payment_status'] == 'pending') ? 'tomato' : 'green'; ?>">
         <?php echo $order['payment_status']; ?>
      </span>
   </p>

   <div class="print-btn">
      <button onclick="window.print()"><i class="fas fa-print"></i> Print Invoice</button>
   </div>
</div>

</body>
</html>
