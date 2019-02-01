<?php
/**
 * @file Kmp.php
 * @brief 主要的算法
 * @author sunzhiwei
 * @version 1.1
 * @date 2019-02-01
 */

namespace SzwSuny\SW\Filter;

class Kmp
{

    /**
     * @brief 获得kmp算法的next
     *
     * @param $word 关键词
     *
     * @return array
     */
    public function getNext(string $word):array
    {
        $len = mb_strlen($word);
        $next[0] = -1;
        $k = -1;

        for($i = 1; $i <= $len-1; $i++)
        {
            while($k > -1 && mb_substr($word,$k+1,1) != mb_substr($word,$i,1))
            {
                $k = $next[$k];
            }

            if(mb_substr($word,$k+1,1) == mb_substr($word,$i,1))
            {
                $k = $k+1;
            }

            $next[$i] = $k;
        }

        return $next;
    }

    public function match(string $word,array $next,string $str):array
    {
        $k = -1; 
        $len = mb_strlen($str);
        $plen = mb_strlen($word);

        for($i = 0;$i < $len; $i++)
        {
            while($k > -1 && mb_substr($word,$k+1,1) != mb_substr($str,$i,1))
            {
                $k = $next[$k];
            }

            if(mb_substr($word,$k+1,1)== mb_substr($str,$i,1))
            {
                $k = $k + 1;
            }

            if($k == $plen - 1)
            {
                $start[] = $i - $plen + 1;
            }
        }

        if(empty($start))
        {
            return [];
        }

        return ['word'=>$word,'start'=>$start];
    }
}
