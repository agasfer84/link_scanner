<?php


class Scanner
{

    public function scanDirectories()
    {
        $directories = new Directories();
        $files = new Files();
        $projects = new Projects();
        $base_directories = $directories->getByStatus(Directories::NONCHECKED_STATUS);
        $project = $projects->getOne();

        foreach ($base_directories as $base_dir) {
            $dir = iconv ("utf-8", "cp1251", $base_dir["path"]);
            $cdir = array_diff(scandir($dir), array('..', '.'));

            foreach ($cdir as $value) {
                $path = mb_convert_encoding($dir . DIRECTORY_SEPARATOR . $value, "utf-8", "cp1251");

                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    if (!$directories->findByPath($path)){
                        $directories->create($path, Directories::NONCHECKED_STATUS, $project->id);
                    }
                } else {
                    if (!$files->findByPath($path)) {
                        $file_extension = strtolower($this->getExtension($path));

                        if (in_array($file_extension, $files->allowed_extensions))
                        $files->create($path, Files::NONCHECKED_STATUS, $base_dir->id);
                    }
                }

                $directories->setStatus($path, Directories::CHECKED_STATUS);
            }
        }
    }

    public function scanFiles()
    {
        $files = new Files();
        $links = new Links();
        $base_files = $files->getByStatus(Files::NONCHECKED_STATUS);

        foreach ($base_files as $base_file) {
            $content_links = self::getLinks($base_file["path"]);

            if (count($content_links) > 0) {
                foreach ($content_links as $link) {
                    $links->create($link, $base_file->id);
                }
            }

            $files->setStatus($base_file->id, Files::CHECKED_STATUS);
        }
    }

    public static function getLinks($file_path) {
        $file_path = iconv ("utf-8", "cp1251", $file_path);
        $content = file_get_contents($file_path);
        $pattern = '~[a-z]+://\S+~';

        if(preg_match_all($pattern, $content, $out))
        {
            return $out[0];
        }

        return [];
    }

    function getExtension($filename) {
        return end(explode(".", $filename));
    }



}