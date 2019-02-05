<?php
/**
 * @file SwFilter.php
 * @brief 主要程序
 * @author sunzhiwei
 * @version 1.1
 * @date 2019-02-01
 */

namespace SzwSuny\SW\Filter;

use SzwSuny\SW\Filter\AcDfa;

class SwFilter
{

    /**
     * @brief 默认使用的域
     */
    private $scopeName = 'default';
    private $words = [];

    public function setScope(string $scope)
    {
        $this->scopeName = $scope;
    }


    /**
     * @brief 添加过滤词汇
     *
     * @param $word 词汇
     *
     * @return void 
     */
    public function add(string $word)
    {
        $this->words[] = $word;
    }

    /**
     * @brief 添加过滤词汇数组
     *
     * @param $words 词汇数组
     *
     * @return void 
     */
    public function adds(array $words)
    {
        $this->words = array_merge($this->words,$words);
    }


    /**
     * @brief 保存关键词库
     *
     * @return bool 
     */
    public function save():bool
    {
         // $dfa = new Dfa();
        $acDfa = new AcDfa();
        $tree = $acDfa->getTree($this->words);
        $filePath = $this->getFilePath();
        $write = serialize($tree);

        $result = file_put_contents($filePath,$write);

        return $result !== false;
    }


    /**
     * @brief 获得路径
     *
     * @return string
     */
    protected function getFilePath():string
    {
        return __DIR__ . '/Scope/' . md5($this->scopeName) . '.'  . Config::WORDS_SUFFIX;
    }

    /**
     * @brief 获得scope下的next
     *
     * @return array
     */
    protected function getTree():array
    {
        $filterPath = $this->getFilePath();

        if(!file_exists($filterPath))
        {
            return [];
        }

        $read = file_get_contents($filterPath);
        $result = unserialize($read);

        return $result;
    }

    /**
     * @brief 获得所有匹配的关键词
     *
     * @param $content 内容
     *
     * @return array
     */
    public function getMatchWords(string $content):array
    {
        $tree = $this->getTree();

        $dfa = new AcDfa();
        $result =$dfa->search($content,$tree);

        $result = array_keys(array_flip($result));
        return $result;
    }

    /**
        * @brief 重叠词匹配
        *
        * @param $content
        *
        * @return array
     */
    public function getOverMatch(string $content):array
    {
        $tree = $this->getTree();

        $dfa = new AcDfa();
        $result = $dfa->searchOver($content,$tree);

        $result = array_keys(array_flip($result));
        return $result;
    }
    
    /**
        * @brief 过滤掉敏感词 
        *
        * @param $content 要过滤的内容
        * @param $replace 替换成的字符，默认为空
        *
        * @return 
     */
    public function filter(string $content,string $replace = ''):string
    {
        $words = $this->getMatchWords($content);
        $replaceValue = [];
        foreach($words as $word)
        {
            $len = mb_strlen($word);
            $replaceValue[] = implode('',array_pad([],$len,$replace));
        }

        $result = str_replace($words,$replaceValue,$content);

        return $result;
    }
}
