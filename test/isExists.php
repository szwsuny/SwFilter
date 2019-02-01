<?php
/**
* @file isExists.php
* @brief 是否存在敏感词
* @author sunzhiwei
* @version 1.1
* @date 2019-02-01
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\SW\Filter\SwFilter;

$swFilter = new SwFilter();
$swFilter->setScope('短信类');
$result = $swFilter->isExists('随便写几个字试试吧，测试这个sex东西是不是真的孙伟可以检查到在这个文本里面所以填充了很多无用的字符串。');

var_dump($result);
