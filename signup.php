<?php

require "db.php";
session_start();

//get signup form data
if (isset($_POST["submit"])) {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // validate form data
  if (!$username) {
    $_SESSION['signup'] = 'Please enter your Username';
  } elseif (!$email) {
    $_SESSION['signup'] = 'Please enter your Email';
  } elseif (strlen($password) < 8 || strlen($confirmpassword) < 8) {
    $_SESSION['signup'] = 'Password should be 8+ characters';
  } elseif ($password !== $confirmpassword) {
    $_SESSION['signup'] = "Passwords do not match";
  } else {
    // Check if username or email already exists
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $_SESSION['signup'] = "Username or Email already exists";
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Insert new user into the database
      $stmt = $connection->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)");
      $stmt->bind_param("sss", $username, $email, $hashed_password);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        $_SESSION['signup-success'] = "Registration successful! Please log in.";
        header('location: signin.php');
        exit();
      } else {
        $_SESSION['signup'] = "Something went wrong. Please try again.";
      }
    }
  }

  if (isset($_SESSION['signup'])) {
    $_SESSION['signup-data'] = $_POST;
    header('location: signup.php');
    die();
  }
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']);
} else {
  $message = null;
}

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
} else {
  $error = null;
}

if (isset($_SESSION['signup-data'])) {
  unset($_SESSION['signup-data']);
}

$connection->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #494949;
    }

    .container {
      width: 100%;
      max-width: 70%;
      height: 80%;
      display: flex;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      border-radius: 20px;
    }

    /* Left Side - Welcome Back */
    .left-side {
      background-color: #e0e0e0;
      width: 50%;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background-color: #f2f2f2;
      background-image: linear-gradient(rgba(242, 242, 242, 0.8), rgba(242, 242, 242, 0.8)), url('texture.jpg');
      background-size: cover;
    }

    .left-side h1 {
      font-size: 2.5rem;
      color: #000;
      margin-bottom: 30px;
    }

    .left-side p {
      color: #333;
      margin-bottom: 60px;
      line-height: 1.6;
      text-align: center;
    }

    .signin-text {
      margin-top: 60px;
      font-size: 1rem;
      color: #333;
    }

    .signin-link {
      color: #000;
      font-weight: bold;
      text-decoration: none;
    }

    .btn-signin {
      background-color: #000;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 15px;
    }

    .btn-signin a {
      text-decoration: none;
      color: #ffffff;
    }

    /* Right Side - Sign Up Form */
    .right-side {
      background-color: #ffffff;
      width: 50%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .right-side h1 {
      font-size: 2.2rem;
      margin-bottom: 40px;
      text-align: center;
    }

    .select-container {
      margin-bottom: 25px;
      position: relative;
      width: 100%;
    }

    .select-box {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      color: #333;
      appearance: none;
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 16px;
    }

    .form-container {
      background-color: #707070;
      border-radius: 10px;
      padding: 30px;
      margin-top: 20px;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-group input {
      width: 100%;
      background-color: transparent;
      border: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.6);
      padding: 10px 30px 10px 30px;
      color: white;
      font-size: 1rem;
    }

    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .form-group input:focus {
      outline: none;
      border-bottom: 1px solid white;
    }

    .form-group .icon {
      position: absolute;
      left: 0;
      top: 10px;
      width: 20px;
      height: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .form-group .eye-icon {
      position: absolute;
      right: 0;
      top: 10px;
      cursor: pointer;
      color: white;
    }

    .forgot-password {
      text-align: right;
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      margin-top: -15px;
      display: block;
    }

    .checkbox-container {
      display: flex;
      align-items: flex-start;
      margin: 20px 0 30px;
    }

    .checkbox-container input {
      margin-right: 10px;
      margin-top: 3px;
    }

    .checkbox-container label {
      font-size: 0.85rem;
      color: rgba(255, 255, 255, 0.8);
      line-height: 1.3;
    }

    .btn-sign-up {
      background-color: #000;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px;
      width: 100%;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .left-side,
      .right-side {
        width: 100%;
        padding: 40px 20px;
      }
    }

    .alert__message {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-align: center;
    }

    .alert__message.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .alert__message.success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Left Side - Welcome Back -->
    <div class="left-side">
      <h1>Welcome Back!</h1>
      <p style="margin-bottom: 20px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

      <!-- Logo Section -->
      <div>
        <img src="logo.png" alt="Company Logo" style="max-width: 80px; height: auto;">
      </div>
      <div>
        <p class="signin-text" style="margin-bottom: 10px;">Already have an account? </p>
        <button class="btn-signin"><a href="signin.php"> Sign in</button></a>
      </div>
    </div>

    <!-- Right Side - Sign Up Form -->
    <div class="right-side">
      <?php
      if (isset($_SESSION['signup'])): ?>
        <div class="alert__message error">
          <p>
            <?= $_SESSION['signup'];
            unset($_SESSION['signup']);
            ?>
          </p>
        </div>
      <?php endif ?>

      <h1>Sign Up to your account</h1>

      <div class="form-container">
        <form action="signup.php" enctype="multipart/form-data" method="POST">
          <div class="form-group">
            <span class="icon">👤</span>
            <input type="text" name="username" value="<?= htmlspecialchars($_SESSION['signup-data']['username'] ?? '') ?>" placeholder="Username" required>
          </div>

          <div class="form-group">
            <span class="icon">✉️</span>
            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['signup-data']['email'] ?? '') ?>" placeholder="Email" required>
          </div>

          <div class="form-group">
            <span class="icon">🔒</span>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password ?? '') ?>" placeholder="Password" required>
            <span class="eye-icon" onclick="togglePassword()">👁️</span>
          </div>

          <div class="form-group">
            <span class="icon">🔒</span>
            <input type="password" id="cpassword" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword ?? '') ?>" placeholder="Confirm Password" required>
          </div>

          <button type="submit" name="submit" class="btn-sign-up">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.querySelector('.eye-icon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.textContent = '🙈';
      } else {
        passwordField.type = 'password';
        eyeIcon.textContent = '👁️';
      }
    }
  </script>
</body>

</html>