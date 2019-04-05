
# Keyword Builder
 
 

#### Nedir ?

Girilen yazının belirlenen sayıya göre kelimelerin diziye ayrılıp verilen url de tarama yaparak bulduğu linkleri,
yazıdaki değerler ile eşitler ve onları birer anahtar kelimeye çevirir.

#### Özellikler

 - Belirlenen sayıya göre sadece kelimeleri bir dizi halinde çekebilirsiniz.
 - Belirlenen sayıya göre anahtar kelimeye çevrilmiş kelimeleri çekebilirsiniz.
 
## Kullanımı
 ```php
 $ composer update
 
    $text = 'Örnek Cümle'
    require __DIR__.'/vendor/autoload.php';
    $keyword_builder = new App\Lib\KeywordBuilder($text);
    $keywords = $keyword_builder->searchInDomain('https://github.com');
    $add_in_text = new \App\Lib\KeywordAddInText($keywords,$text);
    /* Sonuç */ echo $add_in_text->keywordAdder();
 ```
##### Yakında youtuba bunu sıfırdan yapıp atıcam. Linki burada paylaşırım.
