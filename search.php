<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelly Search</title>
  <link rel="stylesheet" href="style.css">
  <script>
    // For demo: non-essential JS that may be abused by XSS
    document.addEventListener('DOMContentLoaded', () => {
      const q = new URLSearchParams(location.search).get('q') || '';
      if (q.toLowerCase().includes('flagplease')) {
        // Intentionally silly helper to hint users to inject script
        console.log('Try a script payload 😉');
      }
    });
  </script>
</head>
<body class="bg">
<header class="nav">
  <div class="brand"><img src="assets/logo.png" class="logo"><span class="brand-name">Shelly</span></div>
  <nav><a href="index.php">Home</a><a class="active" href="search.php">Search</a><a href="login.php">Login</a></nav>
</header>

<main class="center">
  <h2>Site Search</h2>
  <div class="card">
    <form method="GET">
      <label>Query <input name="q" value="<?= isset($_GET['q'])?htmlspecialchars($_GET['q']):'' ?>"></label>
      <button class="btn">Search</button>
    </form>
    <div class="divider"></div>
    <h3>Results</h3>
    <div class="well">
      <?php
      // INTENTIONAL reflected XSS: echoing unsanitized "q" inside HTML
      if (isset($_GET['q'])) {
          $q = $_GET['q'];
          // This line is intentionally unsafe:
          echo "<p>Nothing found for: <strong>$q</strong></p>";
          // If the user injects a <script>, it runs and should reveal a flag:
          echo "<!-- If your script runs, it will write the flag below. -->";
          echo "<div id='xss-flag'></div>";
          echo "<script>
            if (typeof window !== 'undefined') {
              // Only present when JS executes (i.e., XSS succeeded)
              document.getElementById('xss-flag').innerText = 'FLAG: ".FLAG_XSS."';
            }
          </script>";
      } else {
          echo "<p class='muted'>Try something like <code>&lt;script&gt;alert(1)&lt;/script&gt;</code></p>";
      }
      ?>
    </div>
  </div>
</main>
</body>
</html>
