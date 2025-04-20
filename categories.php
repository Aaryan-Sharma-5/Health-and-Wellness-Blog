<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - Health and Wellness</title>
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #111;
      color: #fff;
      margin: 0;
      padding: 0;
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
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }

    .category-card {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      aspect-ratio: 4/3;
    }

    .category-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .category-card:hover img {
      transform: scale(1.1);
    }

    .overlay {
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

    .overlay h3 {
      color: #fff;
      font-size: 1.5rem;
      text-transform: uppercase;
      text-align: center;
      margin: 0;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php' ?>

  <div class="categories-container">
    <h1>Explore Our Categories</h1>
    <p>At Health and Wellness (H&W), we've curated a variety of topics to help you live a healthier, more balanced life.
      Explore the categories and find inspiration that fits your journey.</p>

    <div class="categories-grid">
      <a href="blogs.php?category=1" class="category-card">
        <img src="Images/Categories/Category_1.jpg" alt="Mental Health" loading="lazy">
        <div class="overlay">
          <h3>Mental Health</h3>
        </div>
      </a>

      <a href="blogs.php?category=2" class="category-card">
        <img src="Images/Categories/Category_2.jpg" alt="Food Habits" loading="lazy">
        <div class="overlay">
          <h3>Food Habits</h3>
        </div>
      </a>

      <a href="blogs.php?category=3" class="category-card">
        <img src="Images/Categories/Category_3.jpg" alt="Gym and Fitness" loading="lazy">
        <div class="overlay">
          <h3>Gym and Fitness</h3>
        </div>
      </a>

      <a href="blogs.php?category=4" class="category-card">
        <img src="Images/Categories/Category_4.jpg" alt="Sleeping Habits" loading="lazy">
        <div class="overlay">
          <h3>Sleeping Habits</h3>
        </div>
      </a>

      <a href="blogs.php?category=5" class="category-card">
        <img src="Images/Categories/Category_5.png" alt="Longevity" loading="lazy">
        <div class="overlay">
          <h3>Longevity</h3>
        </div>
      </a>

      <a href="blogs.php?category=6" class="category-card">
        <img src="Images/Categories/Category_6.png" alt="Sexual Health" loading="lazy">
        <div class="overlay">
          <h3>Sexual Health</h3>
        </div>
      </a>

      <a href="blogs.php?category=7" class="category-card">
        <img src="Images/Categories/Category_7.png" alt="Parenting" loading="lazy">
        <div class="overlay">
          <h3>Parenting</h3>
        </div>
      </a>

      <a href="blogs.php?category=8" class="category-card">
        <img src="Images/Categories/Category_8.png" alt="Spiritual Health" loading="lazy">
        <div class="overlay">
          <h3>Spiritual Health</h3>
        </div>
      </a>

      <a href="blogs.php?category=9" class="category-card">
        <img src="Images/Categories/Category_9.jpg" alt="Disease Management" loading="lazy">
        <div class="overlay">
          <h3>Disease Management</h3>
        </div>
      </a>
    </div>
  </div>

  <?php include 'footer.php' ?>

</body>

</html>