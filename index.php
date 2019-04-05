<?php
require __DIR__ . "/vendor/autoload.php";
$text = 'Merhaba benim adım uğur. 18 Yaşımdayım, yakında 19 olacağım. Bu uygulamayı can sıkıntısından yapıyorum.asdasd asdasdasdas asdasd asd asd';

$keyword_builder = new App\Lib\KeywordBuilder($text,1);
$keywords = $keyword_builder->searchInDomain('https://github.com');
/*$href_adder = new \App\Lib\KeywordHrefAdder($keywords);
$href_adder->hrefAdder(['ucwords']);*/

$add_in_text = new \App\Lib\KeywordAddInText($keywords,$text);
echo $add_in_text->keywordAdder();