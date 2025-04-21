<?php
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<style>
  :root {
    --black: #ffffff;
    --white: #000000;
    --box-shadow: 0 4px 20px rgba(255, 255, 255, 0.08);
  }

  .navbar {
    background-color: #000000;
    border-bottom: 1px solid #2a2e33;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  .navbar-container {
    max-width: 80% !important;
    margin: auto !important;
    padding: 1rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
  }

  .navbar-divider {
    height: 1px;
    background-color: #2a2e33;
    margin: 0;
  }

  .logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    gap: 0.75rem;
  }

  .logo-img {
    filter: invert(1);
    height: 3rem;
  }

  .logo-text {
    font-size: 1.5rem;
    font-weight: 600;
    white-space: nowrap;
    color: #e0e0e0;
  }

  .user-btn {
    border: 0.9px solid rgb(157, 157, 157);
    border-radius: 50%;
    padding: 0;
    height: 42px;
    width: 42px;
    cursor: pointer;
    background-color: #121212;
    color: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .user-avatar {
    width: 100%;
    height: 100%;
    background-color: var(--black);
    color: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }

  .dropdown-menu {
    display: none;
    position: absolute;
    margin-top: 1rem;
    background-color: #121212 !important;
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
    overflow: hidden;
    z-index: 50;
    min-width: 12rem;
    list-style-type: none;
    padding: 0;
  }

  .dropdown-header {
    padding: 1rem;
    border-bottom: 1px solid #2a2e33;
  }

  .user-name {
    font-size: 0.875rem;
    color: #e0e0e0 !important;
  }

  .dropdown-menu li a {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: #c0c0c0;
    text-decoration: none;
  }

  .dropdown-menu li a:hover {
    background-color: #1a1a1a;
  }

  .navbar .nav-list {
    list-style: none !important;
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 2rem !important;
  }

  .navbar .nav-list li a {
    text-decoration: none !important;
    padding: 0.5rem 1rem !important;
    color: #e0e0e0 !important;
    display: block !important;
  }

  .nav-list li a:hover {
    background-color: #1a1a1a;
  }

  .nav-list li a.active {
    color: #5a9cff;
    background-color: #1a2235;
    border-radius: 0.25rem;
  }

  .nav__profile {
    position: relative;
  }

  .nav__profile:hover .dropdown-menu {
    display: block;
  }

  .nav__profile:hover .user-btn {
    background-color: #1a1a1a;
  }

  @media (max-width: 768px) {
    .nav-list {
      margin-left: 0;
      gap: 1rem;
    }

    .dropdown-menu {
      right: 0;
    }
  }
</style>
<nav class="navbar">
  <div class="navbar-container">
    <a href="index.php" class="logo-link">
      <img src="Images/logo.png" class="logo-img" alt="Logo">
      <span class="logo-text">Health & Wellness</span>
    </a>
    <ul class="nav-list">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="blogs.php">Blogs</a></li>
      <li><a href="categories.php">Categories</a></li>
      <?php if (isset($_SESSION['user-id'])) : ?>
        <li class="nav__profile">
          <button class="user-btn" id="user-menu-button">
            <div class="user-avatar">
              <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
            </div>
          </button>

          <ul class="dropdown-menu" id="user-dropdown">
            <div class="dropdown-header">
              <span class="user-name"><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?></span>
            </div>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="addBlogs.php">Add Blog</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      <?php else : ?>
        <li><a href="signin.php">SignIn</a></li>
      <?php endif ?>
    </ul>
  </div>
</nav>
<div class="navbar-divider"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const userButton = document.getElementById('user-menu-button');
    const dropdownMenu = document.getElementById('user-dropdown');

    if (userButton && dropdownMenu) {
      userButton.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
      });

      document.addEventListener('click', function() {
        dropdownMenu.style.display = 'none';
      });
    }
  });
</script>