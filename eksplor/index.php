<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loginnn</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-wrapper">
    <form class="login-form" action="login.php" method="POST">
      <h2>Loginnn</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <?php if (isset($_GET['error'])): ?>
        <p class="error">Username atau password salah!</p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
