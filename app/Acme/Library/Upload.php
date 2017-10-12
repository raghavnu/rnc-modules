<?php
namespace Acme\Library {

    class Upload
    {

        protected static $instance = null;

        // Upload Multiple And Single File
        public static function move($file_input, $image_path)
        {
            //CREATE DIRECTORY IF NOT EXISTS
            if (is_dir($image_path) == FALSE) {

                $status = mkdir($image_path, 0744, TRUE);

                if ($status < 1) {

                    throw New \Exception("Unable to make directory ['" . $image_path . "']. Please provide sufficient permission ");
                }
            }

            //MULTIPLE FILE UPLOAD
            if (is_array($file_input['tmp_name'])) {

                foreach ($file_input['tmp_name'] as $key => $tmp_name) {

                    $file_name = $file_input['name'][$key];
                    $file_tmp_name = $file_input['tmp_name'][$key];
                    $file_size = $file_input['size'][$key];

                    if ($file_size > 0) {

                        //RENAME WITH NEW DATE AND TIME
                        $image = date('Y-m-d-h-i-s') . '-' . str_replace(' ', '_', $file_name);
                        $path = $image_path . $image;
                        move_uploaded_file($file_tmp_name, $path);
                        $images[] = $image;

                    }
                }//FOREACH ENDS

            } else {

                //SINGLE FILE UPLOAD
                $file_name = $file_input['name'];
                $file_tmp_name = $file_input['tmp_name'];
                $file_size = $file_input['size'];

                if ($file_size > 0) {

                    //RENAME WITH NEW DATE AND TIME
                    $images = date('Y-m-d-h-i-s') . '-' . str_replace(' ', '_', $file_name);
                    $path = $image_path . $images;
                    move_uploaded_file($file_tmp_name, $path);

                }
            }
            return $images;
        }

        // Check If File set or not
        public static function isFileSet($fileInput)
        {
            $res = false;
            if (is_array($fileInput['tmp_name'])) {

                foreach ($fileInput['tmp_name'] as $key => $val) {

                    $file_size = $fileInput['size'][$key];

                    if ($file_size > 0) {

                        $res = true;
                    } else {
                        $res = false;
                    }

                }

            } else {

                if ($fileInput['size'] > 0) {

                    $res = true;
                } else {
                    $res = false;
                }
            }
            return $res;
        }

        // Unlink File
        public static function unlink($filePath)
        {

            if (is_file($filePath)) {

                unlink($filePath);
                return true;

            } else {
                return false;
            }

        }

        public static function instance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new Upload();
            }

            return self::$instance;
        }

    }
}
