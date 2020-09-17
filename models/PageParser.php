<?php
declare(strict_types = 1);

namespace models;

use DOMDocument;
use DOMElement;


class PageParser
{

    public static function replaceATags(string $file_path, string $charset = 'utf8')
    {
        $doc = new DomDocument('1.0', $charset);
        $doc->formatOutput = true;
        //отключаем ошибки
        libxml_use_internal_errors(true);
        // Нужно проверить документ перед тем как ссылаться по идентификатору
        $doc->validateOnParse = true;
        $content = file_get_contents($file_path);
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', $charset);

        //return $html;
        $doc->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset='. $charset . '">' . $content); //cirillic to ASCII bug
        $items = $doc->getElementsByTagName('a');

        while ($items->length) {
            $items->item(0)->parentNode->replaceChild(new \DOMText($items->item(0)->textContent), $items->item(0));
        }

        return $doc->saveHTML();
    }

    public static function getLinks(string $file_path): array
    {
        $file_path = iconv ("utf-8", "cp1251", $file_path);
        $content = file_get_contents($file_path);
        $pattern = '~[a-z]+://\S+~';

        if (preg_match_all($pattern, $content, $out))
        {
            return $out[0];
        }

        return [];
    }

    public static function searchInContent(string $content, string $find) :bool
    {
        $pos = strpos($content, $find);

        return !($pos === false);
    }
}