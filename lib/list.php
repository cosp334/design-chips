<?php

/*– 外部ファイル ———————–*/
require_once(dirname(__DIR__).'/lib/var_dump2.php'); //var_dump整形
require_once(dirname(__DIR__).'/lib/dbconect.php');

/*– 設定ファイルの呼び出し ———————–*/
$path =  dirname(__DIR__).'/setting/listSetting.json';
$setting = file_get_contents($path);
$setting = mb_convert_encoding($setting,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$setting = json_decode($setting,true);

/*– データベース名 ———————–*/
$dbName = 'design-chips';

$categories = [];
if (is_array($setting['category'])) {
	for($i = 0; $i < count($setting['category']); $i++){
    $categories[] = $setting['category'][$i];
	}
} else{
	$categories[0] = $setting['category'];
}

$src = [];
if (is_array($setting['src'])) {
	for($i = 0; $i < count($setting['src']); $i++){
    $src[] = $setting['src'][$i];
	}
} else{
	$src = $setting['src'];
}

$getElement = [];
for($i = 0; $i < count($setting['getElement']); $i++){
    $key = key(array_slice($setting['getElement'], $i, 1, true));
    $getElement[$key] = $setting['getElement'][$key];
}

$metaSrc = [];
if (is_array($setting["metaSrc"])) {
	for($i = 0; $i < count($setting["metaSrc"]); $i++){
    $metaSrc[] = $setting["metaSrc"][$i];
	}
} else{
	$metaSrc = $setting["metaSrc"];
}

$webComponent = [];
for($i = 0; $i < count($setting['webComponent']); $i++){
    $key = key(array_slice($setting['webComponent'], $i, 1, true));
    $webComponent[$key] = $setting['webComponent'][$key];
}

$default = [];
for($i = 0; $i < count($setting['default']); $i++){
    $key = key(array_slice($setting['default'], $i, 1, true));
    $default[$key] = $setting['default'][$key];
}

/*– ページ取得 ———————–*/
foreach($categories as $cat){

    // キャッシュを取得（キャッシュがない場合は取得して保存）
    $cacheFile = dirname(__DIR__).'/'.$cat.'/folder_cache.json';
    if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 3600) {
        // キャッシュが1時間以内に更新された場合はキャッシュを使用
        $folderList = json_decode(file_get_contents($cacheFile), true);
    } else {
        // キャッシュが古いか存在しない場合は新たにフォルダリストを取得
        $folderList = getFolderList($cat);
        
        // フォルダリストをキャッシュに保存
        file_put_contents($cacheFile, json_encode($folderList));
    }

    // 素材フォルダとテンプレートを除外する
    $folderList = array_diff($folderList, $webComponent);
    $folderList = array_values($folderList);

    // urlが登録されているか調べる
    for($i = 0;$i < count($folderList); $i++) {
        $path = dirname(__DIR__).'/'.$cat.'/'.$folderList[$i];
        $url = str_replace($_SERVER['DOCUMENT_ROOT'],'', $path);
        $stmt = $db->prepare("SELECT EXISTS (SELECT * FROM `$dbName` WHERE `url` = ?)");
        if(!$stmt):
            die($db->error);
        endif;
        $stmt->bind_param('s', $url);
        $ret = $stmt->execute();

        if($ret){
            // 結果を取得
            $stmt->bind_result($result);
            // 結果セットをフェッチ
            $stmt->fetch();

            // $resultに結果が格納されるので、それを確認します
            if(!$result){

               //記事のメタデータ取得
               $meta = [];
               $jsonPath = dirname(__DIR__).'/'.$cat.'/'.$folderList[$i].'/'.$metaSrc;
               $meta[$i] = file_get_contents($jsonPath);
               $meta[$i] = mb_convert_encoding($meta[$i],'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
               $meta[$i] = json_decode($meta[$i],true);

               // タイトル、URL、タイムスタンプ、カテゴリー、本文を変数に格納
               $title = $meta[$i]['title'];
               $date = $meta[$i]['date'];
               $content = file_get_contents(dirname(__DIR__).'/'.$cat.'/'.$folderList[$i].'/data/data.md');
               $tag = [];
               $tag[$i] = $meta[$i]['tag'];
               
               if (isset($meta[$i]['secret'])) {
                   $secret = $meta[$i]['secret'];
               }
               else {
                   $secret = $default['secret'];
               }
               
               //画像がimgフォルダーにない場合は指定しない
               if(file_exists($path.'/img/thumb.png')){
                   $img = $url.'/img/thumb.png';
               } else{
                   $img = '';
               }

               //新規記事の登録
               $stmt->close();
               $stmt = $db->prepare("INSERT INTO `$dbName` (title, `url`, `timestamp`, category, content, img, `secret`) VALUES (?, ?, ?, ?, ?, ?, ?)");
               if(!$stmt):
                   die($db->error);
               endif;
               $stmt->bind_param('sssssss', $title, $url, $date, $cat, $content, $img, $secret);
               $ret = $stmt->execute();
               if(!$ret):
                    echo $db->error;
               endif;
               $stmt->close();
            } else {
                // $stmtの実行前に結果セットを解放
                $stmt->free_result();
            }
        } else {
            echo $db->error;
        }

    }
        
    $index[$cat] = '/design-chips/'.$cat;

} //forach

// フォルダリストを取得する関数（同期的な処理）
function getFolderList($category) {
    $folderList = [];
    
    // カテゴリーフォルダ内のファイルの一覧を作成
    $categoryFolder = dirname(__DIR__).'/'.$category.'/';
    
    $subFolders = scandir($categoryFolder);
    foreach ($subFolders as $subFolder) {
        if (is_dir($categoryFolder . $subFolder) && $subFolder !== '.' && $subFolder !== '..') {
            $folderList[] = $subFolder;
        }
    }
    
    return $folderList;
}
?>