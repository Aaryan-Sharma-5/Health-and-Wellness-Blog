<?php
require 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar</title>
  <script src="https://kit.fontawesome.com/57a5630a3c.js" crossorigin="anonymous"></script>
  <style>
    /* General Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .navbar {
      background-color: white;
      border-bottom: 1px solid #d1d5db;
      font-family: Arial, sans-serif;
    }

    .navbar-container {
      max-width: 80%;
      margin: auto;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar-divider {
      height: 1px;
      background-color: #d1d5db;
      margin: 0;
    }

    .logo-link {
      display: flex;
      align-items: center;
      text-decoration: none;
      gap: 0.75rem;
    }

    .logo-img {
      height: 3rem;
    }

    .logo-text {
      font-size: 1.5rem;
      font-weight: 600;
      white-space: nowrap;
      color: #1f2937;
    }

    .user-section {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-btn {
      border: 0.9px solid rgb(98, 98, 98);
      border-radius: 100px;
      padding: 0.25rem;
      height: 3rem;
      width: 3rem;
      cursor: pointer;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      margin-top: 1rem;
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      z-index: 50;
      min-width: 12rem;
    }

    .dropdown-header {
      padding: 1rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .user-name {
      display: block;
      font-size: 0.875rem;
      color: #111827;
    }

    .dropdown-list {
      list-style: none;
    }

    .dropdown-list li a {
      display: block;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      color: #374151;
      text-decoration: none;
    }

    .dropdown-list li a:hover {
      background-color: #f3f4f6;
    }

    .menu-toggle {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
    }

    .menu-icon {
      width: 1.25rem;
      height: 1.25rem;
      color: #6b7280;
    }

    .nav-links {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .nav-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      margin-top: 1rem;
    }

    .nav-list li a {
      text-decoration: none;
      padding: 0.5rem 1rem;
      color: #111827;
      display: block;
    }

    .nav-list li a:hover {
      background-color: #f3f4f6;
    }

    .nav-list li a.active {
      color: #2563eb;
      background-color: #eff6ff;
      border-radius: 0.25rem;
    }

    .nav__profile {
      position: relative;
    }

    .nav__profile:hover .dropdown-menu {
      display: block;
    }

    .nav__profile:hover .user-btn {
      background-color: #f3f4f6;
    }

    .nav__profile:hover .user-btn i {
      color: #2563eb;
    }

    .alert {
      padding: 1rem;
      margin: 1rem auto;
      max-width: 80%;
      border-radius: 5px;
      font-size: 1rem;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
      padding: 1rem;
      margin: 1rem auto;
      max-width: 80%;
      border-radius: 5px;
      font-size: 1rem;
      text-align: center;
    }

    /* Responsive */
    @media (min-width: 768px) {
      .menu-toggle {
        display: none;
      }

      .nav-links {
        display: block;
        width: auto;
      }

      .nav-list {
        margin-left: 35%;
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-top: 0;
        gap: 2rem;
      }

      .dropdown-menu {
        position: absolute;
        right: 1rem;
        top: 4rem;
      }
    }
  </style>
</head>

<body>
  <?php if (isset($_SESSION['signin-success'])) : ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($_SESSION['signin-success']); ?>
    </div>
    <?php unset($_SESSION['signin-success']); ?>
  <?php endif; ?>
  <?php if (isset($_SESSION['signin-error'])) : ?>
    <div class="alert alert-error">
      <?= htmlspecialchars($_SESSION['signin-error']); ?>
    </div>
    <?php unset($_SESSION['signin-error']); ?>
  <?php endif; ?>

  <nav>
    <div class="navbar-container">
      <a href="index.php" class="logo-link">
        <img src="logo.png" class="logo-img" alt="Logo">
        <span class="logo-text">Health & Wellness</span>
      </a>
      <ul class="nav-list">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="blogs.php">Blogs</a></li>
        <li><a href="categories.php">Categories</a></li>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <li class="nav__profile">
            <button class="user-btn avatar" id="user-menu-button">
              <i class="fa-solid fa-user fa-2x"></i>
            </button>

            <ul class="dropdown-menu" id="user-dropdown">
              <div class="dropdown-header">
                <span class="user-name"><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?></span>
              </div>
              <li><a href="index.php">Dashboard</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li><a href="signin.php">SignIn</a></li>
        <?php endif ?>
      </ul>
  </nav>
  <div class="navbar-divider"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Dropdown menu toggle
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

      // Responsive navigation toggle
      const openNavBtn = document.getElementById('open__nav-btn');
      const closeNavBtn = document.getElementById('close__nav-btn');
      const navContainer = document.querySelector('.navbar-container');

      if (openNavBtn && closeNavBtn && navContainer) {
        openNavBtn.addEventListener('click', function() {
          navContainer.classList.add('show');
        });

        closeNavBtn.addEventListener('click', function() {
          navContainer.classList.remove('show');
        });
      }
    });
  </script>
</body>

</html>