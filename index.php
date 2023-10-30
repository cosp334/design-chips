<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/lib/list.php');
	$articleLimit = 6; //トップページに表示する件数
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>DESIGN CHIPS | トップページ</title>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/head.php'); ?>
</head>

<body>

<div class="wrapper">
	
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/header.php'); ?>
	
	<main class="main">

		<section class="section">
			<div class="section__inner">
				<div class="section-module">
					<h2 class="section-module__header">
						最新記事
					</h2>
					<ul class="list-format">
						<li>
							<button class="list-format__button view-grid">
								<span class="list-format__icon material-icons-round">
									grid_view
								</span>
							</button>
						</li>
						<li>
							<button class="list-format__button view-agenda">
								<span class="list-format__icon material-icons-round">
									view_agenda
								</span>
							</button>
						</li>
					</ul>
				</div>
				<div class="list-wrapper card-list">
					<?php
						//新規記事の登録
						$stmt = $db->prepare("SELECT * FROM `design-chips` WHERE `secret` != '1' ORDER BY `timestamp` DESC LIMIT ?");
						if(!$stmt):
							die($db->error);
						endif;
						$stmt->bind_param('i', $articleLimit);
						$ret = $stmt->execute();
						
						if($ret){
							// 結果を取得
							$result = $stmt->get_result();
							if ($result->num_rows > 0) {
									// データが取得できた場合
									while ($row = $result->fetch_assoc()) {
										// データを表示する部分
										echo '<div class="list-item">
										<a href="'.$row["url"].'" class="list-item__thumb">
											<img src="'.$row["img"].'" alt="'.$row["title"].'" width="75" class="list-item__image" loding="lazy"/>
										</a>
										<div class="list-item__body">
											<a href="'.$row["url"].'">
												<h3 class="list-item__title">'.$row["title"].'</h3>
											</a>
											<div class="list-item__meta">
												<span class="date">'.$row["timestamp"].'</span>
												<span class="list-item__category">'.$row["category"].'</span>
											</div>
										</div>
									</div>';
									}
							} else {
								echo "データが見つかりませんでした";
							}
						} else {
							echo $db->error;
						}

						$stmt->close();
					?>
				</div>
			</div>
		</section>
		
		<?php
			foreach ($categories as $cat) {
				echo '<section id="'.$cat.'" class="section">
					<div class="section__inner">
						<div class="section-module">
							<h2 class="section-module__header">'.
								$cat
							.'</h2>
							<ul class="list-format">
								<li>
									<button class="list-format__button view-grid">
										<span class="list-format__icon material-icons-round">
											grid_view
										</span>
									</button>
								</li>
								<li>
									<button class="list-format__button view-agenda">
										<span class="list-format__icon material-icons-round">
											view_agenda
										</span>
									</button>
								</li>
							</ul>
						</div>
						<div class="list-wrapper card-list">';

						//新規記事の登録
						
						$stmt = $db->prepare("SELECT * FROM `design-chips` WHERE `category` = '$cat' AND `secret` != '1' ORDER BY `timestamp` DESC LIMIT ?");
						if(!$stmt):
							die($db->error);
						endif;
						$stmt->bind_param('i', $articleLimit);
						$ret = $stmt->execute();
						
						if($ret){
							// 結果を取得
							$result = $stmt->get_result();
							if ($result->num_rows > 0) {
									// データが取得できた場合
									while ($row = $result->fetch_assoc()) {
										// データを表示する部分
										echo '<div class="list-item">
										<a href="'.$row["url"].'" class="list-item__thumb">
											<img src="'.$row["img"].'" alt="'.$row["title"].'" width="75" class="list-item__image" loding="lazy"/>
										</a>
										<div class="list-item__body">
											<a href="'.$row["url"].'">
												<h3 class="list-item__title">'.$row["title"].'</h3>
											</a>
											<div class="list-item__meta">
												<span class="date">'.$row["timestamp"].'</span>
												<span class="list-item__category">'.$row["category"].'</span>
											</div>
										</div>
									</div>';
									}
							} else {
								echo "データが見つかりませんでした";
							}
						} else {
							echo $db->error;
						}
						$stmt->close();

						echo '</div>
						<a href="'.$index[$cat].'" class="primary-button more-button">
							<span class="">MORE</span>
							<span class="material-icons-round primary-button__icon">
								chevron_right
							</span>
						</a>
					</div>
				</section>';
			}
		?>
	</main>
	
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/footer.php'); ?>
	 
</div>


</body>
</html>