<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">home</a> / about </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/about-img-1.png" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>We offer fresh, handpicked flowers and custom arrangements, delivered with care and on time for every occasion.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>what we provide?</h3>
            <p>From bouquets to event decorations, we provide handpicked flowers, tailored to your needs. Timely delivery and personalized touches are our promise.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.jpg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.jpg" alt="">
        </div>

        <div class="content">
            <h3>who we are?</h3>
            <p>A team of passionate florists with a love for fresh flowers, we craft custom bouquets and arrangements that bring joy and elegance to your special moments.</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">client's reviews</h1>

    <div class="slider-container">
        <div class="slider-track">

            <div class="box">
                <img src="images/pic-1.png" alt="">
                <p>"Absolutely loved the bouquet! The flowers were fresh, and the arrangement was beyond beautiful. Highly recommend!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Fahad Ahmed</h3>
            </div>

            <div class="box">
                <img src="images/pic-2.png" alt="">
                <p>"The perfect flowers for my wedding! The team at our shop made the entire process so easy and memorable. Thank you!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Jasmin Akter</h3>
            </div>

            <div class="box">
                <img src="images/pic-3.png" alt="">
                <p>"I ordered a mixed flower bouquet for my mom’s birthday, and she was thrilled! Great service and timely delivery!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Rajib Khan</h3>
            </div>

            <div class="box">
                <img src="images/pic-4.png" alt="">
                <p>"I’ve ordered from here a few times, and I’m always impressed with the quality and creativity. They never disappoint!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Rani Joy</h3>
            </div>

            <div class="box">
                <img src="images/pic-5.png" alt="">
                <p>"The flowers were gorgeous and delivered on time. Great service and beautiful arrangements! Highly recommend!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Raj Hussain</h3>
            </div>

            <div class="box">
                <img src="images/pic-6.png" alt="">
                <p>"Such a wonderful experience! The staff was super helpful, and the flowers were perfect for my anniversary!"</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Nita Kapur</h3>
            </div>

        </div>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
