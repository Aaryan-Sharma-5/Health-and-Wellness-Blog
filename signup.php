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
        <p class="signin-text" style="margin-bottom: 10px;">Already have an account? Sign in!</p>
        <button class="btn-signin">Sign in</button>
      </div>
    </div>

    <!-- Right Side - Sign Up Form -->
    <div class="right-side">
      <h1>Sign Up to your account</h1>

      <div class="select-container">
        <select class="select-box">
          <option selected disabled>Select Role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
          <option value="editor">Editor</option>
        </select>
      </div>

      <div class="form-container">
        <form>
          <div class="form-group">
            <span class="icon">👤</span>
            <input type="text" placeholder="Username" required>
          </div>

          <div class="form-group">
            <span class="icon">✉️</span>
            <input type="email" placeholder="Email" required>
          </div>

          <div class="form-group">
            <span class="icon">🔒</span>
            <input type="password" id="password" placeholder="Password" required>
            <span class="eye-icon" onclick="togglePassword()">👁️</span>
          </div>

          <div class="form-group">
            <span class="icon">🔒</span>
            <input type="password" id="cpassword" placeholder="Confirm Password" required>
          </div>
          <small class="forgot-password">forgot password?</small>

          <div class="checkbox-container">
            <input type="checkbox" id="terms">
            <label for="terms">I agree with the terms and conditions and privacy policy</label>
          </div>

          <button type="submit" class="btn-sign-up">Sign Up</button>
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
      } else {
        passwordField.type = 'password';
      }
    }
  </script>
</body>

</html>