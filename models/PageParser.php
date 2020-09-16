<?php
declare(strict_types = 1);

namespace models;

use DOMDocument;
use DOMElement;


class PageParser
{

    public static function replaceATags(string $file_path, string $charset = 'cp1251') :string
    {
        $doc = new DomDocument();
        //отключаем ошибки
        libxml_use_internal_errors(true);
        // Нужно проверить документ перед тем как ссылаться по идентификатору
        $doc->validateOnParse = true;
        $content = file_get_contents($file_path);
        $html = mb_convert_encoding($content, 'HTML-ENTITIES', $charset);
        $doc->loadHTML($html);
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
}