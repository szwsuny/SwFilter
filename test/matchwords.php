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

$result = $swFilter->getMatchWords('这是一段信息或者文章sex内容或者其他的东西，如果携带有孙志伟其他关键词那么会对其内容进行测试，阿克苏江东父老卡萨丁荆防颗粒的撒娇辅导孙志伟老师打了卡飞机卢卡斯达',true);

var_dump($result);
