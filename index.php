<?php
include 'db.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #111;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .carousel-wrapper {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 40px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            max-width: 100%;
            gap: 20px;
        }

        .testimonial-carousel {
            display: flex;
            gap: 20px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .testimonial-card {
            width: 300px;
            background-color: rgb(57, 57, 57);
            color: #ddd;
            padding: 30px 20px;
            border-radius: 10px;
            position: relative;
            flex-shrink: 0;
            transition: all 0.4s ease;
        }

        .testimonial-card::before {
            content: "“";
            font-size: 30px;
            color: #ccc;
            position: absolute;
            top: 10px;
            left: 15px;
        }

        .testimonial-card::after {
            content: "”";
            font-size: 30px;
            color: #ccc;
            position: absolute;
            bottom: 10px;
            right: 15px;
        }

        .testimonial-text {
            margin-top: 30px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .testimonial-author {
            margin-top: 20px;
            font-weight: bold;
            color: #aaa;
            text-align: right;
        }

        .nav-button {
            background: none;
            border: none;
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            padding: 10px;
            transition: color 0.3s;
        }

        .nav-button:hover {
            color: #fff;
        }

        html {
            scroll-behavior: smooth;
        }

        .hero-section {
            position: relative;
            background-image: url('Images/Landing_Page/Landing_page_main.png');
            background-size: cover;
            background-position: center;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero-section .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .divider {
            border: 0;
            height: 2px;
            background: linear-gradient(to right, #333, #666, #333);
            width: 80%;
            margin: 40px auto;
            border-radius: 5px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #fff;
        }

        .section-subtitle {
            color: #ccc;
            margin-bottom: 2rem;
        }

        .card {
            background-color: #222;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            color: #fff;
            font-weight: bold;
        }

        .card-text {
            color: #ccc;
        }

        .btn-dark {
            background-color: #333;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        .btn-light {
            background-color: #fff;
            color: #111;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: #eee;
            transform: scale(1.05);
        }

        textarea {
            resize: none;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 10px;
        }

        textarea::placeholder {
            color: #999;
        }

        #discussionPosts .card {
            background-color: #333;
            margin-bottom: 1rem;
        }

        .article-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .article-card .card-text {
            flex-grow: 1;
        }
    </style>
</head>

<body>

    <section>
        <div class="hero-section">
            <div class="overlay"></div>
            <div class="container">
                <h1>Embrace Wellness: Your Journey Starts Here</h1>
                <p>Welcome to our health and wellness sanctuary, where we inspire you to lead a balanced life. <br> Discover insightful articles, tips, and community support tailored to your wellness journey.</p>
                <a href="#articles" class="btn btn-light rounded-pill px-4 py-2 fw-bold">Explore Now</a>
            </div>
        </div>
    </section>

    <hr class="divider">

    <section class="articles-section">
        <div class="container text-center">
            <h2 class="section-title">Explore Trending Articles</h2>
            <p class="section-subtitle">Discover the latest insights in health and wellness.</p>

            <div class="row justify-content-center mt-4">
                <div class="col-md-4 mb-4">
                    <a href="article.php?id=38" style="text-decoration: none; color: inherit;">
                        <div class="card article-card">
                            <img src="Images/Categories/Category_2.jpg" class="card-img-top" alt="Healthy Diet">
                            <div class="card-body">
                                <h5 class="card-title">Top Foods for a Healthy Diet</h5>
                                <p class="card-text">Discover the super foods that can boost your health and vitality.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-4">
                    <a href="article.php?id=39" style="text-decoration: none; color: inherit;">
                        <div class="card article-card">
                            <img src="Images/Categories/Category_8.png" class="card-img-top img-fluid" alt="Meditation">
                            <div class="card-body">
                                <h5 class="card-title">The Benefits of Meditation</h5>
                                <p class="card-text">Learn how mindfulness can enhance your mental well-being and reduce stress.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-4">
                    <a href="article.php?id=40" style="text-decoration: none; color: inherit;">
                        <div class="card article-card">
                            <img src="Images/Categories/Category_3.jpg" class="card-img-top" alt="Home Workout">
                            <div class="card-body">
                                <h5 class="card-title">Effective Home Workouts</h5>
                                <p class="card-text">Stay fit with these simple yet effective home workout routines.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-3">
                <a href="blogs.php" class="btn btn-dark rounded-pill px-4 py-2 fw-bold">
                    View more <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <hr class="divider">

    <section id="articles" class="container py-5">
        <h2 class="section-title text-center mb-4">Explore Trending Categories</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_1.png" class="card-img-top" alt="Healthy Eating">
                    <div class="card-body">
                        <h5 class="card-title">Healthy Eating Habits</h5>
                        <p class="card-text">Learn how to maintain a balanced diet.</p>
                        <a href="blogs.php?category=2" class="btn btn-dark">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_2.jpg" class="card-img-top" alt="Workout Tips">
                    <div class="card-body">
                        <h5 class="card-title">Best Fitness Routines</h5>
                        <p class="card-text">Discover the best workout routines to stay fit.</p>
                        <a href="blogs.php?category=3" class="btn btn-dark">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_3.png" class="card-img-top" alt="Mental Health">
                    <div class="card-body">
                        <h5 class="card-title">Mental Wellness</h5>
                        <p class="card-text">Find out how to manage stress effectively.</p>
                        <a href="blogs.php?category=1" class="btn btn-dark">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="divider">

    <h2 class="section-title text-center mb-4">Testimonials</h2>
    <div class="carousel-wrapper">
        <button class="nav-button" onclick="prevTestimonial()">❮</button>
        <div class="testimonial-carousel" id="carousel">
        </div>
        <button class="nav-button" onclick="nextTestimonial()">❯</button>
    </div>

    <hr class="divider">

    <!-- Discussion Forum -->
    <section id="discussion" class="container py-5">
        <h2 class="section-title text-center mb-4">Discussion Forum</h2>
        <div class="card p-4">
            <textarea id="discussionText" class="form-control" placeholder="Start a discussion..."></textarea>
            <button id="postBtn" class="btn btn-dark mt-3 w-100">Post</button>
        </div>
        <div id="discussionPosts" class="mt-4"></div>
    </section>

    <?php
    require 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const testimonials = [{
                text: "This platform completely transformed my wellness journey. So grateful!",
                author: "- Sarah J."
            },
            {
                text: "The tips and insights helped me become a better version of myself.",
                author: "- Mike D."
            },
            {
                text: "I've made mindfulness a daily habit thanks to the helpful articles.",
                author: "- Priya S."
            },
            {
                text: "The simplicity and focus of this blog keeps me coming back!",
                author: "- Daniel R."
            },
            {
                text: "Every article hits home. Love the layout and vibe.",
                author: "- Ananya K."
            },
            {
                text: "Clean UI and solid advice — a rare combination these days!",
                author: "- Ravi M."
            },
            {
                text: "Wellness made simple and consistent. Highly recommended.",
                author: "- Jenna L."
            }
        ];

        let currentStart = 0;
        const carousel = document.getElementById("carousel");

        function renderCarousel() {
            carousel.innerHTML = '';
            const visibleCount = Math.min(3, testimonials.length);
            for (let i = 0; i < visibleCount; i++) {
                const index = (currentStart + i) % testimonials.length;
                const t = testimonials[index];

                const card = document.createElement("div");
                card.className = "testimonial-card";
                card.innerHTML = `
            <div class="testimonial-text">${t.text}</div>
            <div class="testimonial-author">${t.author}</div>
        `;
                carousel.appendChild(card);
            }
        }

        function nextTestimonial() {
            currentStart = (currentStart + 1) % testimonials.length;
            renderCarousel();
        }

        function prevTestimonial() {
            currentStart = (currentStart - 1 + testimonials.length) % testimonials.length;
            renderCarousel();
        }

        renderCarousel();

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
                anchor.addEventListener("click", function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute("href")).scrollIntoView({
                        behavior: "smooth"
                    });
                });
            });

            const postBtn = document.getElementById("postBtn");
            const discussionText = document.getElementById("discussionText");
            const discussionPosts = document.getElementById("discussionPosts");

            postBtn.addEventListener("click", function() {
                let text = discussionText.value.trim();
                if (text === "") {
                    alert("Please enter a message before posting.");
                    return;
                }

                let postDiv = document.createElement("div");
                postDiv.classList.add("card", "mt-3", "p-3");
                postDiv.innerHTML = `<p>${text}</p>`;
                discussionPosts.prepend(postDiv);

                discussionText.value = "";
            });
        });
    </script>
</body>

</html>