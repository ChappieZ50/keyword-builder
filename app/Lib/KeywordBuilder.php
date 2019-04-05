<?php

namespace App\Lib;

class KeywordBuilder
{
    // Yazımız için tanım.
    protected $text;
    // Derinlik anlamına geliyor. Yazı, diziye çevrildiğinde kaç adet kelime alınacağını belirtir.
    protected $depth;
    // Dizimiz için tanım.
    protected $array = [];
    // Minimum karakter uzunluğu
    protected $minLength = 2;
    // Derinliğe göre dizi
    protected $arrayByDepth = [];
    // Kaç adet anahtar kelime olacağını belirliyoruz
    protected $maxKeyword = 10;
    // Sonuçlar
    protected $results = [];

    /**
     * KeywordBuilder constructor.
     * @param $text
     * @param int $depth
     */
    public function __construct($text, $depth = 3)
    {
        $this->depth = $depth <= 0 ? 3 : $depth;
        $this->text = $text;
    }

    /**
     * "-" tire ile gelen yazı diziye dönüştürülüyor ve minimum uzunluğa göre dizideki kelimeler
     * yeniden ekleniyor ve array_values , array_filter ile düzenleniyor.
     * array_filter dizideki boş yerleri temizler.
     * array_values dizideki sıralanışı düzenler
     * @return $this
     */
    private function toArray()
    {
        $this->cleanChars();
        $words = explode(' ', $this->text);
        foreach ($words as $word) {
            $this->array[] = strlen($word) <= $this->minLength ? null : $word;
        }
        $this->array = array_values(array_filter($this->array));
        return $this;
    }

    /**
     * Bu metot ",","." gibi karakterleri silip bir sef linke dönüştürüyor
     */
    private function cleanChars()
    {
        $this->text = permalink($this->text, ['lowercase' => false, 'delimiter' => ' ', 'others' => false, 'turkish' => false]);
    }

    /**
     * Verilen başlangıç değerine göre başlayıp derinliğe göre kelimeleri dizi şeklinde dönderiyor.
     * Örnek: başlangıç 0 derinlik 3 dönen değer ilk 3 kelime
     * Örnek: başlangıç 3 derinlik 3 dönen değer 3 ten sonraki ilk 3 kelime
     * @param int $start
     * @return $this
     */
    public function getByDepth($start = 0)
    {
        $depth = 0;
        $data = [];
        foreach ($this->array as $key => $word) {
            if ($key >= $start && $this->depth > $depth) {
                $data[] = $word;
                $depth++;
            }
        }
        return $data;
    }

    public function searchInDomain($domain = 'https://github.com')
    {
        $this->toArray();
        $domain = $this->domainSlash($domain);
        for ($i = 0; $i < count($this->array) / $this->depth; $i++) {
            $words = $this->getByDepth($i * $this->depth);
            foreach ($words as $word) {
                $implodeWords = implode(' ', $words);
                if (count($this->results) >= $this->maxKeyword)
                    break;
                $check = $domain . permalink($implodeWords);
                if ($this->checkStatus($check))
                    $this->results[] = [
                        'href' => $check,
                        'word' => $implodeWords
                    ];
                $deleteKey = $this->get_last_key($words);
                unset($words[$deleteKey]);
            }
        }
        return $this->results;
    }

    private function checkStatus($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $http_respond = curl_exec($ch);
        $http_respond = trim(strip_tags($http_respond));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (($http_code == "200") || ($http_code == "302"))
            return true;
        else
            return false;
    }

    private function domainSlash($domain)
    {
        $exp = explode('/', $domain);
        if (empty(end($exp)))
            return $domain;
        else
            return $domain . '/';
    }

    private function get_last_key($data)
    {
        $count = count($data);
        $keys = array_keys($data);
        return $keys[$count - 1];
    }
}