<?php
include 'navbar.php'
?>

<style>
  body {
    font-family: 'Montserrat', Arial, sans-serif;
    background-color: #fff;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
  }

  .contact-section {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 20px;
  }

  .contact-header {
    text-align: center;
    margin-bottom: 50px;
  }

  .contact-header h1 {
    font-size: 42px;
    font-weight: 700;
    color: #000;
    margin-bottom: 15px;
    letter-spacing: 1px;
  }

  .contact-header p {
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    color: #555;
    line-height: 1.8;
  }

  .contact-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 50px;
  }

  .contact-card {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 40px 30px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #eee;
  }

  .contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }

  .contact-icon {
    font-size: 40px;
    margin-bottom: 20px;
    color: #000;
  }

  .contact-card h3 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #000;
  }

  .contact-card p, .contact-card a {
    font-size: 16px;
    color: #555;
  }

  .contact-card a {
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .contact-card a:hover {
    color: #000;
    text-decoration: underline;
  }

  .support-note {
    margin-top: 60px;
    padding: 30px;
    background-color: #f2f2f2;
    border-left: 5px solid #000;
    border-radius: 5px;
  }

  .support-note p {
    font-size: 16px;
    margin-bottom: 10px;
  }

  .support-note a {
    color: #000;
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
      font-size: 32px;
    }
  }
</style>

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

<?php
include 'footer.php';
?>