<?php
header("Content-type: text/html; charset=utf-8");
function httpget($url){
    $user = 'www.linuxidc.com'; //用户名
    $pass = 'www.linuxidc.com'; //密码
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (!$response) {
        echo curl_error($ch);
    }
    return $response;
    curl_close($ch);
}

function formatbody($body,$ppath,&$garr){
    if(empty($body)){
        return;
    }
    preg_match("/<pre>(.*?)<\/pre>/is", $body, $matches);
    if($matches && $matches[1]){
        $tmp=explode("<br>",$matches[1]);
        foreach($tmp as $item){
            $type="file";
            if(stripos($item,"dir")>0){
                $type="dir";
            }else if (stripos($item,"To Parent Directory")){
                     continue;
            }
            preg_match("/<a\s*href=\"(.*?)\">(.*?)<\/a>/is", $item, $links);
            if(count($links)==3){
                $name=$links[2];
                $path=$links[1];
                $garr[$ppath][]=array(
                    "type"=>$type,
                    "filename"=>$name,
                    "path"=>$path
                );
            }
        }

    }
}