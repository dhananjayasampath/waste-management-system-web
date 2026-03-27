<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$db = new Database();
$conn = $db->conn;

$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $waste    = trim($_POST['waste_type'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    if (empty($name))                                   $errors[] = 'Full name is required.';
    if (empty($email))                                  $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (empty($phone))                                  $errors[] = 'Contact number is required.';
    if (empty($waste))                                  $errors[] = 'Please select a waste type.';
    if (empty($quantity) || !is_numeric($quantity))     $errors[] = 'Please enter a valid quantity.';
    if (empty($address))                                $errors[] = 'Pickup address is required.';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO Request_pickup (name, email, contact_No, waste_type, Quentity, pickup_address) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssds", $name, $email, $phone, $waste, $quantity, $address);
            if ($stmt->execute()) {
                $success = true;
                $_POST = [];
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Request Pickup – EcoShift</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="css/request.css" rel="stylesheet"/>
</head>
<body>

<div id="preloader">
  <div class="pre-logo">
    <div class="pre-logo-icon">♻</div>
    <div class="pre-logo-text">WasteBin</div>
  </div>
  <div class="pre-bars">
    <div class="pre-bar"></div><div class="pre-bar"></div><div class="pre-bar"></div>
    <div class="pre-bar"></div><div class="pre-bar"></div>
  </div>
  <p class="pre-text">Loading</p>
</div>

<?php include 'navbar.php'; ?>

<section class="pickup-hero">
  <div class="pickup-bg-fallback"></div>
  <div class="pickup-bg"></div>
  <div class="hero-mesh-pickup"></div>
  <div class="hero-grid-pickup"></div>

  <div class="pickup-particle" style="width:4px;height:4px;left:12%;bottom:18%;--dur:7s;--del:0s;--dx:25px;"></div>
  <div class="pickup-particle" style="width:3px;height:3px;left:30%;bottom:12%;--dur:9s;--del:1.5s;--dx:-20px;"></div>
  <div class="pickup-particle" style="width:5px;height:5px;left:50%;bottom:22%;--dur:6s;--del:.8s;--dx:35px;"></div>
  <div class="pickup-particle" style="width:3px;height:3px;left:72%;bottom:8%;--dur:8s;--del:2.2s;--dx:-25px;"></div>

  <div class="container pickup-inner">
    <div class="pickup-grid">

      <div class="pickup-left">
        <div class="hero-pill">
          <span class="pill-dot"></span>
          WasteBin Waste Services
        </div>
        <h1 class="pickup-title">
          Schedule<br>
          Your <span class="grad">Pickup</span><br>
          Today.
        </h1>
        <p class="pickup-desc">
          Reliable, eco-friendly waste collection for homes and farms.
          Fill in the form and our team will handle the rest efficiently.
        </p>
        <div class="pickup-stats">
          <div class="stat-item"><h3>500+</h3><p>Pickups Done</p></div>
          <div class="stat-item"><h3>98%</h3><p>On-Time Rate</p></div>
          <div class="stat-item"><h3>12t</h3><p>Waste Recycled</p></div>
        </div>
      </div>

      <div class="pickup-right">
        <div class="pickup-form-card">
          <div class="form-card-header">
            <h2>Request Pickup</h2>
            <p>Schedule your waste collection below</p>
          </div>

          <?php if ($success): ?>
          <div class="pickup-alert pickup-alert--success">
            <i class="bi bi-check-circle-fill"></i>
            <div><strong>Request Submitted!</strong><br>We'll confirm your pickup within 24 hours.</div>
          </div>
          <?php endif; ?>

          <?php if (!empty($errors)): ?>
          <div class="pickup-alert pickup-alert--error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div><?= htmlspecialchars(implode(' ', $errors)) ?></div>
          </div>
          <?php endif; ?>

          <form method="POST" action="" novalidate id="pickupForm">

            <div class="field-wrap">
              <i class="bi bi-person-fill field-icon"></i>
              <input type="text" name="name" placeholder="Full Name"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required autocomplete="name"/>
            </div>

            <div class="field-wrap">
              <i class="bi bi-envelope-fill field-icon"></i>
              <input type="email" name="email" placeholder="Email Address"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autocomplete="email"/>
            </div>

            <div class="field-wrap">
              <i class="bi bi-telephone-fill field-icon"></i>
              <input type="tel" name="phone" placeholder="Contact Number"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required autocomplete="tel"/>
            </div>

            <div class="field-wrap">
              <i class="bi bi-recycle field-icon"></i>
              <select name="waste_type" required>
                <option value="" disabled <?= empty($_POST['waste_type']) ? 'selected' : '' ?>>Waste Type</option>
                <?php
                $types = ['organic'=>'Organic','plastic'=>'Plastic','metal'=>'Metal','electronic'=>'Electronic','glass'=>'Glass','mixed'=>'Mixed'];
                foreach ($types as $val => $label):
                  $sel = (($_POST['waste_type'] ?? '') === $val) ? 'selected' : '';
                ?>
                <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="field-wrap">
              <i class="bi bi-box-seam-fill field-icon"></i>
              <input type="number" name="quantity" placeholder="Quantity (kg)" min="1"
                value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>" required/>
            </div>

            <div class="field-wrap">
              <i class="bi bi-geo-alt-fill field-icon field-icon--top"></i>
              <textarea name="address" placeholder="Pickup Address (Street, City)" rows="3"
                required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="form-submit-btn" id="submitBtn">
              <span class="btn-text"><i class="bi bi-truck"></i> Schedule Pickup</span>
              <span class="btn-loader" style="display:none;"><i class="bi bi-hourglass-split"></i> Submitting…</span>
            </button>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
window.addEventListener('load', () => {
  setTimeout(() => document.getElementById('preloader')?.classList.add('hide'), 900);
});

const header = document.querySelector('.header');
const updateHeader = () => {
  if (window.scrollY > 30) { header.classList.add('scrolled'); }
  else { header.classList.remove('scrolled');  }
};

window.addEventListener('scroll', updateHeader, { passive: true });
updateHeader();

const toggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');
toggle?.addEventListener('click', () => nav.classList.toggle('open'));
document.addEventListener('click', e => {
  if (!toggle?.contains(e.target) && !nav?.contains(e.target)) nav.classList.remove('open');
});
nav?.querySelectorAll('a').forEach(a => a.addEventListener('click', () => nav.classList.remove('open')));

const form = document.getElementById('pickupForm');
const submitBtn = document.getElementById('submitBtn');
form?.addEventListener('submit', () => {
  if (form.checkValidity()) {
    const text   = submitBtn.querySelector('.btn-text');
    const loader = submitBtn.querySelector('.btn-loader');
    submitBtn.disabled = true;
    if (text)   text.style.display   = 'none';
    if (loader) loader.style.display = 'inline-flex';
  }
});

const qty = document.querySelector('input[name="quantity"]');
qty?.addEventListener('input', () => { if (parseFloat(qty.value) < 1) qty.value = 1; });

document.querySelectorAll('.pickup-alert').forEach(el => {
  setTimeout(() => {
    el.style.transition = 'opacity .5s ease, max-height .5s ease, margin .5s ease, padding .5s ease';
    el.style.opacity    = '0';
    el.style.maxHeight  = '0';
    el.style.overflow   = 'hidden';
    el.style.margin     = '0';
    el.style.padding    = '0';
    setTimeout(() => el.remove(), 500);
  }, 6000);
});
</script>
</body>
</html>