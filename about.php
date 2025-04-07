<?php
include 'navbar.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us </title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .container {
      display: grid;
      place-content: center;
      max-width: 900px;
      margin: 0 auto;
      padding: 40px 20px;
    } 

    h1,
    h2 {
      color: #2c3e50;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    h2 {
      margin-top: 30px;
      font-size: 1.6rem;
    }

    p {
      line-height: 1.7;
      margin-bottom: 20px;
    }

    ul {
      padding-left: 20px;
      margin-bottom: 20px;
    }

    li {
      margin-bottom: 10px;
    }

    a {
      color: #27ae60;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .emoji {
      font-size: 1.2em;
    }
  </style>
</head>

<body>
  <div class="container">

    <h1>✨ About Us</h1>

    <p>Welcome to <strong>Health and Wellness blogs</strong> your destination for health & wellness inspiration <span class="emoji">🌿</span></p>

    <p>At <strong>H&M</strong>, we believe wellness isn't just a trend — it's a lifestyle. Our mission is to empower you with trusted, practical, and inspiring content that supports your journey toward a healthier, happier life.</p>

    <p>Whether you're just starting your wellness journey or already deep in it, we've got you covered — from <strong>healthy recipes</strong> and <strong>mindfulness techniques</strong> to <strong>fitness routines</strong> and <strong>mental wellness tips</strong>.</p>

    <h2>🧠 Our Vision</h2>
    <ul>
      <li>Discover valuable health insights</li>
      <li>Share personal wellness experiences</li>
      <li>Engage in thoughtful, inspiring discussions</li>
    </ul>

    <h2>👥 Who We Are</h2>
    <p>We're a team of passionate health lovers, certified experts, and wellness creators. Our community includes:</p>
    <ul>
      <li><strong>Admins</strong> - who keep everything running smoothly</li>
      <li><strong>Editors</strong> - who research and share high-quality blog content</li>
      <li><strong>Users</strong> - like you, who learn, react, and grow with us!</li>
    </ul>

    <h2>💡 What You'll Find Here</h2>
    <ul>
      <li>🥗 Healthy Eating Tips</li>
      <li>🧘 Meditation & Mindfulness Guides</li>
      <li>💪 Workout Routines</li>
      <li>🧬 Mental Health Awareness</li>
      <li>🌎 User Stories & Shared Experiences</li>
    </ul>

    <h2>🤝 Join the Movement</h2>
    <p>We're more than just a blog — we're a <strong>wellness community</strong>. If you love health and wellness:</p>
    <ul>
      <li>Become a <strong>Member</strong> and engage with content</li>
      <li>Join as an <strong>Editor</strong> to contribute</li>
      <li>Get involved as an <strong>Admin</strong> and lead</li>
    </ul>

    <h2>📬 Let's Stay Connected</h2>
    <p>Have questions, feedback, or just want to say hi? <br>
      <a href="contact.html">Head over to our Contact Page</a> or connect with us on social media!
    </p>

    <p>Let's grow, glow, and thrive — together. <span class="emoji">🌱</span></p>
  </div>
</body>

</html>

<?php
include 'footer.php';
?>