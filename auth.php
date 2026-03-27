<?php
session_start();
include 'dbconnection.php'; 

$formMessage = "";

$db = new Database();
$conn = $db->conn; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO feedback (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        $formMessage = "✅ Thank you! Your feedback has been submitted successfully.";
    } else {
        $formMessage = "❌ Error submitting feedback: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WasteBin - Waste Management</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div id="preloader">
    <div id="lottie-loader"></div>
    <p class="loading-text">Loading...</p>
  </div>

  <?php include 'navbar.php'; ?>

  <section class="hero" id="home">
    <div class="hero-bg">
      <span class="blur blur-1"></span>
      <span class="blur blur-2"></span>
      <span class="grid-overlay"></span>
    </div>
    <div class="container hero-container">
      <div class="hero-left">
        <h1 class="hero-title">
          Clean Cities.<br />
          <span>Greener Future.</span>
        </h1>
        <p class="hero-text">
          Empowering communities with smart waste collection, recycling awareness,
          and sustainable environmental solutions for a cleaner and healthier world.
        </p>
        <div class="hero-actions">
          <a href="#services" class="btn btn-primary">Get Started</a>
          <a href="#about" class="btn btn-secondary">Explore More</a>
        </div>
        <div class="hero-stats">
          <div class="stat-card">
            <h3>10K+</h3>
            <p>Waste Requests Managed</p>
          </div>
          <div class="stat-card">
            <h3>85%</h3>
            <p>Recycling Awareness Growth</p>
          </div>
        </div>
      </div>
      <div class="hero-right">
        <div class="hero-image-wrap">
          <div class="floating-card card-top">
            <span>♻ Eco Active</span>
          </div>
          <img src="images/hero-tree.png" alt="Eco Waste Management Illustration" class="hero-image" />
          <div class="floating-card card-bottom">
            <span>🌿 Sustainable Living</span>
          </div>
          <div class="circle-ring ring-1"></div>
          <div class="circle-ring ring-2"></div>
        </div>
      </div>
    </div>
  </section>

  <section class="about section" id="about">
    <div class="container">
      <p class="section-label">About Us</p>
      <h2 class="about-title">
       Empowering Green Action
      </h2>
      <div class="about-grid">
        <div class="about-image">
          <img id="aboutMainImage" src="images/about-mission.png" alt="Our Mission" />
        </div>
        <div class="about-content">
          <div class="about-tags">
            <button class="tag active" data-tab="mission">Our Mission</button>
            <button class="tag" data-tab="vision">Our Vision</button>
            <button class="tag" data-tab="goal">Our Goal</button>
          </div>
          <div class="about-text-box">
            <h3 id="aboutHeading">Inspiring Responsible Waste Management</h3>
            <p id="aboutParagraph">
              Our mission is to encourage responsible waste disposal by providing
              an accessible platform that educates users about recycling
              practices and proper waste handling. By empowering individuals with
              knowledge and simple tools, we help communities take meaningful
              steps toward protecting the environment.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="services section" id="services">
    <div class="container">
      <p class="section-label">Services</p>
      <h2>Waste Categories &amp;<br />Recycling Solutions</h2>
      <div class="cards">
        <article class="card">
          <img src="images/card-1.jpg" alt="Nature and outdoor waste collection" />
          <div class="card-body">
            <h3>Waste Collection Support</h3>
            <p>Easy request handling for cleaner neighborhoods and organized disposal services.</p>
            <a href="waste-collection.html">Read More</a>
          </div>
        </article>
        <article class="card">
          <img src="images/card-2.jpg" alt="Recycling bins" />
          <div class="card-body">
            <h3>Recycling Education</h3>
            <p>Promote proper sorting methods and improve awareness of recyclable materials.</p>
            <a href="recycling-education.html">Read More</a>
          </div>
        </article>
        <article class="card">
          <img src="images/card-3.jpg" alt="Colorful recycle bins" />
          <div class="card-body">
            <h3>Waste Sorting</h3>
            <p>Encourage separation of organic, plastic, paper, and metal waste for better processing.</p>
            <a href="waste-sorting.html">Read More</a>
          </div>
        </article>
        <article class="card">
          <img src="images/card-4.jpg" alt="Environmental sustainability" />
          <div class="card-body">
            <h3>Environmental Awareness</h3>
            <p>Inspire communities to adopt sustainable habits and reduce pollution together.</p>
            <a href="environmental-awareness.html">Read More</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="contact section" id="contact">
    <div class="container contact-grid">
      <div class="contact-info">
        <p class="section-label">Contact Us</p>
        <h2>Together for a<br />Cleaner Planet</h2>
        <p>
          We'd love to hear from you. Reach out to learn more about our
          waste collection solutions, recycling support, and green community
          initiatives.
        </p>
        <div class="mini-contact">
          <p><strong>Email:</strong> support@wastebin.com</p>
          <p><strong>Phone:</strong> +94 71 234 5678</p>
          <p><strong>Location:</strong> Sri Lanka</p>
        </div>
      </div>

      <form class="contact-form" id="contactForm" method="POST" action="">
        <div class="input-row">
          <input type="text" name="name" placeholder="Full Name" required />
          <input type="email" name="email" placeholder="Email Address" required />
        </div>
        <input type="text" name="subject" placeholder="Subject" required />
        <textarea name="message" rows="6" placeholder="Message" required></textarea>
        <button type="submit" name="submit_feedback" class="btn btn-primary form-btn">Send Message</button>
        <p class="form-message" id="formMessage"><?php echo $formMessage; ?></p>
      </form>
    </div>
  </section>

  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <a href="#" class="logo footer-logo">
          <img src="images/logo1.png" alt="Watebin Logo" />
        </a>
        <p>Your cleaner future begins with small sustainable steps.</p>
      </div>
      <div>
        <h4>About</h4>
        <ul>
          <li><a href="#about">Our Mission</a></li>
          <li><a href="#services">Our Services</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Services</h4>
        <ul>
          <li><a href="#services">Collection</a></li>
          <li><a href="#services">Sorting</a></li>
          <li><a href="#services">Recycling</a></li>
        </ul>
      </div>
      <div>
        <h4>Follow</h4>
        <div class="socials">
          <a href="#">Fb</a>
          <a href="#">In</a>
          <a href="#">Tw</a>
        </div>
      </div>
    </div>
    <div class="container footer-bottom">
      <p>© 2026 Watebin. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>