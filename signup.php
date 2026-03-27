<?php
session_start();
include 'dbconnection.php';

$db   = new Database();
$conn = $db->conn;

if (isset($_SESSION['user_id'])) {
    header("Location: request-pickup.php");
    exit();
}

$signupMessage     = "";
$signupMessageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {

    $username = trim($_POST['signup_name']);
    $email    = trim($_POST['signup_email']);
    $password = $_POST['signup_password'];      
    $confirm  = $_POST['signup_confirm'];        

    $safe_username = mysqli_real_escape_string($conn, $username);
    $safe_email    = mysqli_real_escape_string($conn, $email);

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $signupMessage     = "Please fill in all required fields.";
        $signupMessageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signupMessage     = "Please enter a valid email address.";
        $signupMessageType = "error";

    } elseif (strlen($password) < 6) {
        $signupMessage     = "Password must be at least 6 characters.";
        $signupMessageType = "error";

    } elseif ($password !== $confirm) {
        $signupMessage     = "Passwords do not match!";
        $signupMessageType = "error";

    } else {
        $check  = "SELECT user_id FROM user WHERE email = '$safe_email' LIMIT 1";
        $result = mysqli_query($conn, $check);

        if (!$result) {
            $signupMessage     = "Database error: " . mysqli_error($conn);
            $signupMessageType = "error";

        } elseif (mysqli_num_rows($result) > 0) {
            $signupMessage     = "This email is already registered. Please sign in.";
            $signupMessageType = "error";

        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = "INSERT INTO user (username, email, password)
                       VALUES ('$safe_username', '$safe_email', '$hashed')";

            if (mysqli_query($conn, $insert)) {
                header("Location: signin.php?registered=1");
                exit();

            } else {
                $signupMessage     = "Error creating account: " . mysqli_error($conn);
                $signupMessageType = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up — EcoPickup</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --green-btn:          #3a8c4a;
      --green-btn-hover:    #2d7039;
      --green-accent:       #3a7d44;
      --form-bg:            #f4f4ef;
      --input-bg:           #ffffff;
      --input-focus-bg:     #eef3ff;
      --input-border:       #ddddd5;
      --input-focus-border: #7da8f0;
      --label-color:        #555;
      --text-dark:          #181818;
      --text-muted:         #888;
      --radius:             22px;
      --shadow:             0 28px 72px rgba(0,0,0,0.32);
    }
    html, body { height: 100%; font-family: 'DM Sans', sans-serif; }
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      background: #0d200d url('images/auth-forest.jpg') center/cover no-repeat;
      position: relative;
    }
    body::before {
      content: ''; position: fixed; inset: 0;
      background: rgba(8, 25, 8, 0.52); z-index: 0;
    }
    .auth-container {
      position: relative; z-index: 1; display: flex;
      width: 100%; max-width: 860px; min-height: 520px;
      border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);
    }
    .form-panel {
      flex: 1 1 57%; background: var(--form-bg);
      display: flex; align-items: center; justify-content: center; padding: 48px 44px;
    }
    .form-box {
      width: 100%; max-width: 340px;
      display: flex; flex-direction: column; align-items: center;
    }
    .dot-icon { width: 16px; height: 16px; background: var(--text-dark); border-radius: 50%; margin-bottom: 16px; }
    .form-box h2 {
      font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700;
      color: var(--text-dark); margin-bottom: 6px; text-align: center;
    }
    .sub-text { font-size: 0.79rem; color: var(--text-muted); margin-bottom: 22px; text-align: center; }
    .input-group { margin-bottom: 12px; width: 100%; }
    .input-group label { display: block; font-size: 0.76rem; font-weight: 500; color: var(--label-color); margin-bottom: 4px; }
    .input-group input {
      width: 100%; padding: 9px 13px; background: var(--input-bg);
      border: 1.5px solid var(--input-border); border-radius: 7px;
      font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--text-dark);
      outline: none; transition: border-color .2s, background .2s;
    }
    .input-group input:focus { border-color: var(--input-focus-border); background: var(--input-focus-bg); }
    .password-wrap { position: relative; }
    .password-wrap input { padding-right: 56px; }
    .toggle-password {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      background: none; border: none; font-size: 0.75rem; font-family: 'DM Sans', sans-serif;
      font-weight: 500; color: var(--text-muted); cursor: pointer; transition: color .15s;
    }
    .toggle-password:hover { color: var(--text-dark); }
    .main-btn {
      width: 100%; padding: 12px; background: var(--green-btn); color: #fff;
      border: none; border-radius: 8px; font-size: 0.91rem; font-family: 'DM Sans', sans-serif;
      font-weight: 600; cursor: pointer; margin-top: 10px; transition: background .2s, transform .1s;
    }
    .main-btn:hover  { background: var(--green-btn-hover); }
    .main-btn:active { transform: scale(.985); }
    .main-btn.loading { opacity: 0.75; cursor: not-allowed; pointer-events: none; }
    .form-message {
      width: 100%; text-align: center; font-size: 0.8rem;
      margin-top: 10px; padding: 8px 12px; border-radius: 6px;
    }
    .form-message.success { color: #1a6e2a; background: #d4f0da; }
    .form-message.error   { color: #8b1a1a; background: #fde8e8; }
    .social-text { text-align: center; font-size: 0.77rem; color: var(--text-muted); margin-top: 14px; }
    .social-text span { color: var(--green-accent); font-weight: 600; cursor: pointer; }
    .social-text span:hover { text-decoration: underline; }
    .overlay-panel {
      flex: 0 0 43%; position: relative;
      display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .overlay-panel::before {
      content: ''; position: absolute; inset: 0;
      background: url('images/auth-forest.jpg') center/cover no-repeat;
      z-index: 0;
    }
    .overlay-panel::after {
      content: ''; position: absolute; inset: 0;
      background: rgba(6, 32, 8, 0.40); z-index: 1;
    }
    .overlay-content { position: relative; z-index: 2; text-align: center; padding: 40px 30px; color: #fff; }
    .overlay-content h3 {
      font-family: 'Playfair Display', serif; font-size: 1.45rem; font-weight: 700;
      margin-bottom: 10px; line-height: 1.3; text-shadow: 0 2px 14px rgba(0,0,0,.35);
    }
    .overlay-content p { font-size: 0.82rem; opacity: .88; margin-bottom: 26px; line-height: 1.55; }
    .ghost-btn {
      padding: 10px 30px; background: transparent; color: #fff;
      border: 2px solid rgba(255,255,255,.78); border-radius: 50px;
      font-size: 0.87rem; font-family: 'DM Sans', sans-serif; font-weight: 600;
      cursor: pointer; letter-spacing: .02em; transition: background .2s, border-color .2s;
    }
    .ghost-btn:hover { background: rgba(255,255,255,.14); border-color: #fff; }
    @media (max-width: 680px) {
      .auth-container { flex-direction: column; max-width: 420px; min-height: auto; }
      .form-panel     { flex: none; padding: 36px 28px; }
      .overlay-panel  { flex: none; min-height: 200px; }
    }
  </style>
</head>
<body>
  <div class="auth-container">

    <div class="form-panel">
      <div class="form-box">
        <div class="dot-icon"></div>
        <h2>Create an account</h2>
        <p class="sub-text">Join us and start your eco journey today</p>

        <form method="POST" action="" id="signupForm">
          <div class="input-group">
            <label for="signup-name">Name</label>
            <input type="text" id="signup-name" name="signup_name"
                   value="<?php echo isset($_POST['signup_name']) ? htmlspecialchars($_POST['signup_name']) : ''; ?>"
                   autocomplete="name" required />
          </div>
          <div class="input-group">
            <label for="signup-email">Email</label>
            <input type="email" id="signup-email" name="signup_email"
                   value="<?php echo isset($_POST['signup_email']) ? htmlspecialchars($_POST['signup_email']) : ''; ?>"
                   autocomplete="email" required />
          </div>
          <div class="input-group">
            <label for="signup-password">Password</label>
            <div class="password-wrap">
              <input type="password" id="signup-password" name="signup_password"
                     autocomplete="new-password" required />
              <button type="button" class="toggle-password" data-target="signup-password">Hide</button>
            </div>
          </div>
          <div class="input-group">
            <label for="signup-confirm">Confirm Password</label>
            <div class="password-wrap">
              <input type="password" id="signup-confirm" name="signup_confirm"
                     autocomplete="new-password" required />
              <button type="button" class="toggle-password" data-target="signup-confirm">Hide</button>
            </div>
          </div>

          <button type="submit" name="signup" class="main-btn" id="signupBtn">Create an account</button>

          <?php if ($signupMessage): ?>
            <p class="form-message <?php echo htmlspecialchars($signupMessageType); ?>">
              <?php echo htmlspecialchars($signupMessage); ?>
            </p>
          <?php endif; ?>

          <p class="social-text">Or, continue with <span>Google</span> or <span>Facebook</span></p>
        </form>
      </div>
    </div>

    <div class="overlay-panel">
      <div class="overlay-content">
        <h3>Already have an account?</h3>
        <p>Sign in to manage your account easily</p>
        <button class="ghost-btn" onclick="window.location.href='signin.php'">Sign in</button>
      </div>
    </div>

  </div>
  <script>
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        if (input.type === 'password') { input.type = 'text'; btn.textContent = 'Show'; }
        else { input.type = 'password'; btn.textContent = 'Hide'; }
      });
    });
    document.getElementById('signupForm').addEventListener('submit', function () {
      const btn = document.getElementById('signupBtn');
      btn.textContent = 'Creating account…';
      btn.classList.add('loading');
    });
  </script>
</body>
</html>