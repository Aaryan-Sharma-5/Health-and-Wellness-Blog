<?php include 'navbar.php'; ?>

<style>
  body.contact-page {
    font-family: Arial, sans-serif;
    background-color: #111;
    color: #fff;
    margin: 0;
    padding: 0;
    line-height: 1.6;
  }
  
  /* Navigation styling for this page */
  body.contact-page .nav-list li a {
    color: #fff; /* Set all links to white */
    text-decoration: none;
  }

  body.contact-page .nav-list li a:hover {
    color: #1f2937; /* Match hover color from categories page */
    text-decoration: none;
  }

  body.contact-page .logo-link .logo-text {
    color: #fff; /* Make logo text white */
  }

  body.contact-page .navbar {
    background-color: transparent; /* Make navbar background transparent */
    border-bottom: none; /* Remove border */
  }

  body.contact-page .navbar-divider {
    background-color: rgba(255, 255, 255, 0.2); /* Subtle divider */
  }

  .contact-section {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 20px;
    text-align: center;
  }

  .contact-header {
    margin-bottom: 50px;
  }

  .contact-header h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }

  .contact-header p {
    font-size: 1rem;
    max-width: 700px;
    margin: 0 auto 2rem;
    color: #ccc;
  }

  .contact-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
  }

  .contact-card {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
  }

  .contact-icon {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    color: #fff;
  }

  .contact-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #fff;
  }

  .contact-card p, .contact-card a {
    font-size: 1rem;
    color: #ccc;
    margin-bottom: 0.5rem;
  }

  .contact-card a {
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .contact-card a:hover {
    color: #fff;
    text-decoration: underline;
  }

  .support-note {
    margin-top: 3rem;
    padding: 2rem;
    background-color: rgba(255, 255, 255, 0.05);
    border-left: 5px solid #fff;
    border-radius: 5px;
    text-align: left;
  }

  .support-note p {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    color: #ccc;
  }

  .support-note a {
    color: #fff;
    font-weight: 600;
    text-decoration: underline;
    transition: opacity 0.3s ease;
  }

  .support-note a:hover {
    opacity: 0.7;
  }

  @media (max-width: 768px) {
    .contact-methods {
      grid-template-columns: 1fr;
    }
    
    .contact-header h1 {
      font-size: 2rem;
    }
  }
</style>

<body class="contact-page">
  <section class="contact-section">
    <div class="contact-header">
      <h1>Get in Touch with Us</h1>
      <p>We'd love to hear from you! Whether you have questions, feedback, or just want to say hello, feel free to reach out.
      Your journey to better health matters to us — and we're here to support you every step of the way.</p>
    </div>

    <div class="contact-methods">
      <div class="contact-card">
        <div class="contact-icon">📧</div>
        <h3>Email Us</h3>
        <p><a href="mailto:support@healthandwellness.com">support@healthandwellness.com</a></p>
        <p>We respond to all inquiries within 24 hours</p>
      </div>
      
      <div class="contact-card">
        <div class="contact-icon">📱</div>
        <h3>Call Us</h3>
        <p><a href="tel:+919003243650">+91-9003243650</a></p>
        <p>Available Monday to Friday, 9AM - 5PM IST</p>
      </div>
    </div>
    
    <div class="support-note">
      <p>If you're reaching out for mental health support, know that you are not alone.</p>
      <p>Visit <a href="https://www.wannatalkaboutit.com/in/13-reasons-why/#support" target="_blank">wannatalkaboutit.com</a> for guidance, or contact us directly — we're here for you.</p>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>