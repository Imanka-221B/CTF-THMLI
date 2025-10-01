<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8" />
  <title>Page not found - Shelly..</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="style.css" rel="stylesheet" />
  <script defer src="main.js"></script>
</head>
<body class="bg">
  <header class="nav">
    <div class="brand">
      <img src="assets/logo.png" alt="Shelly" class="logo" />
      <span class="brand-name">Shelly</span>
    </div>
    <nav>
      <a href="index.php">Home</a>
      <a href="search.php">Search</a>
      <a href="login.php">Login</a>
      <a href="upload.php">Upload</a>
      <a href="profile.php">Profiles</a>
      <a href="admin.php">Admin</a>
    </nav>
  </header>

  <main class="center">
    <h2 class="oops">Oops!</h2>
    <h1 class="title">The page does not exist</h1>
    <p class="hint">
      Maybe try our <a href="search.php">search</a>, log in, or return to the <a href="index.php">home page</a>.
    </p>
    <a class="btn" href="index.php#">Go To Home</a>

    <section class="card grid-2 mt-xl">
      <div>
        <h3>What happened?</h3>
        <p>This is our custom 404 template while the site is being rebuilt for an upcoming event.</p>
        <p class="muted">Dev note: remove debug banner before production.</p>
      </div>
      <div class="well">
        <?php if (isset($_GET['debug'])): // Broken Access Control (debug gate) ?>
          <strong>Debug:</strong> You toggled a hidden developer switch.
          <pre>$_SERVER['HTTP_USER_AGENT'] = <?= htmlspecialchars($_SERVER['HTTP_USER_AGENT']) ?></pre>
          <p><em>(This is a hint toward other features.)</em></p>
        <?php else: ?>
          <p class="muted">Psst… sometimes developers leave clues behind.</p>
        <?php endif; ?>
      </div>
    </section>

    <footer class="social">
      <a href="#" aria-label="Facebook" class="chip">Facebook</a>
      <a href="#" aria-label="LinkedIn" class="chip">LinkedIn</a>
      <a href="#" aria-label="Instagram" class="chip">Instagram</a>
    </footer>
  </main>
</body>
</html>
