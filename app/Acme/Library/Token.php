<?php

namespace Acme\Library {

    class Token
    {

        const FIELD_NAME = '_token';
        const DO_NOT_CLEAR = FALSE;

        public static function csrf()
        {
            $token = self::_generateToken();
            return "<input name='" . self::FIELD_NAME . "' value='{$token}' type='hidden' />";
        }

        public static function check($clear = true)
        {
            $valid = false;
            $posted = isset($_REQUEST[self::FIELD_NAME]) ? $_REQUEST[self::FIELD_NAME] : '';
            if (!empty($posted)) {
                if (isset($_SESSION['formtoken'][$posted])) {
                    if ($_SESSION['formtoken'][$posted] >= time() - 7200) {
                        $valid = true;
                    }
                    if ($clear)
                        unset($_SESSION['formtoken'][$posted]);
                }
            }
            return $valid;
        }

        protected static function _generateToken()
        {
            $time = time();
            $token = sha1(mt_rand(0, 1000000));
            $_SESSION['formtoken'][$token] = $time;
            return $token;
        }

    }
}

/*
 USES
<form action="process.php" method="post">
    <label>What is your name? <input name="name" /></label>
    <input type="submit" />
    <?php echo Token::csrf() ?>
</form>


if (Token::check($_POST)) {

}
else {
 die('The form is not valid or has expired.');
}
 */