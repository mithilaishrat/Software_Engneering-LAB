<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit;
}

$errors = [];
$message = [];

$name = $_POST['name'] ?? '';
$number = $_POST['number'] ?? '';
$email = $_POST['email'] ?? '';
$method = $_POST['method'] ?? '';
$flat = $_POST['flat'] ?? '';
$street = $_POST['street'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$country = $_POST['country'] ?? '';
$pin_code = $_POST['pin_code'] ?? '';

if (isset($_POST['order'])) {
    if (empty($name)) $errors['name'] = "Name is required";
    if (empty($number)) {
        $errors['number'] = "Number is required";
    } elseif (!preg_match('/^\d{11}$/', $number)) {
        $errors['number'] = "Number must be exactly 11 digits";
    }
    if (empty($email)) $errors['email'] = "Email is required";
    if (empty($method)) $errors['method'] = "Payment method is required";
    if (empty($flat)) $errors['flat'] = "Flat number is required";
    if (empty($street)) $errors['street'] = "Street is required";
    if (empty($city)) $errors['city'] = "City is required";
    if (empty($state)) $errors['state'] = "State is required";
    if (empty($country)) $errors['country'] = "Country is required";
    if (empty($pin_code)) $errors['pin_code'] = "Pin code is required";

    if (empty($errors)) {
        $address = mysqli_real_escape_string($conn, "flat no. $flat, $street, $city, $state, $country - $pin_code");
        $placed_on = date('d-M-Y');

        $cart_total = 0;
        $cart_products = [];

        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
                $cart_total += $cart_item['price'] * $cart_item['quantity'];
            }
        }

        if ($cart_total == 0) {
            $message[] = 'Your cart is empty!';
        } else {
            $total_products = implode(', ', $cart_products);

            $order_check = mysqli_query($conn, "SELECT * FROM `orders` WHERE name='$name' AND number='$number' AND email='$email' AND method='$method' AND address='$address' AND total_products='$total_products' AND total_price='$cart_total'") or die('query failed');

            if (mysqli_num_rows($order_check) > 0) {
                $message[] = 'Order already placed!';
            } else {
                mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
                mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $message[] = 'Order placed successfully!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            appearance: textfield;
        }
    </style>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="checkout">
    <form action="" method="POST">
        <h3>Place Your Order</h3>
        <div class="flex">
            <div class="inputBox">
                <span>Your name:</span>
                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Enter your name">
                <?php if (isset($errors['name'])) echo '<div class="error">' . $errors['name'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Your number:</span>
                <input type="number" name="number" maxlength="11" value="<?= htmlspecialchars($number) ?>" placeholder="Enter your 11-digit number">
                <?php if (isset($errors['number'])) echo '<div class="error">' . $errors['number'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Your email:</span>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Enter your email">
                <?php if (isset($errors['email'])) echo '<div class="error">' . $errors['email'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Payment method:</span>
                <select name="method">
                    <option value="">Select a method</option>
                    <option value="cash on delivery" <?= $method === 'cash on delivery' ? 'selected' : '' ?>>Cash on Delivery</option>
                    <option value="credit card" <?= $method === 'credit card' ? 'selected' : '' ?>>Credit Card</option>
                    <option value="bkash" <?= $method === 'bkash' ? 'selected' : '' ?>>Bkash</option>
                    <option value="nogod" <?= $method === 'nogod' ? 'selected' : '' ?>>Nogod</option>
                </select>
                <?php if (isset($errors['method'])) echo '<div class="error">' . $errors['method'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Flat no.:</span>
                <input type="text" name="flat" value="<?= htmlspecialchars($flat) ?>" placeholder="e.g. flat no.">
                <?php if (isset($errors['flat'])) echo '<div class="error">' . $errors['flat'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Street:</span>
                <input type="text" name="street" value="<?= htmlspecialchars($street) ?>" placeholder="e.g. Street name">
                <?php if (isset($errors['street'])) echo '<div class="error">' . $errors['street'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>City:</span>
                <input type="text" name="city" value="<?= htmlspecialchars($city) ?>" placeholder="e.g. Sylhet">
                <?php if (isset($errors['city'])) echo '<div class="error">' . $errors['city'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>State:</span>
                <input type="text" name="state" value="<?= htmlspecialchars($state) ?>" placeholder="e.g. Sylhet city">
                <?php if (isset($errors['state'])) echo '<div class="error">' . $errors['state'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Country:</span>
                <input type="text" name="country" value="<?= htmlspecialchars($country) ?>" placeholder="e.g. Bangladesh">
                <?php if (isset($errors['country'])) echo '<div class="error">' . $errors['country'] . '</div>'; ?>
            </div>
            <div class="inputBox">
                <span>Pin code:</span>
                <input type="number" name="pin_code" value="<?= htmlspecialchars($pin_code) ?>" placeholder="e.g. 3100">
                <?php if (isset($errors['pin_code'])) echo '<div class="error">' . $errors['pin_code'] . '</div>'; ?>
            </div>
        </div>

        <input type="submit" name="order" value="Order Now" class="btn">

        <?php
        if (!empty($message)) {
            foreach ($message as $msg) {
              echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
            }
        
        }
        ?>
    </form>
</section>

<?php @include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
