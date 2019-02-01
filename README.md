# SwFilter - 敏感词过滤 - 关键词取出
Sensitive Word Filtering
------
这是一个PHP版本的DFA算法实现，没有啥目的性，就是看到其他语言的实现特别多就做了一个，很简单。
关键词树被缓存在Scope文件夹下，使用前先要建立这个缓存文档。

------
### 依赖

    * PHP >= 7

------
### 效率

在test文件下 add.php 有6000个敏感词汇，你可以直接执行，然后执行 filter.php 平均效率在 0.01秒。(macbook pro i5)

------

### 使用方式

    * 可以参考test目录
    * 过滤/查找 前要先添加关键词缓存。

引入项目

    require __DIR__ . '/../vendor/autoload.php'; //注意调整所在目录位置

    use SzwSuny\SW\Filter\SwFilter;

声明对象

    $swFilter = new SwFilter();

设定范围

    $swFilter->setScope('短信类'); //你可以理解为词库的分类，这样你可拥有多个过滤词库，想用哪个用哪个。

添加词

    $swFilter->adds($words); //这个批量添加，$words是个词数组
    $swFilter->add($word);   //这个就是一个一个加。

保存词库

    $swFilter->save(); //添加词完事后一定要保存，才可以使用。

获得匹配到的词

    $swFilter->getMatchWords('这个是要匹配的内容或者文章'); //返回匹配到的词数组

过滤掉匹配的词

    $result = $swFilter->filter('这个是要匹配的内容或者文章','*'); //最后这个 * 符号，敏感词将会被替换成它，3个字就是 *** 2个字就是 **

### 版本号说明

    xx.xx.0 最后一位为0是正式版
    xx.xx.1-99 这种属于测试版本

------
### 更新

    2019年02月1日 1.1.0
        发布正式版本

sunzhiwei
2019-2-1
