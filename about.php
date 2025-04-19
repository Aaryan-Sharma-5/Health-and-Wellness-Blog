<?php
include 'navbar.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - Health and Wellness</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #000000;
      --primary-light: #f0f0f0;
      --secondary-color: #2c3e50;
      --accent-color: #3498db;
      --text-color: #333;
      --light-text: #6c757d;
      --background: #f9f9f9;
      --card-background: #ffffff;
      --border-radius: 12px;
      --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      --transition: all 0.3s ease;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: var(--background);
      color: var(--text-color);
      margin: 0;
      padding: 0;
      line-height: 1.8;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .content-section {
      background-color: var(--card-background);
      border-radius: var(--border-radius);
      padding: 40px;
      box-shadow: var(--box-shadow);
      margin-bottom: 40px;
    }

    .mission-statement {
      font-size: 1.25rem;
      font-weight: 300;
      color: var(--secondary-color);
      line-height: 1.8;
      margin-bottom: 30px;
      border-left: 4px solid var(--primary-color);
      padding-left: 20px;
      font-style: italic;
    }

    h2 {
      color: var(--secondary-color);
      margin-top: 30px;
      font-size: 1.8rem;
      position: relative;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    h2::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: var(--primary-color);
      border-radius: 2px;
    }

    p {
      line-height: 1.8;
      margin-bottom: 20px;
    }

    .offerings {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin: 30px 0;
    }

    .offering-card {
      flex: 1;
      min-width: 250px;
      background-color: var(--primary-light);
      border-radius: var(--border-radius);
      padding: 25px;
      transition: var(--transition);
      border-bottom: 3px solid transparent;
    }

    .offering-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--box-shadow);
      border-bottom: 3px solid var(--primary-color);
    }

    .offering-card h3 {
      color: var(--secondary-color);
      margin-top: 0;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
    }

    .offering-card i {
      margin-right: 10px;
      color: var(--primary-color);
    }

    .offering-card p {
      margin-bottom: 0;
      color: var(--text-color);
    }

    .membership-options {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin: 30px 0;
    }

    .membership-card {
      flex: 1;
      min-width: 200px;
      background: linear-gradient(to bottom right, white, #f8f9fa);
      border-radius: var(--border-radius);
      padding: 25px;
      border: 1px solid #eee;
      transition: var(--transition);
      text-align: center;
    }

    .membership-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--box-shadow);
    }

    .membership-icon {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 15px;
    }

    .membership-card h3 {
      color: var(--secondary-color);
      margin: 10px 0;
    }

    a {
      color: var(--primary-color);
      text-decoration: none;
      transition: var(--transition);
      font-weight: 500;
    }

    a:hover {
      color: var(--accent-color);
    }

    .contact-section {
      text-align: center;
      padding: 30px;
      background-color: var(--primary-light);
      border-radius: var(--border-radius);
    }

    .contact-button {
      display: inline-block;
      background-color: var(--primary-color);
      color: white;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 500;
      margin-top: 15px;
      transition: var(--transition);
    }

    .contact-button:hover {
      background-color: var(--secondary-color);
      color: white;
      transform: scale(1.05);
    }


    .emoji {
      font-size: 1.4em;
      vertical-align: middle;
      margin-right: 5px;
    }

    .closing {
      text-align: center;
      font-size: 1.2rem;
      margin-top: 40px;
      color: var(--secondary-color);
    }

    @media (max-width: 768px) {

      .offerings,
      .membership-options {
        flex-direction: column;
      }

      .content-section {
        padding: 25px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="content-section">
      <h2>About Us</h2>
      <div class="mission-statement">
        Welcome to H&W — your trusted destination for living a healthier, happier life.
      </div>

      <p>At H&W, we believe that wellness is a journey, not a destination. Our mission is to empower individuals with trustworthy information, practical advice, and inspiring stories that promote a balanced approach to health — mind, body, and spirit.</p>

      <p>Our team is passionate about curating and creating content that covers a wide range of topics including nutrition, fitness, mental health, self-care, holistic healing, and more. Whether you're just starting your wellness journey or looking to deepen your understanding, H&W is here to support you every step of the way.</p>

      <h2>What We Offer</h2>

      <div class="offerings">
        <div class="offering-card">
          <h3><i class="fas fa-brain"></i> Expert Advice</h3>
          <p>Articles and tips backed by research and written by health enthusiasts, professionals, and wellness advocates.</p>
        </div>

        <div class="offering-card">
          <h3><i class="fas fa-lightbulb"></i> Inspiration</h3>
          <p>Real-life stories, new trends, and mindful living practices that encourage growth and positivity.</p>
        </div>

        <div class="offering-card">
          <h3><i class="fas fa-users"></i> Community</h3>
          <p>A space where wellness seekers come together to learn, share, and support each other.</p>
        </div>
      </div>

      <p>At Health and Wellness (H&W), we are more than just a blog — we're a movement towards better living, one mindful step at a time.</p>

      <div class="closing">
        <p><strong>Join us on this journey.<br>Your health. Your wellness. Your story.</strong></p>
      </div>
    </div>

    <div class="content-section">
      <h2><span class="emoji">🤝</span> Join the Movement</h2>
      <p>We're more than just a blog — we're a <strong>wellness community</strong>. If you love health and wellness:</p>

      <div class="membership-options">
        <div class="membership-card">
          <div class="membership-icon">
            <i class="fas fa-user-plus"></i>
          </div>
          <h3>Member</h3>
          <p>Engage with content and join discussions</p>
        </div>

        <div class="membership-card">
          <div class="membership-icon">
            <i class="fas fa-edit"></i>
          </div>
          <h3>Editor</h3>
          <p>Contribute your knowledge and share your wellness journey with our community</p>
        </div>

        <div class="membership-card">
          <div class="membership-icon">
            <i class="fas fa-crown"></i>
          </div>
          <h3>Admin</h3>
          <p>Lead initiatives and help shape the future of our wellness platform</p>
        </div>
      </div>
    </div>

    <div class="content-section">
      <h2><span class="emoji">📬</span> Let's Stay Connected</h2>
      <p>Have questions, feedback, or just want to say hi? We'd love to hear from you and answer any questions you might have about our community, content, or services.</p>

      <div class="offerings">
        <div class="offering-card">
          <h3><i class="fas fa-envelope"></i> Email Us</h3>
          <p>Reach out directly to our team for personalized assistance and support.</p>
        </div>

        <div class="offering-card">
          <h3><i class="fas fa-comment-dots"></i> Feedback</h3>
          <p>Share your thoughts and suggestions to help us improve your experience.</p>
        </div>

        <div class="offering-card">
          <h3><i class="fas fa-handshake"></i> Partnerships</h3>
          <p>Interested in collaborating? Let's discuss how we can work together.</p>
        </div>
      </div>

      <div class="closing">
        <p><strong>Ready to connect?</strong></p>
        <a href="contact.php" class="contact-button">Contact Us <i class="fas fa-arrow-right"></i></a>
        <p>Let's grow, glow, and thrive — together. <span class="emoji">🌱</span></p>
      </div>
    </div>
  </div>
</body>

</html>

<?php
include 'footer.php';
?>