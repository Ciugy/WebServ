<?php
$items = array_filter(scandir(__DIR__), fn($x) =>
  $x[0] !== '.' &&
  is_dir(__DIR__ . "/" . $x) &&
  !in_array($x, ["vendor", "node_modules"])
);
sort($items);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>picasso.local</title>
  <link rel="stylesheet" href="CSS/site.css" />
</head>
<body>
<header class="topbar">
  <a class="brand" href="/">picasso.local</a>
  <nav class="nav">
    <?php foreach ($items as $d): ?>
      <a href="/<?= htmlspecialchars($d) ?>/"><?= htmlspecialchars($d) ?></a>
    <?php endforeach; ?>
  </nav>
</header>

<main class="wrap">
  <h1>Folders</h1>
  <section class="grid">
    <?php foreach ($items as $d): ?>
      <a class="card" href="/<?= htmlspecialchars($d) ?>/">
        <h2><?= htmlspecialchars($d) ?></h2>
        <p>Open folder</p>
      </a>
    <?php endforeach; ?>
  </section>
</main>
</body>
</html>
