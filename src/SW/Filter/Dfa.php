<?php
/**
* @file Dfa.php
* @brief DFA算法
* @author sunzhiwei
* @version 1.1
* @date 2019-02-01
 */

namespace SzwSuny\SW\Filter;

class Dfa
{

    public function getTree(array $words):array
    {
        $tree = [];
        foreach($words as $word)
        {
            $len = mb_strlen($word);
            $nowTree = &$tree;
            for($i = 0; $i < $len; $i++)
            {
                $char = mb_substr($word,$i,1);
                if(isset($nowTree[$char]))
                {
                    if($i == ($len - 1))
                    {
                        $nowTree[$char]['end'] = true;
                    }
                } else 
                {
                    $nowTree[$char]['end'] = ($i == ($len - 1));
                }

                $nowTree = &$nowTree[$char];
            }
        }

        return $tree;
    }

    public function search(string $content,array $tree):array
    {
        $len = mb_strlen($content);
        $nowTree = $tree;
        $result = [];
        $ref = '';

        for($i = 0; $i < $len; $i++)
        {
            $word = mb_substr($content,$i,1);
            $ref = $ref . $word;

            if(!isset($nowTree[$word]))
            {
                $nowTree = $tree;
                $ref = '';
                continue;
            }

            if($nowTree[$word]['end'])
            {
                $result[] = $ref;
                $ref = '';
            }

            $nowTree = $nowTree[$word];
        }   

        return $result;
    }
}
