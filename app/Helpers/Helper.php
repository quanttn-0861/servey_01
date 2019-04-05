<?php
    function cleanText($text, $html = true)
    {
        if (!$text) {
            return false;
        }

        $text = nl2br($text, false);
        $arrText = explode('<br>', $text);

        foreach ($arrText as $key => $val) {
            $val = trim($val);
            $val = stripslashes($val);
            $val = htmlspecialchars($val);
            $arrText[$key] = $val;
        }

        if ($html) {
            return implode('<br>', $arrText);
        }

        return implode('\r\n', $arrText);
    }

    function splitText($text) {
        return str_limit($text, 75);
    }

    function replaceEmail($email, $search = ['.', '@'], $replace = '-')
    {
        if (is_array($email)) {
            foreach ($email as &$mail) {
                $mail = replaceEmail($mail, $search, $replace);
            }

            return $email;
        }

        return str_replace($search, $replace, $email);
    }

    function cleanTextForExport($text)
    {
        if (!$text) {
            return '';
        }

        $check = substr($text, 0, 1);

        if ($check == '=') {
            $text = "'=" . substr($text, 1);
        }

        return cleanText($text);
    }

    function checkExistsRemoteImage($url)
    {
        if (@getimagesize($url)) {
            return true;
        }

        return false;
    }
