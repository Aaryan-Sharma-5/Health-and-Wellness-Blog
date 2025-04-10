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
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .carousel-wrapper {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 40px;
            background: #f3f3f3;
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
            background-color: #1e1e1e;
            color: #ddd;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
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
            color: #444;
            cursor: pointer;
            padding: 10px;
            transition: color 0.3s;
        }

        .nav-button:hover {
            color: #000;
        }

        html {
            scroll-behavior: smooth;
        }

        .hero-section {
            background-image: url('Images/Landing_Page/Landing_page_article_1.png');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>

    <?php
    require 'navbar.php';
    ?>

    <section>
        <div class="hero-section">
            <div class="overlay"></div>
            <div class="container">
                <h1>Embrace Wellness: Your Journey Starts Here</h1>
                <p>Welcome to our health and wellness sanctuary...</p>
                <a href="#articles" class="btn btn-light rounded-pill px-4 py-2 fw-bold">Explore Now</a>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="articles-section">
        <div class="container text-center">
            <h2 class="section-title">Explore Trending Articles</h2>
            <p class="section-subtitle">Discover the latest insights in health and wellness.</p>

            <div class="row justify-content-center mt-4">
                <!-- Article Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card article-card">
                        <img src="Images/Categories/Category_2.jpg" class="card-img-top" alt="Healthy Diet">
                        <div class="card-body">
                            <span class="badge badge-readtime bg-lightgreen">10 minute read</span>
                            <h5 class="card-title">Top Foods for a Healthy Diet</h5>
                            <p class="card-text">Discover the super foods that can boost your health and vitality.</p>
                        </div>
                    </div>
                </div>

                <!-- Article Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card article-card">
                        <img src="Images/Categories/Category_8.png" class="card-img-top img-fluid" alt="Meditation">
                        <div class="card-body">
                            <span class="badge badge-readtime bg-lightgreen">5 minute read</span>
                            <h5 class="card-title">The Benefits of Meditation</h5>
                            <p class="card-text">Learn how mindfulness can enhance your mental well-being and reduce stress.</p>
                        </div>
                    </div>
                </div>

                <!-- Article Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card article-card">
                        <img src="Images/Categories/Category_3.jpg" class="card-img-top" alt="Home Workout">
                        <div class="card-body">
                            <span class="badge badge-readtime bg-lightgreen">7 minute read</span>
                            <h5 class="card-title">Effective Home Workouts</h5>
                            <p class="card-text">Stay fit with these simple yet effective home workout routines.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View More Button -->
            <div class="mt-3">
                <button class="btn btn-dark rounded-pill px-4 py-2 fw-bold">
                    <a href="#categories.php" style="text-decoration: none; color: #FFFFFF">View more <i class="fas fa-arrow-right ms-2"></i></a>
                </button>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="container py-5">
        <h2 class="text-center mb-4">Explore Trending Categories</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_1.png" class="card-img-top" alt="Healthy Eating">
                    <div class="card-body">
                        <h5 class="card-title">Healthy Eating Habits</h5>
                        <p class="card-text">Learn how to maintain a balanced diet for better health.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_2.jpg" class="card-img-top" alt="Workout Tips">
                    <div class="card-body">
                        <h5 class="card-title">Best Fitness Routines</h5>
                        <p class="card-text">Discover the best workout routines to stay fit.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Images/Landing_Page/Landing_page_article_3.png" class="card-img-top" alt="Mental Health">
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
    <div class="carousel-wrapper">
        <button class="nav-button" onclick="prevTestimonial()">❮</button>
        <div class="testimonial-carousel" id="carousel">
        </div>
        <button class="nav-button" onclick="nextTestimonial()">❯</button>
    </div>

    <!-- Discussion Forum -->
    <section id="discussion" class="container py-5">
        <h2 class="text-center mb-4">Discussion Forum</h2>
        <div class="card p-4">
            <textarea id="discussionText" class="form-control" placeholder="Start a discussion..."></textarea>
            <button id="postBtn" class="btn btn-primary mt-3 w-100">Post</button>
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

        // Smooth Scrolling for Navigation Links
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
                anchor.addEventListener("click", function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute("href")).scrollIntoView({
                        behavior: "smooth"
                    });
                });
            });

            // Discussion Forum - Posting Comments
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