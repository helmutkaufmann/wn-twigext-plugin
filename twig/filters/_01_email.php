<?php

$filters += [

  'mailto' => function ($email, $link = true, $protected = true, $text = null, $class = "") {
     /**
     * Create protected link with mailto:
     *
     * @param string $email Email to render.
     * @param bool $link If email should be rendered as link.
     * @param bool $protected If email should be protected.
     * @param string $text Link text. Render email by default.
     *
     * @see http://www.maurits.vdschee.nl/php_hide_email/
     *
     * @return string
     */
        // email link text
        $linkText = $email;
        if ($text !== null) {
            $linkText = $text;
        }

        // if we want just unprotected link
        if (!$protected) {
            return $link ? '<a href="mailto:' . $email . '">' . $linkText . '</a>' : $linkText;
        }

        // turn on protection
        $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
        $key = str_shuffle($character_set);
        $cipher_text = '';
        $id = 'e' . rand(1, 999999999);
        for ($i = 0;$i < strlen($email);$i += 1) {
            $cipher_text .= $key[strpos($character_set, $email[$i]) ];
        }
        $script = 'var a="' . $key . '";var b=a.split("").sort().join("");var c="' . $cipher_text . '";var d=""; var cl="' . $class . '";';
        $script .= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
        $script .= 'var y = d;';
        if ($text !== null) {
            $script .= 'var y = "' . $text . '";';
        }
        if ($link) {
            $script .= 'document.getElementById("' . $id . '").innerHTML="<a class=\""+cl+"\" href=\\"mailto:"+d+"\\">"+y+"</a>"';
        }
        else {
            $script .= 'document.getElementById("' . $id . '").innerHTML=y';
        }
        $script = "eval(\"" . str_replace(array(
            "\\",
            '"'
        ) , array(
            "\\\\",
            '\"'
        ) , $script) . "\")";
        $script = '<script type="text/javascript">/*<![CDATA[*/' . $script . '/*]]>*/</script>';

        return '<span id="' . $id . '">[javascript protected email address]</span>' . $script;
        }
];

?>
