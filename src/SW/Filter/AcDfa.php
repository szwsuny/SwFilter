<?php
/**
 * @file AcDaf.php
 * @brief ac自动机 会增加空间消耗，以空间换时间。
 * @author sunzhiwei
 * @version 1.1.3
 * @date 2019-02-05
 */

namespace SzwSuny\SW\Filter;

class AcDfa
{
    /**
     * @brief 获得字典树 1.存储方便，fail保存为树key，而非指针，2.树叶保存整个字符串，以便于直接得到字符串。
     *
     * @param $words
     *
     * @return 
     */
    public function getTree(array $words):array
    {
        $tree = $this->getNewTree($words);

        foreach($tree as $char => &$firstNodes)
        {
            //第一层
            $firstNodes['fail'] = ''; 

            //其他
            $this->creatFail($char,'',$firstNodes,$tree,$tree);
        }

        return $tree;
    }

    public function search(string $content,array $tree):array
    {
        $len = mb_strlen($content);
        $nowTree = $tree;

        $result = [];
        for($i = 0; $i < $len; $i++)
        {
            $char = mb_substr($content,$i,1);

            if(!isset($nowTree[$char]))
            {
                if(isset($nowTree['fail']))
                {
                    $nowTree = $this->getFailTree($nowTree['fail'],$tree);
                } else 
                {
                    $nowTree = $tree;
                }
            }

            if($nowTree[$char]['end'])
            {
                $result[] = $nowTree[$char]['word'];
            } 

            $nowTree = $nowTree[$char];
        }

        return $result;
    }

    protected function getFailTree(string $word,array $tree):array
    {
        if(empty($word))
        {
            return $tree;
        }

        $len = mb_strlen($word);
        $result = $tree;
        for($i = 0; $i < $len; $i++)
        {
            $char = mb_substr($word,$i,1);
            if(!isset($result[$char]))
            {
                $result = $tree;
                break;
            }

            $result = $result[$char];
        }

        return $result;
    }

    protected function creatFail(string $char,string $prefix,array &$nodes,array $preTree,array $tree)
    {
        foreach($nodes as $char => &$node)
        {
            if(in_array($char,['end','fail']))
            {
                continue;
            }

            $nowTree = $tree;
            $nowPrefix = '';
            if(isset($preTree[$char]))
            {
                $nowPrefix = $prefix . $char;
                $nowTree = $preTree[$char];
            } else 
            {
                if(isset($tree[$char]))
                {
                    $nowPrefix = $char;
                    $nowTree = $tree[$char];
                } else 
                {
                    $nowPrefix = '';
                    $nowTree = $tree;
                }
            }

            if(is_array($node)){
                $node['fail'] = $nowPrefix;
                $this->creatFail($char,$nowPrefix,$node,$nowTree,$tree);
            }
        }
    }

    protected function getNewTree(array $words):array
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
                        $nowTree[$char]['word'] = $word;
                        $nowTree[$char]['end'] = true;
                    }
                } else 
                {

                    if($i == ($len - 1))
                    {
                        $nowTree[$char]['word'] = $word;
                        $nowTree[$char]['end'] = true;
                    } else
                    {
                        $nowTree[$char]['end'] = false;
                    }
                }

                $nowTree = &$nowTree[$char];
            }
        }

        return $tree;
    }
}