<?php
declare(strict_types = 1);
namespace models;

class Scanner
{

    public function scanDirectories()
    {
        $directories = new Directories();
        $files = new Files();
        $base_directories = Directories::getByStatus(Directories::NONCHECKED_STATUS);
        $project = Projects::getOne();

        foreach ($base_directories as $base_dir) {
            $dir = iconv ("utf-8", "cp1251", $base_dir["path"]);
            $cdir = array_diff(scandir($dir), array('..', '.'));

            foreach ($cdir as $value) {
                $path = mb_convert_encoding($dir . DIRECTORY_SEPARATOR . $value, "utf-8", "cp1251");

                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    if (!Directories::findByPath($path, $project["id"])){
                        $directories->create($path, Directories::NONCHECKED_STATUS, (int)$project["id"]);
                    }
                } else {
                    if (!Files::findByPath($path)) {
                        $file_extension = strtolower(self::getExtension($path));

                        if (in_array($file_extension, $files->allowed_extensions))
                        $files->create($path, Files::NONCHECKED_STATUS, (int)$base_dir["id"]);
                    }
                }
            }

            $directories->setStatus((int)$base_dir["id"], Directories::CHECKED_STATUS);
        }
    }

    public function scanFiles()
    {
        $files = new Files();
        $links = new Links();
        $base_files = Files::getByStatus(Files::NONCHECKED_STATUS);

        foreach ($base_files as $base_file) {
            $content_links = PageParser::getLinks($base_file["path"]);

            if (count($content_links) > 0) {
                foreach ($content_links as $link) {
                    $links->create($link, (int)$base_file["id"]);
                }
            }

            $files->setStatus((int)$base_file["id"], Files::CHECKED_STATUS);
        }
    }


    public static function getExtension(string $filename): string
    {
        return end(explode(".", $filename));
    }

}