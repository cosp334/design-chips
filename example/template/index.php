<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/design-chips/lib/archive.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width">
  <title>DESIGN CHIPS | <?php echo $info['title']; ?></title>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/head.php'; ?>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/archive-head.php'; ?>
</head>
<body>
<div class="wrapper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/header.php'; ?>
	
  <main class="main">
    <section class="section">
      <div class="section__inner archive">
        <?php echo $html ?>
      </div>
    </section>
  </main>
	
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/footer.php'; ?>
	
</div>
</body>
</html>