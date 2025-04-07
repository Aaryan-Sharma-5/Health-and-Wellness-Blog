<?php
echo '
<script
  src="https://kit.fontawesome.com/57a5630a3c.js"
  crossorigin="anonymous"
></script>

<style>
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

  .user-section {
    display: flex;
    align-items: center;
    gap: 1rem;
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

<nav class="navbar">
  <div class="navbar-container">
    <a href="index.php" class="logo-link">
      <img src="logo.png" class="logo-img" />
    </a>

    <div class="nav-links">
      <ul class="nav-list">
        <li><a href="#" class="active">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Blogs</a></li>
        <li><a href="#">Categories</a></li>
      </ul>
    </div>

    <div class="user-section">
      <div class="dropdown-menu" id="user-dropdown">
        <div class="dropdown-header">
          <span class="user-name">aaryan12</span>
        </div>
        <ul class="dropdown-list">
          <li><a href="#">Sign out</a></li>
        </ul>
      </div>

      <button type="button" class="user-btn" id="user-menu-button">
        <i class="fa-solid fa-user fa-2x"></i>
      </button>
    </div>
  </div>
</nav>
';

echo "
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const userButton = document.getElementById('user-menu-button');
    const dropdownMenu = document.getElementById('user-dropdown');

    userButton.addEventListener('click', function () {
      // Toggle visibility
      dropdownMenu.style.display =
        dropdownMenu.style.display === 'block' ? 'none': 'block';
    });

    document.addEventListener('click', function (event) {
      if (
        !userButton.contains(event.target) &&
        !dropdownMenu.contains(event.target)
      ) {
        dropdownMenu.style.display = 'none';
      }
    });
  });
</script>
";
?>

