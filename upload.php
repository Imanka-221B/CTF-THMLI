<?php require_once __DIR__ . '/config.php'; $uploads = __DIR__ . '/uploads'; if(!is_dir($uploads)) mkdir($uploads); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelly Upload</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg">
<header class="nav">
  <div class="brand"><img src="assets/logo.png" class="logo"><span class="brand-name">Shelly</span></div>
  <nav><a href="index.php">Home</a><a href="search.php">Search</a><a class="active" href="upload.php">Upload</a></nav>
</header>

<main class="center">
  <h2>Event Poster Upload (Beta)</h2>
  <div class="card">
    <p>Accepted: <code>.png, .jpg</code> (client-side check only)</p>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="poster" required accept=".png,.jpg,image/png,image/jpeg">
      <button class="btn" type="submit">Upload</button>
    </form>
    <div class="divider"></div>
    <?php
    // INTENTIONAL VULN: trusts client-provided extension, weak checks, and saves to exec-enabled dir.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['poster'])) {
        $name = $_FILES['poster']['name'];
        $tmp  = $_FILES['poster']['tmp_name'];
        // Only a superficial extension check (bypass: double ext or spoofed content-type)
        if (!preg_match('/\.(png|jpg|jpeg)$/i', $name)) {
            echo "<div class='well error'>Invalid file type.</div>";
        } else {
            $target = $uploads . '/' . basename($name);
            if (move_uploaded_file($tmp, $target)) {
                echo "<div class='well success'>Uploaded to <a href='uploads/".rawurlencode(basename($name))."'>uploads/".htmlspecialchars(basename($name))."</a></div>";
                echo "<p class='muted'>Dev note: We should also verify MIME and strip PHP handlers.</p>";
            } else {
                echo "<div class='well error'>Upload failed.</div>";
            }
        }
    }
    ?>
    <details class="mt">
      <summary>Demo payload hint</summary>
      <p>Try uploading an image with embedded PHP or a double extension (e.g., <code>poster.php.jpg</code>) then request it directly. If the server executes it, it may print a flag.</p>
      <p>Example minimal PHP body you could place inside file: <code>&lt;?= 'FLAG: <?=FLAG_UPLOAD?>' ?&gt;</code> (remove spaces)</p>
    </details>
  </div>
</main>
</body>
</html>
