
<header class="header">
    <div class="container navbar">
      <a href="auth.php" class="logo">
        <img src="images/logo1.png" alt="Wastebin Logo" />
      </a>

      <nav class="nav" id="nav">
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="#services">Services</a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="request-pickup.php">Request Pickup</a>
        <?php endif; ?>
        <a href="#contact">Contact Us</a>
      </nav>

      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="nav-user desktop-btn" style="display:flex; align-items:center; gap:12px;">
          <span class="nav-username">
            👤 <?php echo htmlspecialchars($_SESSION['username']); ?>
          </span>
          <a href="logout.php" class="btn btn-light desktop-btn">Logout</a>
        </div>
      <?php else: ?>
        <a href="signup.php" class="btn btn-light desktop-btn">Join Us</a>
      <?php endif; ?>

      <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
</header>