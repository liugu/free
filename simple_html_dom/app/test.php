<?php
header("Content-type: text/html; charset=utf-8"); 
include_once('../simple_html_dom.php');

$html = file_get_html('http://www.tuicool.com/');

// find all link
$url_arr = array();
foreach($html->find('a') as $e){
    // echo $e->href . "\n";
    $href = $e->href;

	// if(strpos($href,'articles')){
	if(preg_match("/^\/articles\//",$href)){
		$url_arr[] = $href;
	}
} 

print_r($url_arr);


// $pageURL="http://www.tuicool.com/"; 
// $contents=_url($pageURL); 
// $html = new simple_html_dom($contents);
// // print_r($contents);
// $a = $html->find('a');
// // find all link
// foreach($a as $e) 
//     echo $e->href . '<br>';

	// print_r($a);
    // $file_path="text.txt";
    // // $content="hello,worldrn";
    // //将一个字符串写入文件  默认是【FILE_USE_INCLUDE_PATH 】"w+"重新写入
    // file_put_contents($file_path,$a,FILE_APPEND);
    // echo "OK";

    //写文件
    // $file_path="text.txt";
    // if(!file_exists($file_path)){
    //     echo "no exi";
    //     exit();
    // }
    // //"a+" 在文件后面追加  "w+"重新写入
    // $fp=fopen($file_path,"w+");
    // $con=json_encode($a);
    // fwrite($fp,$con);
    // echo "success";
    // fclose($fp);





















//curl获取页面
function _url($Date){ 
    $ch = curl_init(); 
    $timeout = 5; 
    curl_setopt ($ch, CURLOPT_URL, "$Date"); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
    $contents = curl_exec($ch); 
    curl_close($ch); 
    return $contents; 
} 