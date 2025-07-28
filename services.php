<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daycare Services</title>
    <link rel="stylesheet" href="assets/css/services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <!-- Preload images -->
    <link rel="preload" href="assets/images/learn_1.png" as="image">
    <link rel="preload" href="assets/images/learn_2.png" as="image">
    <link rel="preload" href="assets/images/learn_3.png" as="image">
    <!-- Add other images as needed -->
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="services">
        <h1 class="heading text-box"><span>Our Daycare </span><span>Services</span></h1>

        <h2>Learning and Development</h2>
        <div class="cards" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
            <div class="card">
                <img src="assets/images/learn_1.png" alt="Language Learning">
                <h3>Language Learning</h3>
                <p>We offer language learning activities including storytelling, alphabet recognition, and basic reading skills to develop linguistic abilities.</p>
            </div>
            <div class="card">
                <img src="assets/images/learn_2.png" alt="Mathematics">
                <h3>Mathematics</h3>
                <p>Our mathematics sessions focus on basic arithmetic, number recognition, and problem-solving activities to nurture early numeracy skills.</p>
            </div>
            <div class="card">
                <img src="assets/images/learn_3.png" alt="Creative Arts">
                <h3>Creative Arts</h3>
                <p>Creative arts activities such as drawing, painting, and crafts are provided to foster creativity and fine motor skills in children.</p>
            </div>
        </div>

        <h2>Special Care</h2>
        <div class="cards" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="card">
                <img src="assets/images/special_1.png" alt="Sensory Activities">
                <h3>Sensory Activities</h3>
                <p>Our sensory activities are designed to engage children through touch, sound, sight, and smell, helping to improve cognitive development and motor skills.</p>
            </div>
            <div class="card">
                <img src="assets/images/special_2.png" alt="Speech Therapy">
                <h3>Speech Therapy</h3>
                <p>Our trained professionals offer speech therapy sessions to help children with speech and language development needs.</p>
            </div>
            <div class="card">
                <img src="assets/images/special_3.png" alt="Occupational Therapy">
                <h3>Occupational Therapy</h3>
                <p>We provide occupational therapy to support children with special needs in developing essential life skills and motor functions.</p>
            </div>
        </div>

        <h2>Meal Planning and Management</h2>
        <div class="cards">
            <div class="card">
                <img src="assets/images/meal_1.png" alt="Nutritious Meals" onerror="this.src='assets/images/fallback.png'">
                <h3>Nutritious Meals</h3>
                <p>We offer a variety of nutritious meals designed to meet the dietary needs of growing children, ensuring a balanced diet.</p>
            </div>
            <div class="card">
                <img src="assets/images/meal_2.png" alt="Allergy Management" onerror="this.src='assets/images/fallback.png'">
                <h3>Allergy Management</h3>
                <p>Our meal planning includes careful management of allergies to ensure the safety and well-being of children with dietary restrictions.</p>
            </div>
            <div class="card">
                <img src="assets/images/meal_3.png" alt="Meal Preparation" onerror="this.src='assets/images/fallback.png'">
                <h3>Meal Preparation</h3>
                <p>We provide delicious and healthy meals prepared with fresh ingredients daily, ensuring children enjoy their food while getting the nutrients they need.</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: false,
                offset: 50, // Trigger earlier
                duration: 1000,
                easing: 'ease-in-out',
                mirror: true,
                anchorPlacement: 'center-bottom' // Trigger when element's center hits viewport bottom
            });
            // Force AOS to recalculate positions
            setTimeout(() => {
                AOS.refreshHard();
            }, 100);
        });
    </script>
</body>

</html>