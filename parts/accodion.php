<?php
/*– 設定ファイルの呼び出し ———————–*/
$path =  dirname(__DIR__).'/setting/listSetting.json';
$setting = file_get_contents($path);
$setting = mb_convert_encoding($setting,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$setting = json_decode($setting,true);

$categories = [];
if (is_array($setting['category'])) {
	for($i = 0; $i < count($setting['category']); $i++){
    $categories[] = $setting['category'][$i];
	}
} else{
	$categories[0] = $setting['category'];
}
?>
<nav id="global-nav" class="global-nav">
  <ul class="global-nav__list">
    <?php
    foreach($categories as $cat){
      echo '<li class="global-nav__list-item"><a href="/design-chips/'.$cat.'">'.$cat.'</a></li>';
    }
    ?>
  </ul>
</nav>