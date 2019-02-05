<?php
/**
* @file overMatch.php
* @brief 重叠匹配
* @author sunzhiwei
* @version 1.1.5
* @date 2019-02-05
 */


require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\SW\Filter\SwFilter;

$swFilter = new SwFilter();
$swFilter->setScope('短信类');

$result = $swFilter->getOverMatch('孙志伟');

var_dump($result);
