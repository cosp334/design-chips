<?php
ini_set("display_errors", "On");

//info.jsonの読み込み
$url = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']).'/data/info.json';
$info = file_get_contents($url);
$info = mb_convert_encoding($info,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$info = json_decode($info, true);

// PHPMarkdownの読み込み
require_once("vendor/MarkdownExtra.inc.php");
use Michelf\MarkdownExtra;

//prism.jsに対応させるためにクラスを付与
function markdownToHtml($content){
  $markdown = new MarkdownExtra();
  $markdown->code_class_prefix = 'language-';
  return $markdown->transform($content);
}

// マークダウンファイルの中身
$url = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']).'/data/data.md';
$text = file_get_contents($url);
$text = mb_convert_encoding($text,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

// PHPMarkdownでHTMLへ変換
$html = markdownToHtml($text);

?>