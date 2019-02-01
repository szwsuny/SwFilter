<?php
/**
* @file filter.php
* @brief 过滤
* @author sunzhiwei
* @version 1.1
* @date 2019-02-01
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\SW\Filter\SwFilter;

$swFilter = new SwFilter();
$swFilter->setScope('短信类');

$result = $swFilter->filter('这里是过滤的内容，内容可以随便写，可以过滤英文和中文，效率中等，不如c快，但是胜在简单方便可以更改代码进行快速调整，这里面我添加几个sex短信类的敏感词孙志伟司法鉴定所框架胜多负少的爱迪生','*');

var_dump($result);
