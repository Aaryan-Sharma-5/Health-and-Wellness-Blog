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

        html {
            scroll-behavior: smooth;
        }

        .hero-section {
            background: url('hero-image.webp') no-repeat center center/cover;
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

    <!-- Hero Section -->
    <section class="articles-section">
  <div class="container text-center">
    <h2 class="section-title">Explore Trending Wellness Articles</h2>
    <p class="section-subtitle">Discover the latest insights in health and wellness.</p>

    <div class="row justify-content-center mt-4">
      <!-- Article Card 1 -->
      <div class="col-md-4 mb-4">
        <div class="card article-card">
          <img src="your-path/healthy-diet.jpg" class="card-img-top" alt="Healthy Diet">
          <div class="card-body">
            <span class="badge badge-readtime bg-lightgreen">10 minute read</span>
            <h5 class="card-title">Top Foods for a Healthy Diet</h5>
            <p class="card-text">Discover the superfoods that can boost your health and vitality.</p>
          </div>
        </div>
      </div>

      <!-- Article Card 2 -->
      <div class="col-md-4 mb-4">
        <div class="card article-card">
          <img src="your-path/meditation.jpg" class="card-img-top" alt="Meditation">
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
          <img src="your-path/home-workout.jpg" class="card-img-top" alt="Home Workout">
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
        View more <i class="fas fa-arrow-right ms-2"></i>
      </button>
    </div>
  </div>
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

    <?php
    require 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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