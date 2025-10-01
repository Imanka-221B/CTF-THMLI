<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelly Admin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg">
<header class="nav">
  <div class="brand"><img src="assets/logo.png" class="logo"><span class="brand-name">Shelly</span></div>
  <nav><a href="index.php">Home</a><a href="search.php">Search</a><a href="login.php">Login</a></nav>
</header>

<main class="center">
  <h2>Admin Dashboard</h2>
  <div class="card">
    <?php
    // Broken Access Control: trusts user-controlled 'role' cookie; also secret GET switch ?as=admin
    if (isset($_GET['as']) && $_GET['as'] === 'admin') {
        setcookie('role', 'admin');
        setcookie('user', 'debug-admin');
    }
    if (current_role() !== 'admin') {
        echo "<div class='well error'>Admins only. (role=".htmlspecialchars(current_role()).")</div>";
        echo "<p>Hint: sometimes cookies or query params influence roles…</p>";
        exit;
    }
    ?>
    <p>Welcome, <?= htmlspecialchars(current_user() ?: 'admin') ?>!</p>
    <ul>
      <li>Pending event forms: 3</li>
      <li>Mail queue: 1</li>
      <li>System: <span class="muted">dev-404</span></li>
    </ul>
    <div class="flag">FLAG: <?= FLAG_SQLI ?></div>
    <p class="muted">Note: This flag also appears if you reach admin via SQLi.</p>
  </div>
</main>
</body>
</html>
