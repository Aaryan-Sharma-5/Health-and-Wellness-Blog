<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Health & Wellness</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#articles">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="#discussion">Discussion</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="home" class="hero-section text-center text-white d-flex align-items-center">
        <div class="container">
            <h1 class="display-4">Promoting a Healthier Life</h1>
            <p class="lead">Discover health tips, fitness guides, and mental wellness advice.</p>
            <a href="#articles" class="btn btn-light btn-lg">Explore Articles</a>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container py-5">
        <h2 class="text-center mb-4">About Us</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="about.webp" class="img-fluid" alt="About Us">
            </div>
            <div class="col-md-6">
                <h3>Our Mission</h3>
                <p>Our mission is to provide you with the best health and wellness advice to help you lead a healthier life. We believe that a healthy lifestyle is essential for overall well-being and happiness.</p>
                <h3>Our Vision</h3>
                <p>Our vision is to create a community of health-conscious individuals who are motivated to make positive changes in their lives. We aim to inspire and empower you to take control of your health.</p>
            </div>
        </div>
        <br><br>
        <div style="text-align: center;"><h3>Importance of Health</h3><br>
        <p >Drawing on centuries of wisdom, Ayurveda doesn't just treat symptoms; it aims to identify and address the root cause of an imbalance, diving deeper into understanding the unique constitution (prakriti) of each individual. The science behind Ayurveda is rooted in natural principles, treating the body as a whole system and understanding how it interacts with its environment.The power of healing lies in a holistic approach, combining Ayurveda, Panchakarma, Colon Therapy, Homeopathy, Yoga, and a balanced diet. Ayurveda and Panchakarma detoxify and restore balance, while Colon Therapy and Homeopathy support the body's natural healing and Yoga harmonizes body and mind, and a balanced diet promotes vitality. Together, they offer a comprehensive path to long-term wellness. This holistic and preventive approach makes it highly effective for various chronic conditions, stress management, and enhancing overall quality of life. Ayurveda, often considered the mother of all healing sciences, provides the foundation for Panchakarma, Yoga, Colon Therapy, Homeopathy, and Diet Management, offering a comprehensive approach to holistic health.</p></div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="container py-5">
        <h2 class="text-center mb-4">Latest Articles</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="article1.jpeg" class="card-img-top" alt="Healthy Eating">
                    <div class="card-body">
                        <h5 class="card-title">Healthy Eating Habits</h5>
                        <p class="card-text">Learn how to maintain a balanced diet for better health.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="article2.jpeg" class="card-img-top" alt="Workout Tips">
                    <div class="card-body">
                        <h5 class="card-title">Best Fitness Routines</h5>
                        <p class="card-text">Discover the best workout routines to stay fit.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="article3.jpeg" class="card-img-top" alt="Mental Health">
                    <div class="card-body">
                        <h5 class="card-title">Mental Wellness</h5>
                        <p class="card-text">Find out how to manage stress effectively.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="container py-5">
        <h2 class="text-center">Success Stories</h2>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active text-center">
                    <p>"This blog helped me lose 15kg in 3 months!" - <strong>John Doe</strong></p>
                </div>
                <div class="carousel-item text-center">
                    <p>"The mental wellness tips changed my life." - <strong>Sarah K.</strong></p>
                </div>
            </div>
            <a class="carousel-control-prev" href="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </section>    

    <!-- Discussion Forum -->
    <section id="discussion" class="container py-5">
        <h2 class="text-center mb-4">Discussion Forum</h2>
        <div class="card p-4">
            <textarea id="discussionText" class="form-control" placeholder="Start a discussion..."></textarea>
            <button id="postBtn" class="btn btn-primary mt-3 w-100">Post</button>
        </div>
        <div id="discussionPosts" class="mt-4"></div>
    </section>

    <!-- Footer -->
    <footer class="text-center bg-dark text-white py-3">
        <section id="newsletter" class="container py-5 text-center">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get weekly health tips directly in your inbox!</p>
            <form>
                <input type="email" class="form-control mb-3 w-50 mx-auto" placeholder="Enter your email">
                <button class="btn btn-primary">Subscribe</button>
            </form>
        </section>    
        <p>&copy; 2025 Health & Wellness Blog | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
