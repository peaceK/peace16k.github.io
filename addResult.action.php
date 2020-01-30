<?php
$uri = parse_url($_SERVER['REQUEST_URI']);
$query = $uri['query'];
parse_str($query, $parr);
$testId = $parr['testId'];
$fh = fopen("/tmp/".$testId, 'a+');
if ($fh) {
    fwrite($fh, $query."\n");
    fclose($fh);
    echo "OK";
} else
    echo "FAIL";
?>
