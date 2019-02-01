<?php
/**
* @file add.php
* @brief 添加词汇
* @author sunzhiwei
* @version 1.1
* @date 2019-02-01
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\SW\Filter\SwFilter;

$swFilter = new SwFilter();

$swFilter->setScope('短信类');

$swFilter->add('孙志伟');
$swFilter->add('没事');
$swFilter->add('sex');

$swFilter->save();
