<?php
function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function eastontop($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}
function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', //equiv to 0x160
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
function hyphenize($string) {
    $dict = array(
        "I'm"      => "I am",
        "thier"    => "their",
        //replacement of friez below

    );
    return strtolower(
        preg_replace(
          array( '#[\\s-]+#', '#[^A-Za-z0-9. -]+#' ),
          array( '-', '' ),
          // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
          cleanString(
              str_replace( // preg_replace can be used to support more complicated replacements
                  array_keys($dict),
                  array_values($dict),
                  urldecode($string)
              )
          )
        )
    );
}

function clean($string) {
    $string = bd($string);
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 }
 function bd($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); 
}
function all($string) {
    $stringhtmlspecialchared = bd($string);
    $stringcleaned = clean($stringhtmlspecialchared);
    $almostdone = hyphenize($stringcleaned);
    $done = eastontop($almostdone);
    return $done;
}
function WebhookFilter($string) {
    $stringhtmlspecialchared = bd($string);
    $stringcleaned = clean($stringhtmlspecialchared);
    $done1 = $stringcleaned;
    return $done1;
}
?>