<?php
require 'db.php';
session_start();

if (isset($_SESSION['signup-success'])) {
  $signupSuccess = $_SESSION['signup-success'];
  unset($_SESSION['signup-success']);
} else {
  $signupSuccess = null;
}

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if (isset($_POST['submit'])) {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var(($_POST['password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (!$email) {
    $_SESSION['signin'] = 'Email is Incorrect';
  } elseif (!$password) {
    $_SESSION['signin'] = 'Password required';
  } else {
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user_record = $result->fetch_assoc();
      $db_password = $user_record['password'];

      if (password_verify($password, $db_password)) {
        // Set session for access control
        $_SESSION['user-id'] = $user_record['user_id'];
        $_SESSION['username'] = $user_record['username'];
        $_SESSION['signin-success'] = "User successfully logged in";

        if ($user_record['is_admin'] == 1) {
          $_SESSION['user_is_admin'] = true;
        }

        header('location: index.php');
        exit();
      } else {
        $_SESSION['signin'] = "Invalid password. Please try again.";
      }
    } else {
      $_SESSION['signin'] = "User not found. Please check your input.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
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
      max-width: 1000px;
      height: 80%;
      display: flex;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .left-side {
      background-color: rgb(0, 0, 0);
      color: white;
      width: 60%;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .left-side h1 {
      font-size: 2.5rem;
      margin-bottom: 40px;
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

    .form-group i {
      position: absolute;
      left: 0;
      top: 12px;
      color: white;
    }

    .form-group .eye-icon {
      position: absolute;
      right: 0;
      top: 12px;
      cursor: pointer;
      color: white;
    }

    .forgot-password {
      position: absolute;
      right: 0;
      bottom: -20px;
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
    }

    .btn-sign-in {
      background-color: #000;
      color: white;
      border: solid #FFFFFF 1px;
      border-radius: 25px;
      padding: 12px;
      width: 100%;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 10px;
      box-shadow: 0 2px 5px rgba(255, 255, 255, 0.3);
    }

    .btn-sign-in:hover {
      background-color: #111;
    }

    .right-side {
      background-color: #e0e0e0;
      width: 60%;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .right-side h1 {
      font-size: 2.5rem;
      color: #000;
      margin-bottom: 30px;
    }

    .right-side p {
      color: #333;
      margin-bottom: 60px;
      line-height: 1.6;
    }

    .signup-text {
      margin-top: 60px;
      font-size: 1rem;
      color: #333;
    }

    .signup-link {
      color: #000;
      font-weight: bold;
      text-decoration: none;
    }

    .btn-signup {
      background-color: #000;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 15px;
    }

    .icon {
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

    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    #top-alert {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 9999;
      padding: 15px 25px;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
      0% {
        opacity: 1;
      }

      80% {
        opacity: 1;
      }

      100% {
        opacity: 0;
        display: none;
      }
    }

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
  </style>
</head>

<body>
  <?php if ($signupSuccess): ?>
    <div id="top-alert" class="alert alert-success">
      <?= htmlspecialchars($signupSuccess); ?>
    </div>
  <?php endif; ?>

  <div class="container" style="border-radius: 20px; overflow: hidden;">
    <div class="left-side">

      <h1>Sign in to your account</h1>
      <?php if (isset($_SESSION['signin'])): ?>
        <div class="alert__message error">
          <p><?= $_SESSION['signin'];
              unset($_SESSION['signin']); ?></p>
        </div>
      <?php endif; ?>

      <form action="signin.php" method="POST">
        <div class="form-group">
          <span class="icon">✉️</span>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
          <span class="icon">🔒</span>
          <input type="password" name="password" id="password" placeholder="Password" required>
          <span class="eye-icon" onclick="togglePassword()">👁️</span>
          <small><a href="#" class="forgot-password">forgot password?</a></small>
        </div>
        <br>
        <button type="submit" name="submit" class="btn-sign-in">Sign In</button>
      </form>
    </div>

    <div class="right-side">
      <h1>Welcome Back to H&W!</h1>
      <p style="margin-bottom: 20px;">Glad to see you again! Sign in to continue your journey toward better health and well-being with the latest tips, guides, and exclusive content.</p>

      <div>
        <img src="Images/logo.png" alt="Company Logo" style="max-width: 80px; height: auto;">
      </div>

      <div>
        <p class="signup-text" style="margin-bottom: 10px;">Don't have an account? <a href="signup.php" class="signup-link">Sign Up!</a></p>
        <button class="btn-signup"><a href="signup.php" style="text-decoration:none; color:#FFFFFF">Sign Up</a></button>
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

    setTimeout(() => {
      const alert = document.getElementById('top-alert');
      if (alert) {
        alert.remove();
      }
    }, 5000);
  </script>
</body>

</html>