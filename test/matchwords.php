<?php
/**
* @file matchwords.php
* @brief 获得匹配到的敏感词
* @author sunzhiwei
* @version 1.1
* @date 2019-02-01
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\SW\Filter\SwFilter;

$swFilter = new SwFilter();
$swFilter->setScope('短信类');

$result = $swFilter->getMatchWords('孙志向天歌伟大');

var_dump($result);
