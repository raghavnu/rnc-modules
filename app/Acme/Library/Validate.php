<?php

namespace Acme\Library {

    class Validate
    {

        public static $errors = [];
        protected static $instance = null;

        /*
          |--------------------------------------------
          | Validate File
          |--------------------------------------------
          |
          |
         */

        public static function file($file, $dspName, $rule = '')
        {
            $rules = explode('|', $rule);
            if (is_array($file['tmp_name'])) {

                foreach ($file['tmp_name'] as $key => $tmp_name) {

                    $file_name = $file['name'][$key];
                    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $file_size = $file['size'][$key];

                    //CHECK FILE SIZE
                    if (in_array('required', $rules)) {

                        if ($file_size <= 0) {

                            self::setError($dspName, $dspName . " is required.");

                        }
                    }
                    if ($file_size > 0) {

                        foreach ($rules as $value) {

                            $res = explode(':', $value);

                            if (preg_match("/^mimes:([a-zA-Z,]*)$/", $value)) {

                                $format = explode(',', $res[1]);

                                if (!in_array($ext, $format)) {
                                    self::setError($dspName, 'Only ' . implode(" , ", $format) . " are allowed");
                                    //CHECK FILE SIZE
                                }
                            } elseif (preg_match("/^size:([0-9]*)$/", $value)) {

                                if ($file_size >= 1048576 * intval($res[1])) {

                                    self::setError($dspName, $dspName . " size is greater than {$res[1]} Mb");
                                }
                            }
                        }
                    }
                }//FOREACH ENDS
            } else {

                $file_name = $file['name'];
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $file_size = $file['size'];

                //CHECK FILE SIZE
                if (in_array('required', $rules)) {

                    if ($file_size <= 0) {

                        self::setError($dspName, $dspName . " is required.");

                    }
                }

                if ($file_size > 0) {

                    foreach ($rules as $key => $value) {

                        $res = explode(':', $value);

                        if (preg_match("/^mimes:([a-zA-Z,]*)$/", $value)) {

                            $format = explode(',', $res[1]);

                            if (!in_array($ext, $format)) {
                                self::setError($dspName, 'Only ' . implode(" , ", $format) . " are allowed");
                            }

                        } elseif (preg_match("/^size:([0-9]*)$/", $value)) {

                            if ($file_size >= 1048576 * intval($res[1])) {

                                self::setError($dspName, $dspName . " size is greater than {$res[1]} Mb");
                            }
                        }
                    }

                }
            }//END ELSE
        }

        /*
          |--------------------------------------------
          | Validate String
          |--------------------------------------------
         */

        private static function setError($elementName, $message)
        {
            self::$errors[$elementName] = ucfirst($message);
        }

        /*
          |--------------------------------------------
          | Validate Password
          |--------------------------------------------
         */

        public static function str($postVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($postVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                self::checkLength($postVal, $postName, $rules);

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Password Match
          |--------------------------------------------
         */

        private static function checkLength($postVal, $postName, $rules)
        {
            $value = [];
            foreach ($rules as $value) {

                $res = explode(':', $value);

                if (preg_match("/^min:([0-9]*)$/", $value)) {

                    if (strlen($postVal) < intval($res[1])) {

                        self::setError($postName, $postName . " must be at least {$res[1]} character long.");
                    }

                } elseif (preg_match("/^max:([0-9]*)$/", $value)) {

                    if (strlen($postVal) > intval($res[1])) {

                        self::setError($postName, $postName . " must be less than {$res[1]} character long.");
                    }
                }

            }
        }

        /*
          |--------------------------------------------
          | Validate Checkbox
          |--------------------------------------------
         */

        public static function pass($passVal, $passName = "Password")
        {
            $passVal = trim($passVal);

            if (empty($passVal)) {

                self::setError($passName, $passName . " is required.");

            } elseif (strlen($passVal) < 6) {

                self::setError($passName, $passName . " must be at least 6 character long.");

            } elseif (!preg_match('#[0-9]+#', $passVal)) {

                self::setError($passName, $passName . " must have at least one Number.");

            } elseif (!preg_match('#[a-z]+#', $passVal)) {

                self::setError($passName, $passName . " must have at least one Lowercase Letter.");

            } elseif (!preg_match('#[A-Z]+#', $passVal)) {

                self::setError($passName, $passName . " must have at least one Uppercase Letter.");

            } elseif (!preg_match('/[!\-_\+=\)\(\*&\^%$#@!\}\{\[\]|\.\:;|\,<>\?]+/', $passVal)) {

                self::setError($passName, $passName . " must have at least one special character.");

            } elseif (strlen($passVal) > 20) {

                self::setError($passName, $passName . " must not be greater than 20 character long.");

            }
        }

        /*
          |--------------------------------------------
          | Validate Radio
          |--------------------------------------------
         */

        public static function match($passRetype, $password, $passName = "Retype password")
        {
            $passRetype = trim($passRetype);
            $password = trim($password);

            if (empty($passRetype) or strlen($passRetype) < 1) {

                self::setError($passName, $passName . " is required.");

            } elseif ($passRetype != $password) {

                self::setError($passName, $passName . " didn't Matched!.");

            }
        }

        /*
          |--------------------------------------------
          | Validate Email
          |--------------------------------------------
         */

        public static function checkBox($cbVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($cbVal);

            if (in_array('required', $rules)) {

                if (count($cbVal) <= 0) {

                    self::setError($postName, $postName . " is not checked");

                }
            }

            if (!empty($postVal)) {

                self::checkLength($postVal, $postName, $rules);

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Bool
          |--------------------------------------------
         */

        public static function radio($rbVal, $rbName)
        {
            $rbVal = trim($rbVal);

            if (count($rbVal) <= 0) {

                self::setError($rbName, $rbName . " is not Checked.");
            }
        }

        /*
          |--------------------------------------------
          | Validate Float
          |--------------------------------------------
         */

        public static function email($postVal, $postName = "Email", $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($postVal);

            if (in_array('required', $rules)) {

                if ($postVal == "") {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                $domain = substr($postVal, strpos($postVal, '@') + 1);

                if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $postVal) AND !filter_var($postVal, FILTER_VALIDATE_EMAIL)) {

                    self::setError($postName, $postName . " is not a valid email.");

                } elseif (checkdnsrr($domain) == FALSE) {

                    self::setError($postName, $postName . " domain is not Valid");
                }

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate IP
          |--------------------------------------------
         */

        public static function bool($boolVal, $boolName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($boolVal);

            if (in_array('required', $rules)) {

                if ($postVal == "") {

                    self::setError($boolName, $boolName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!filter_var($postVal, FILTER_VALIDATE_BOOLEAN)) {

                    self::setError($boolName, $boolName . " is not a valid boolean.");

                }

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Url
          |--------------------------------------------
         */

        public static function float($floatVal, $floatName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($floatVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($floatName, $floatName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!filter_var($floatVal, FILTER_VALIDATE_FLOAT)) {

                    self::setError($floatName, $floatName . " is not a valid floating number.");

                } else {

                    self::checkLength($postVal, $floatName, $rules);

                }

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Alphanumeric
          |--------------------------------------------
         */

        public static function ip($ipVal, $ipName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($ipVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($ipName, $ipName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!filter_var($postVal, FILTER_VALIDATE_IP)) {

                    self::setError($ipName, $ipName . " is not a valid IP address.");

                }

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Number
          |--------------------------------------------
         */

        public static function url($urlVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($urlVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!filter_var($urlVal, FILTER_VALIDATE_URL)) {

                    self::setError($postName, $postName . " is not a valid URL address.");

                }

            }// If Value Exists
        }

        /*
          |--------------------------------------------
          | Validate Character
          |--------------------------------------------
         */

        public static function alphaNum($anVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($anVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!preg_match('/^[a-z0-9][a-z0-9-]*[a-z0-9]$/i', $postVal)) {

                    self::setError($postName, $postName . " is not a valid Alphanumeric value.");

                } else {

                    self::checkLength($postVal, $postName, $rules);

                }

            }// If Value Exists
        }

        /*
         |--------------------------------------------
         | Check Length
         |--------------------------------------------
        */

        public static function num($numVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($numVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (!is_numeric($postVal)) {

                    self::setError($postName, $postName . " is not a number.");

                } else {

                    self::checkLength($postVal, $postName, $rules);

                }

            }// If Value Exists
        }


        /*
          |--------------------------------------------
          | Set Error
          |--------------------------------------------
         */

        public static function char($charVal, $postName, $rule = '')
        {
            $rules = explode('|', $rule);
            $postVal = trim($charVal);

            if (in_array('required', $rules)) {

                if (strlen($postVal) < 1 or empty($postVal)) {

                    self::setError($postName, $postName . " is required.");

                }
            }

            if (!empty($postVal)) {

                if (preg_match('/[^a-zA-Z ]+/', $postVal)) {

                    self::setError($postName, $postName . " is not a character.");

                } else {

                    self::checkLength($postVal, $postName, $rules);

                }

            }// If Value Exists

        }

        /*
         |--------------------------------------------
         | Get Errors
         |--------------------------------------------
        */

        public static function getError($elementName)
        {
            if (isset(self::$errors[$elementName])) {
                return self::$errors[$elementName];
            } else {
                return '';
            }
        }

        /*
          |--------------------------------------------
          | Repopulate Data
          |--------------------------------------------
         */

        public static function rePopulate($value, $reset = false)
        {

            return isset($reset) ? '' : self::setValue($value);
        }

        /*
          |--------------------------------------------
          | Repopulate input Data
          |--------------------------------------------
         */

        public static function setValue($postName)
        {
            return isset($_REQUEST[$postName]) ? $_REQUEST[$postName] : '';
        }

        /*
          |--------------------------------------------
          | Get Error List
          |--------------------------------------------
         */

        public static function errorList()
        {
            $errorsList = "<ol class=\"text-danger\">\n";
            foreach (self::$errors as $value) {
                $errorsList .= "<li>" . $value . "</li>\n";
            }
            $errorsList .= "</ol>\n";
            return $errorsList;
        }

        /*
          |--------------------------------------------
          | Display Error in Number
          |--------------------------------------------
         */

        public static function errorCount()
        {
            $message = "";
            if (count(self::$errors) > 1) {
                $message = "There were " . count(self::$errors) . " errors sending your data!\n";
            } elseif (count(self::$errors) == 1) {
                $message = "There was an error sending your data!\n";
            }
            return $message;
        }


        public static function isFine()
        {
            if (count(self::$errors) > 0) {
                return false;
            }
            return true;
        }


    }// Class

}// Namespace
