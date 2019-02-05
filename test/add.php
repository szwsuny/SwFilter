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

$words = ['孙志伟','伟大','志向伟大','向天歌'];

$swFilter = new SwFilter();

$swFilter->setScope('短信类');

$swFilter->adds($words);

$swFilter->save();

var_dump(count($words));
