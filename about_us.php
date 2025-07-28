<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>

<body>

    <?php include 'header.php'; ?> <!-- Including header -->

    <!-- About Us Section -->
    <section id="about" class="about">
        <h1 class="heading">
            <span>About</span>
            <span>Us</span>
        </h1>
        <div class="row">
            <div class="image" data-aos="fade-right"
                data-aos-offset="300"
                data-aos-easing="ease-in-sine">
                <img src="assets/images/p3.png" alt="">
            </div>
            <div class="content" data-aos="fade-right"
                data-aos-offset="300"
                data-aos-easing="ease-in-sine">
                <img src="assets/images/p6.png" alt="">
                <h3>
                    Reliable, Affordable, Flexible, Secure, Budget-Friendly</h3>

                <p>
                    At Bliss, we partner with leading and trusted daycare providers to offer dependable, high-quality childcare solutions tailored to your needs. Whether you're seeking flexible schedules, secure environments, or budget-friendly options, Bliss is here to support working parents with care you can trust.💕
                </p>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>Phone Number</h3>
                <a href="tel:1234567890">123-456-7890</a><br>
                <a href="tel:1112223333">111-222-3333</a>
            </div>
            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>Email Address</h3>
                <a href="mailto:abcdefgs@gmail.com">abcdefgs@gmail.com</a><br>
                <a href="mailto:abcdefgs@gmail.com">abcdefgs@gmail.com</a>
            </div>
            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Office Address</h3>
                <address>
                    12345 Elm Street, Apt 56B<br>
                    Sunset Tower Building,<br>
                    Bangladesh
                </address>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // animation duration in ms
            once: true // whether animation should happen only once
        });
    </script>

</body>

</html>