<?php

namespace Sungmee\Hashid;

use Illuminate\Support\Helper;

class Hashid
{
    /**
     * 加密后字符串长度
     *
     * @var integer
     */
    private $length;

    /**
     * 加密盐值
     *
     * @var number
     */
    private $salt;

    /**
     * 字典 - a-z,A-Z,0-9 62个字符打乱后的字符串
     *
     * @var string
     */
    private $dictionary;

    /**
     * 标记 - 取前字典的 M(数字最大的位数)位作为标记长度字符串
     *
     * @var string
     */
    private $flag;

    /**
     * 替身 - 取字典的第 M+1 到第 M+10 位为数字替换字符串
     *
     * @var string
     */
    private $substitute;

    /**
     * 补缺 - 取字典取掉 $flag 和 $substitute 后剩下的字符串作为候补字符串
     *
     * @var string
     */
    private $alternate;

    /**
     * 构造一个 Hash ID 的 函数
     *
     * @date   2017/07/05 11:27:17
     * @param  integer  $length     加密后字符串长度
     * @param  number   $salt       加密盐值
     * @param  string   $dictionary a-z,A-Z,0-9 62个字符打乱后的字符串
     * @return void
     */
    public function __construct()
    {
        $config             = config('sungmee.hashid');
        $this->length       = $config ? $config['length'] : 8;
        $this->salt         = $config ? $config['salt'] : 3.14159265359;
        $this->dictionary   = $config ? $config['dictionary']
                : 'FH2h7v0VOL5NtZzaCnMwmUYsrykl81TiQEoDxI6feuAgdJGcj39BqRW4PpSKbX';
        $this->flag         = substr($this->dictionary, 0, $this->length);
        $this->substitute   = substr($this->dictionary, $this->length, 10);
        $this->alternate    = substr($this->dictionary, $this->length + 10);
    }

    /**
     * 加密 ID
     *
     * @date   2017/07/05 11:27:17
     * @param  integer $ids 需要加密的 ID 值
     * @return string
     */
    public function hash($ids)
    {
        if(!is_int($ids))
        {
            return false;
        }

        $hash       = '';
        $ids_length = strlen($ids);
        $first      = substr($this->flag, $ids_length - 1, 1);

        // 密文的补缺位
        $keys_length = $this->length - $ids_length - 1;
        $keys        = str_replace('.', '', $ids / $this->salt);
        $keys        = substr($keys, -$keys_length);
        $keys        = str_split($keys);
        $alternates  = str_split($this->alternate);
        foreach($keys as $key)
        {
            $hash .= $alternates[$key];
        }

        $keys       = str_split($ids);
        $substitute = str_split($this->substitute);
        foreach($keys as $key)
        {
            $hash  .= $substitute[$key];
        }

        return $first . $hash;
    }

    /**
     * 解密 ID
     *
     * @date   2017/07/05 11:27:17
     * @param  string $hash 需要解密的 Hash 值
     * @return integer
     */
    public function id($hash)
    {
        $ids       = '';
        $first     = substr($hash, 0, 1);
        $length    = strpos($this->flag, $first);

        if($length !== false)
        {
            $length++;
            $search = str_split(substr($hash, -$length));
            foreach($search as $s)
            {
                $ids .= strpos($this->substitute, $s);
            }
        }

        return ctype_digit($ids) ? (int) $ids : false;
    }

    /**
     * 获取字典字符串
     *
     * @date   2017/07/05 11:27:17
     * @return string
     */
    public function dictionary()
    {
        $dictionary = str_split(str_random(518));
        $dictionary = array_unique($dictionary);
        return join('', $dictionary);
    }
}