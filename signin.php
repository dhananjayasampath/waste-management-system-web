<?php
session_start();
include 'dbconnection.php';

$db   = new Database();
$conn = $db->conn;

if (isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$signinMessage     = "";
$signinMessageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {

    $email    = mysqli_real_escape_string($conn, trim($_POST['signin_email']));
    $password = $_POST['signin_password'];       

    if (empty($email) || empty($password)) {
        $signinMessage     = "Please fill in all fields.";
        $signinMessageType = "error";

    } else {
        $sql    = "SELECT user_id, username, email, password FROM user WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $signinMessage     = "Database error: " . mysqli_error($conn);
            $signinMessageType = "error";

        } elseif (mysqli_num_rows($result) === 0) {
            $signinMessage     = "No account found with that email address.";
            $signinMessageType = "error";

        } else {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email']    = $user['email'];

                header("Location: auth.php");
                exit();

            } else {
                $signinMessage     = "Incorrect password. Please try again.";
                $signinMessageType = "error";
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
  <title>Sign In — EcoPickup</title>
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
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
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
      width: 100%; max-width: 860px; min-height: 480px;
      border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);
    }
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
      background: rgba(6, 32, 8, 0.38); z-index: 1;
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
    .form-panel {
      flex: 1 1 57%; background: var(--form-bg);
      display: flex; align-items: center; justify-content: center; padding: 56px 52px;
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
    .sub-text { font-size: 0.79rem; color: var(--text-muted); margin-bottom: 28px; text-align: center; }
    .input-group { margin-bottom: 14px; width: 100%; }
    .input-group label { display: block; font-size: 0.76rem; font-weight: 500; color: var(--label-color); margin-bottom: 5px; }
    .input-group input {
      width: 100%; padding: 10px 14px; background: var(--input-bg);
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
      width: 100%; padding: 12px; background: var(--green-btn); color: #fff; border: none;
      border-radius: 8px; font-size: 0.91rem; font-family: 'DM Sans', sans-serif;
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
    .social-text { text-align: center; font-size: 0.77rem; color: var(--text-muted); margin-top: 16px; }
    .social-text span { color: var(--green-accent); font-weight: 600; cursor: pointer; }
    .social-text span:hover { text-decoration: underline; }
    @media (max-width: 680px) {
      .auth-container { flex-direction: column; max-width: 420px; min-height: auto; }
      .overlay-panel  { flex: none; min-height: 200px; border-radius: var(--radius) var(--radius) 0 0; }
      .form-panel     { flex: none; padding: 36px 28px; border-radius: 0 0 var(--radius) var(--radius); }
    }
  </style>
</head>
<body>

  <div class="auth-container">

    <div class="overlay-panel">
      <div class="overlay-content">
        <h3>Don't have an account?</h3>
        <p>Create your new account and start with us</p>
        <button class="ghost-btn" onclick="window.location.href='signup.php'">Sign up</button>
      </div>
    </div>

    <div class="form-panel">
      <div class="form-box">
        <div class="dot-icon"></div>
        <h2>Welcome back!</h2>
        <p class="sub-text">Sign in to continue your eco journey</p>

        <form method="POST" action="" id="signinForm">
          <div class="input-group">
            <label for="signin-email">Email</label>
            <input type="email" id="signin-email" name="signin_email"
                   value="<?php echo isset($_POST['signin_email']) ? htmlspecialchars($_POST['signin_email']) : ''; ?>"
                   autocomplete="email" required />
          </div>
          <div class="input-group">
            <label for="signin-password">Password</label>
            <div class="password-wrap">
              <input type="password" id="signin-password" name="signin_password"
                     autocomplete="current-password" required />
              <button type="button" class="toggle-password" data-target="signin-password">Hide</button>
            </div>
          </div>

          <button type="submit" name="signin" class="main-btn" id="signinBtn">Sign in</button>

          <?php if ($signinMessage): ?>
            <p class="form-message <?php echo htmlspecialchars($signinMessageType); ?>">
              <?php echo htmlspecialchars($signinMessage); ?>
            </p>
          <?php endif; ?>

          <p class="social-text">Or, continue with <span>Google</span> or <span>Facebook</span></p>
        </form>
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
    document.getElementById('signinForm').addEventListener('submit', function () {
      const btn = document.getElementById('signinBtn');
      btn.textContent = 'Signing in…';
      btn.classList.add('loading');
    });
  </script>

</body>
</html>