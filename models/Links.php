<?php
declare(strict_types = 1);
namespace models;

use core\BaseProvider;

class Links extends BaseProvider
{
    const NONCHECKED_STATUS = 0;
    const APPROVED_STATUS = 1;

    public static function getTable(): string
    {
        return 'link_links';
    }

    public function create(string $link, int $file_id)
    {
        $table = self::getTable();
        $query = "INSERT INTO $table (link, file_id) VALUES (:link, :file_id)";
        $result = self::getDb()->prepare($query);
        $result->execute(["link" => strip_tags($link), "file_id" => $file_id]);
    }

    public static function getAll(): array
    {
        $table = self::getTable();
        $files_table = Files::getTable();
        $query = "SELECT (@row_number:=@row_number + 1) AS num, l.link, f.path AS filepath FROM $table l LEFT JOIN $files_table f ON f.id = l.file_id, (SELECT @row_number:=0) AS t WHERE           l.status = :status";
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute(["status" => self::NONCHECKED_STATUS]);

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function toTable(array $array): string
    {
        $body = "<div style='max-width: 100%;'><table border='1' bordercolor='black' cellspacing='0' style='max-width: 100%;table-layout: fixed;'><tr>";
        $labels = ["num" => "№", "filepath" => "Файл", "link" => "Ссылка"];
        $keys = array_keys($labels);

        foreach ($labels as $label) {
            $body .="<th style='max-width: 600px;word-wrap: break-word;'>$label</th>";
        }

        $body .= "</tr>";

        foreach ($array as $item) {
            $body .= "<tr>";

            foreach ($keys as $key) {
                $body .= "<td style='max-width: 600px;word-wrap: break-word;'>$item[$key]</td>";
            }

            $body .= "</tr>";
        }

        $body .= "</table></div>";

        return $body;
    }

}