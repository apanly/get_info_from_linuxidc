<?php
include_once("functions.php");
$garr=array();
$url="http://linux.linuxidc.com/";
$body=httpget($url);
formatbody($body,"/",$garr);
var_dump($garr);
