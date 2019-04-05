<?php
require __DIR__ . "/vendor/autoload.php";
$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, consectetur ea fuga harum omnis quam? Culpa doloremque impedit ipsam laudantium nisi odio officia perspiciatis, provident quia reprehenderit tempora tempore veritatis.';

$keyword_builder = new App\Lib\KeywordBuilder($text,1);
$keywords = $keyword_builder->searchInDomain('https://github.com');
/*$href_adder = new \App\Lib\KeywordHrefAdder($keywords);
$href_adder->hrefAdder(['ucwords']);*/

$add_in_text = new \App\Lib\KeywordAddInText($keywords,$text);
echo $add_in_text->keywordAdder();
?>
