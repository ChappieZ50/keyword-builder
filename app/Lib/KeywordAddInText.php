<?php


namespace App\Lib;
class KeywordAddInText
{
    protected $keywords = [];
    protected $content = [];
    protected $result = [];

    public function __construct($keywords, $text,$result = 3)
    {
        $this->keywords = $keywords;
        $this->content = $text;
        $this->result = $result;
    }

    public function keywordAdder()
    {
        $content = $this->content;
        $hrefAdder = new KeywordHrefAdder($this->keywords);
        $data = $hrefAdder->hrefAdder();
        $i = 0;
        $results = '';
        $a = 0;
        while ($i < count($data['tag'])) {
            $text = $data['text'][$i];
            $tag = $data['tag'][$i];
            //echo $text."<br>";
            if($results = str_replace($text, $tag, $i == 0 ? $content : $results)){
                $a++;
                if($a >= $this->result)
                    break;
            }
            $i++;
        }
        return $results;
    }
}