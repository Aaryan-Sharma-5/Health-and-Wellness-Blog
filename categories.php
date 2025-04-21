<?php
session_start();
require_once 'db.php';

$sql = "SELECT category_id, category_name FROM categories ORDER BY category_id";
$result = $connection->query($sql);
$categories = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Explore our health and wellness categories covering mental health, fitness, nutrition, sleep habits, and more for a balanced lifestyle.">
  <title>Categories - Health and Wellness</title>
  <link rel="preload" href="Images/Categories/Category_1.jpg" as="image">
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #111;
      color: #fff;
      margin: 0;
      padding: 0;
      line-height: 1.6;
    }

    .categories-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      text-align: center;
    }

    .categories-container h1 {
      font-size: clamp(1.75rem, 5vw, 2.5rem);
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .categories-container p {
      font-size: clamp(0.9rem, 3vw, 1rem);
      margin-bottom: 2rem;
      color: #ccc;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .category-card {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      aspect-ratio: 4/3;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-card:focus {
      outline: 3px solid #3498db;
    }

    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    .category-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
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
      font-size: clamp(1.2rem, 4vw, 1.5rem);
      text-transform: uppercase;
      text-align: center;
      margin: 0;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      background: rgba(0, 0, 0, 0.4);
      transition: transform 0.3s ease;
    }

    .category-card:hover .overlay h3 {
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
    }

    @media (max-width: 480px) {
      .categories-container {
        padding: 1.5rem;
      }
    }

    .no-categories {
      padding: 2rem;
      text-align: center;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      margin: 1rem 0;
    }
  </style>
</head>

<body>
  <?php include 'navbar.php' ?>

  <main class="categories-container">
    <h1>Explore Our Categories</h1>
    <p>At Health and Wellness (H&W), we've curated a variety of topics to help you live a healthier, more balanced life.
      Explore the categories and find inspiration that fits your journey.</p>

    <?php if (empty($categories)): ?>
      <div class="no-categories">
        <p>No categories available at the moment. Please check back later.</p>
      </div>
    <?php else: ?>
      <div class="categories-grid">
        <?php foreach ($categories as $category):
          $category_id = htmlspecialchars($category['category_id']);
          $jpg_path = "Images/Categories/Category_" . $category_id . ".jpg";
          $png_path = "Images/Categories/Category_" . $category_id . ".png";

          $image_path = file_exists($png_path) ? "Category_$category_id.png" : "Category_$category_id.jpg";
        ?>
          <a href="blogs.php?category=<?= $category_id; ?>"
            class="category-card"
            aria-label="<?= htmlspecialchars($category['category_name']); ?> category">
            <img src="Images/Categories/<?= $image_path; ?>"
              alt="<?= htmlspecialchars($category['category_name']); ?>"
              width="300"
              height="225"
              loading="lazy">
            <div class="overlay">
              <h3><?= htmlspecialchars($category['category_name']); ?></h3>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <?php include 'footer.php' ?>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if ('IntersectionObserver' in window) {
        const options = {
          rootMargin: '50px 0px',
          threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const img = entry.target;
              if (img.getAttribute('loading') === 'lazy') {
                img.src = img.src;
              }
              observer.unobserve(img);
            }
          });
        }, options);

        document.querySelectorAll('.category-card img[loading="lazy"]').forEach(img => {
          observer.observe(img);
        });
      }
    });
  </script>
</body>

</html>