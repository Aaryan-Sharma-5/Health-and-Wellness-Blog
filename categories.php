<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #111;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    body.categories-page .nav-list li a {
      color: #fff; /* Set all links to white */
      text-decoration: none;
    }

    body.categories-page .nav-list li a:hover {
      color: #1f2937; /* Set hover color to black or dark blue */
      text-decoration: none; /* Optional: Add underline on hover */
    }

    body.categories-page .logo-link .logo-text {
      color: #fff; /* Make logo text white */
    }

    body.categories-page .navbar {
      background-color: transparent; /* Make navbar background transparent */
      border-bottom: none; /* Remove border */
    }

    body.categories-page .navbar-divider {
      background-color: rgba(255, 255, 255, 0.2); /* Subtle divider */
    }

    .categories-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      text-align: center;
    }

    .categories-container h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .categories-container p {
      font-size: 1rem;
      margin-bottom: 2rem;
      color: #ccc;
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Adjusted min-width for better alignment */
      gap: 1.5rem;
    }

    .category-card {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.3s ease;
      aspect-ratio: 4 / 3; /* Ensures consistent aspect ratio for all cards */
    }

    .category-card img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Ensures the image fills the card without distortion */
      transition: transform 0.3s ease;
    }

    .category-card:hover img {
      transform: scale(1.1); /* Smooth zoom effect on hover */
    }

    .category-card .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
    }

    .category-card:hover .overlay {
      background: rgba(0, 0, 0, 0.7);
    }

    .category-card .overlay h3 {
      color: #fff;
      font-size: 1.5rem;
      text-transform: uppercase;
      text-align: center;
    }

  </style>
</head>

<body class="categories-page">
  <div class="categories-container">
    <h1>Explore Our Categories</h1>
    <p>Wellness is a holistic approach to health that encompasses physical, mental, and emotional well-being.</p>

    <div class="categories-grid">
      <!-- Category Card 1 -->
      <div class="category-card">
        <img src="Images\Categories\Category_1.jpg" alt="Mental Health">
        <div class="overlay">
          <h3>Mental Health</h3>
        </div>
      </div>

      <!-- Category Card 2 -->
      <div class="category-card">
        <img src="Images\Categories\Category_2.jpg" alt="Food Habits">
        <div class="overlay">
          <h3>Food Habits</h3>
        </div>
      </div>

      <!-- Category Card 3 -->
      <div class="category-card">
        <img src="Images\Categories\Category_3.jpg" alt="Gym and Fitness">
        <div class="overlay">
          <h3>Gym and Fitness</h3>
        </div>
      </div>

      <!-- Category Card 4 -->
      <div class="category-card">
        <img src="Images\Categories\Category_4.jpg" alt="Sleeping Habits">
        <div class="overlay">
          <h3>Sleeping Habits</h3>
        </div>
      </div>

      <!-- Category Card 5 -->
      <div class="category-card">
        <img src="Images\Categories\Category_5.png" alt="Longevity">
        <div class="overlay">
          <h3>Longevity</h3>
        </div>
      </div>

      <!-- Category Card 6 -->
      <div class="category-card">
        <img src="Images\Categories\Category_6.png" alt="Sexual Health">
        <div class="overlay">
          <h3>Sexual Health</h3>
        </div>
      </div>

      <!-- Category Card 7 -->
      <div class="category-card">
        <img src="Images\Categories\Category_7.png" alt="Parenting">
        <div class="overlay">
          <h3>Parenting</h3>
        </div>
      </div>

      <!-- Category Card 8 -->
      <div class="category-card">
        <img src="Images\Categories\Category_8.png" alt="Spiritual Health">
        <div class="overlay">
          <h3>Spiritual Health</h3>
        </div>
      </div>

      <!-- Category Card 9 -->
      <div class="category-card">
        <img src="Images\Categories\Category_9.jpg" alt="Disease Management">
        <div class="overlay">
          <h3>Disease Management</h3>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>