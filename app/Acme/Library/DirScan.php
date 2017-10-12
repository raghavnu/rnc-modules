<?php

namespace Acme\Library {

    class DirScan
    {
        public static function dirList($dir)
        {
            $file_list = array();
            $stack[] = $dir;

            while ($stack) {
                $current_dir = array_pop($stack);
                if (is_dir($current_dir)) {
                    if ($dh = opendir($current_dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file !== '.' AND $file !== '..') {
                                $current_file = "{$current_dir}/{$file}";
                                $report = array();
                                if (is_file($current_file)) {
                                    $file_list[] = "{$current_dir}/{$file}";
                                } elseif (is_dir($current_file)) {
                                    $stack[] = $current_file;
                                    $file_list[] = "{$current_dir}/{$file}/";
                                }
                            }
                        }
                    }
                }
            }

            return $file_list;
        }

        public static function fileList($directories, $fileName = '')
        {
            foreach ($directories as $directory) {
                foreach (self::dirList($directory) as $file) {
                    $ext = pathinfo($file);
                    if ($fileName != '' and $fileName === $ext['filename']) {
                        require_once $file;
                    } elseif ($fileName == '') {
                        if (is_file($file) && in_array($ext['extension'], array('php'))) {
                            require_once $file;
                        }
                    }
                }
            }
        }

    }
}
