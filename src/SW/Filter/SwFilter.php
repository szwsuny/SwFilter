<?php
/**
 * @file SwFilter.php
 * @brief 主要程序
 * @author sunzhiwei
 * @version 1.1
 * @date 2019-02-01
 */

namespace SzwSuny\SW\Filter;

use SzwSuny\SW\Filter\Kmp;

class SwFilter
{

    /**
     * @brief 默认使用的域
     */
    private $scopeName = 'default';
    private $wordsNext = [];

    public function setScope(string $scope)
    {
        $this->scopeName = $scope;
    }


    /**
     * @brief 添加过滤词汇
     *
     * @param $word 词汇
     *
     * @return bool 
     */
    public function add(string $word):bool
    {
        $kmp = new Kmp();
        $next = $kmp->getNext($word);

        $this->wordsNext[] = ['word'=>$word,'next'=>$next];

        return true;
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
        foreach($words as $word)
        {
            $this->add($word);
        }
    }


    /**
     * @brief 保存关键词库
     *
     * @return bool 
     */
    public function save():bool
    {
        $filePath = $this->getFilePath();
        $write = json_encode($this->wordsNext);

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
    protected function getWordsNext():array
    {
        $filterPath = $this->getFilePath();

        if(!file_exists($filterPath))
        {
            return [];
        }

        $read = file_get_contents($filterPath);
        $result = json_decode($read,true);

        return $result;
    }

    /**
     * @brief 是否存在敏感词
     *
     * @param $content 要检查的内容,这个遇到匹配则会停止并返回结果，所以如果不需要详细信息就用这个
     *
     * @return bool
     */
    public function isExists(string $content):bool
    {
        $wordsNext = $this->getWordsNext();

        if(empty($wordsNext))
        {
            return false;
        }

        $kmp = new Kmp();

        $result = false;
        foreach($wordsNext as $words)
        {
            if(!empty($kmp->match($words['word'],$words['next'],$content)))
            {
                var_dump($words['word']);
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @brief 获得所有匹配的关键词
     *
     * @param $content 内容
     * @param $isLocation 是否带有位置信息
     *
     * @return array
     */
    public function getMatchWords(string $content,bool $isLocation = false):array
    {
        $wordsNext = $this->getWordsNext();
        $kmp = new Kmp();

        $result = [];
        foreach($wordsNext as $words)
        {
            $match = $kmp->match($words['word'],$words['next'],$content);
            if(empty($match))
            {
                continue;
            }

            if($isLocation === false)
            {
                $result[] = $words['word'];
            } else
            {
                $result[] = $match;
            }
        }

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
