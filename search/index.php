<?php
  require_once(dirname(__DIR__).'/lib/dbconect.php');
  require_once(dirname(__DIR__).'/lib/var_dump2.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>DESIGN CHIPS | 検索結果</title>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/head.php'); ?>
</head>

<body>
<style>
  
</style>

<div class="wrapper">

  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/header.php'); ?>

  <main class="main">

    <section class="section">

      <form action="/design-chips/search/index.php" method="GET" class="search__form search-result__form">
        <div class="search__inner">
          <input type="search" name="query" class="search__input"/>
          <button class="search__button">検索</button>
        </div>
      </form>
      
      <?php
        // ユーザーからの検索クエリを取得
        $search_query = $_GET['query'];

        if($search_query){
          // クエリを作成して実行
          $stmt = $db->prepare("SELECT * FROM `design-chips` WHERE `content` LIKE '%$search_query%' AND `secret` != '1' ORDER BY `design-chips`.`timestamp` DESC");
          if(!$stmt):
            die($db->error);
          endif;
          $ret = $stmt->execute();
          if($ret){

            // 結果を取得
            $result = $stmt->get_result();

            echo '<div class="section-module">
              <h2 class="section-module__header search-result__header">
                『'.$search_query.'』の検索結果 - '.$result->num_rows.'件
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
            </div>';
      ?>

      <div class="list-wrapper card-list">

      <?php
        // 検索結果を表示
        // $resultに結果が格納されるので、それを確認します
        if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '<div class="list-item">
                <a href="'.$row['url'].'" class="list-item__thumb">
                  <img src="'.$row['img'].'" alt="'.$row['title'].'" width="75" class="list-item__image" loding="lazy"/>
                </a>
                <div class="list-item__body">
                  <a href="'.$row['url'].'">
                    <h3 class="list-item__title">'.$row['title'].'</h3>
                  </a>
                  <div class="list-item__meta">
                    <span class="date">'.$row['timestamp'].'</span>
                    <span class="list-item__category">'.$row['category'].'</span>
                  </div>
                </div>
              </div>';
              }
            } else {
              echo '<p class="no-result">検索結果がありません。</p>';
            }
          } else {
            echo $db->error;
          }

          // データベース接続を閉じる
          $stmt->close();
        }
      ?>

    </div>     

    </section>

  </main>

  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/design-chips/parts/footer.php'); ?>

</div>

</body>
</html>