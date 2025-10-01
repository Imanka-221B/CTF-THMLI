<?php require_once __DIR__ . '/config.php'; $pdo = db(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelly Profiles</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg">
<header class="nav">
  <div class="brand"><img src="assets/logo.png" class="logo"><span class="brand-name">Shelly</span></div>
  <nav><a href="index.php">Home</a><a href="search.php">Search</a><a href="profile.php">Profiles</a></nav>
</header>

<main class="center">
  <h2>User Profiles</h2>
  <div class="card">
    <?php
      // IDOR: no authorization check on ?id=
      $id = isset($_GET['id']) ? (int)$_GET['id'] : 2; // default to 'student' record
      $stmt = $pdo->query("SELECT id, username, role FROM users WHERE id = $id");
      $u = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($u):
    ?>
      <h3>@<?= htmlspecialchars($u['username']) ?></h3>
      <ul>
        <li>User ID: <?= (int)$u['id'] ?></li>
        <li>Role: <?= htmlspecialchars($u['role']) ?></li>
      </ul>
      <?php if ($u['id'] === 1): // Admin profile leaked via IDOR ?>
        <div class="flag">FLAG: <?= FLAG_IDOR ?></div>
        <!-- Admin internal note: reset 2FA after event. -->
      <?php else: ?>
        <p class="muted">Try another <code>?id=</code>…</p>
      <?php endif; ?>
    <?php else: ?>
      <p class="well error">Profile not found.</p>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
