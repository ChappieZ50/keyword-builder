<?php

namespace App\Lib;


class KeywordHrefAdder
{
    protected $keywords = [];

    public function __construct($keywords)
    {
        $this->keywords = $keywords;
    }

    public function hrefAdder($options = [])
    {
        $defaults = [
            'id'    => '',
            'class' => '',
            'type'  => ''

        ];
        $options = array_merge($defaults, $options);
        $results = [];
        $id = !empty($options['id']) ? "id='$options[id]'" : null;
        $class = !empty($options['class']) ? "class='$options[class]'" : null;
        foreach ($this->keywords as $keyword) {
            $word = $keyword['word'];
            $href = $keyword['href'];
            $word = $this->keywordEdit($options, $word);
            $results['tag'][] = "<a href='$href' $class $id>$word</a>";
            $results['text'][] = $word;
            $results['link'][] = $href;
        }
        return $results;
    }

    public function keywordEdit($options = [], $keyword = '')
    {
        if ($options['type'] == 'upper')
            $keyword = strtoupper($keyword);

        elseif ($options['type'] == 'ucfirst')
            $keyword = ucfirst($keyword);

        elseif ($options['type'] == 'ucwords')
            $keyword = ucwords($keyword);

        return $keyword;
    }
}

