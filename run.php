<?php

namespace spider;
define('CONFIGS', require 'config.php');
require 'Spider.php';
require 'Parser.php';
require 'SaveToDB.php';


$urls = Parser::pageParser();
foreach ($urls as $url) {
    echo "------即将爬取以下页面的微博数据------\n";
    echo "{$url}\n\n\n";
    $one_page_raw_data = Spider::requests($url);
    $one_page_list_arr = json_decode($one_page_raw_data, true)['data']['list'];
    foreach ($one_page_list_arr as $wb) {
        Parser::oneWbParser($wb);
        echo "------本条文博数据爬取完毕------\n\n\n";
    }
}
