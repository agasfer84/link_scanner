<?php
namespace models;

use core\BaseProvider;

class Links extends BaseProvider
{
    public static function getTable()
    {
        return 'link_links';
    }

    public function create($link, $file_id)
    {
        $table = self::getTable();
        $query = "INSERT INTO $table (link, file_id) VALUES (:link, :file_id)";
        $result = self::getDb()->prepare($query);
        $result->execute(["link" => $link, "file_id" => $file_id]);
    }

    public static function getAll()
    {
        $table = self::getTable();
        $files_table = Files::getTable();
        $query = "SELECT (@row_number:=@row_number + 1) AS num, l.link, f.path AS filepath FROM $table l LEFT JOIN $files_table f ON f.id = l.file_id, (SELECT @row_number:=0) AS t";
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function toTable($array)
    {
        $body = "<table border='1' bordercolor='black' cellspacing='0'><tr>";
        $labels = ["num" => "№", "filepath" => "Файл", "link" => "Ссылка"];
        $keys = array_keys($labels);

        foreach ($labels as $label) {
            $body .="<th>$label</th>";
        }

        $body .= "</tr>";

        foreach ($array as $item) {
            $body .= "<tr>";

            foreach ($keys as $key) {
                $body .= "<td>$item[$key]</td>";
            }

            $body .= "</tr>";
        }

        $body .= "</table>";

        return $body;
    }

}