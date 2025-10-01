<?php require_once __DIR__ . '/config.php'; $pdo = db(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelly Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg">
  <header class="nav">
    <div class="brand"><img src="assets/logo.png" class="logo"><span class="brand-name">Shelly</span></div>
    <nav><a href="index.php">Home</a><a href="search.php">Search</a><a class="active" href="login.php">Login</a></nav>
  </header>

  <main class="center">
    <h2>Login</h2>
    <div class="card">
      <form method="POST">
        <label>Username <input name="username" required></label>
        <label>Password <input name="password" type="password" required></label>
        <button class="btn" type="submit">Sign in</button>
      </form>
      <p class="muted">Tip: admin / admin or student / test (but that’s not the only way in).</p>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // INTENTIONAL SQLi (no prepared statements)
          $u = $_POST['username'] ?? '';
          $p = $_POST['password'] ?? '';
          $sql = "SELECT * FROM users WHERE username = '$u' AND password = '".md5($p)."'";
          // HINT: try classic `' OR '1'='1` style injections
          try {
              $stmt = $pdo->query($sql);
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($row) {
                  // weak "session" via cookies
                  setcookie('user', $row['username']);
                  setcookie('role', $row['role']);
                  echo "<div class='well success'>Welcome, ".htmlspecialchars($row['username'])."!</div>";
                  if ($row['role'] === 'admin') {
                      echo "<div class='flag'>FLAG: ".FLAG_SQLI."</div>";
                  }
                  echo "<p><a class='btn' href='admin.php'>Go to Admin</a></p>";
              } else {
                  echo "<div class='well error'>Invalid credentials.</div>";
              }
          } catch (Exception $e) {
              echo "<div class='well error'>SQL error occurred.</div>";
          }
      }
      ?>
    </div>
  </main>
</body>
</html>
