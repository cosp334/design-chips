<?php
/*
* var_dump 整形出力
* 2020,1/26 shimoji
*/

function var_dump2($var) {
    echo '<pre style="line-height:1.5;white-space:pre; font-family: monospace; font-size:12px; border:3px double #BED8E0; margin:8px;"><code>';
    var_dump($var);
    echo '</code></pre>';
    echo '<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css"/>';
    echo '<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>';
    echo '<script>hljs.initHighlightingOnLoad();</script>';
}

?>