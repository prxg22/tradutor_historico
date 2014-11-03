<?php
class MY_Input extends Input{
function _clean_input_keys($str) {
        if (!preg_match("/^[a-z0-9:_\/\.\[\]-]+$/i", $str)) {
            var_dump($str);
            exit('Disallowed Key Characters.');
        }

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE) {
            $str = $this->uni->clean_string($str);
        }

        return $str;
    }
}