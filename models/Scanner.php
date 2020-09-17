<?php
declare(strict_types = 1);
namespace models;

class Scanner
{

    public function scanDirectories()
    {
        $directories = new Directories();
        $files = new Files();
        $project = Projects::getOne();
        $base_directories = Directories::getByStatus(Directories::NONCHECKED_STATUS, (int)$project["id"]);

        foreach ($base_directories as $base_dir) {
            $dir = iconv ("utf-8", "cp1251", $base_dir["path"]);
            $cdir = array_diff(scandir($dir), array('..', '.'));

            foreach ($cdir as $value) {
                $path = mb_convert_encoding($dir . DIRECTORY_SEPARATOR . $value, "utf-8", "cp1251");

                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    if (!Directories::findByPath($path, (int)$project["id"])){
                        $directories->create($path, Directories::NONCHECKED_STATUS, (int)$project["id"]);
                    }
                } else {
                    if (!Files::findByPath($path)) {
                        $file_extension = strtolower(Files::getExtension($path));

                        if (in_array($file_extension, $files->allowed_extensions))
                        $files->create($path, Files::NONCHECKED_STATUS, (int)$base_dir["id"]);
                    }
                }
            }

            $directories->setStatus((int)$base_dir["id"], Directories::CHECKED_STATUS);
        }
    }

    public function scanFiles(array $base_files, int $status, bool $is_repeat = false)
    {
        $files = new Files();
        $links = new Links();

        foreach ($base_files as $base_file) {
            $content_links = PageParser::getLinks($base_file["path"]);

            if (count($content_links) > 0) {
                foreach ($content_links as $link) {
                    if (in_array($link, Exceptions::getByProjectId((int)$base_file["project_id"]))) {
                        continue;
                    }

                    if ($is_repeat && Links::findByFileIdAndLinkAndStatus((int)$base_file["id"], $link, Links::NONCHECKED_STATUS)) {
                        continue;
                    }

                    $links->create($link, (int)$base_file["id"]);
                }
            } else {
                $status = Files::PROCESSED_STATUS;
            }

            $files->setStatus((int)$base_file["id"], $status);
        }
    }

    public function primaryScanFiles()
    {
        $base_files = Files::getByStatus(Files::NONCHECKED_STATUS);
        $this->scanFiles($base_files, Files::CHECKED_STATUS, false);
    }

    public function reScanFiles()
    {
        $base_files = Files::getByStatus(Files::CHECKED_STATUS);
        $this->scanFiles($base_files, Files::CLEANED_STATUS, true);
    }

    public function cleanLinks()
    {
        $base_files = Files::getForATagReplace();
        $links = new Links();

        foreach ($base_files as $base_file) {
            $file_new_content = PageParser::replaceATags($base_file["path"], $base_file["charset"]);
            file_put_contents($base_file["path"], $file_new_content);
            $nonchecked_links = Links::findByFileIdAndStatus((int)$base_file["id"], Links::NONCHECKED_STATUS);

            foreach ($nonchecked_links as $link) {
                if (!PageParser::searchInContent($file_new_content, $link["link"]))
                {
                    $links->setStatus((int)$link["id"], Links::DELETED_STATUS);
                }
            }

            $this->scanFiles([$base_file], Files::CLEANED_STATUS);
        }
    }



}