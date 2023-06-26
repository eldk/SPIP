<?php

declare(strict_types=1);

$test = 'attribut_html';

$remonte = __DIR__ . '/';

while (!is_file($remonte . 'test.inc')) {
	$remonte .= '../';
}

require $remonte . 'test.inc';

include_spip('inc/filtres');

$url = '/ecrire/?exec=exec&id_obj=id_obj&no_val';

$amp = str_replace('&', '&amp;', $url);

$essais[] =
 ['aujourd&#039;hui &gt; &#034;30&#034; &rarr; 50', "aujourd'hui > \"30\" &rarr; <a href='http://www.spip.net'>50</a>"];

$essais[] =
 [
 	'L&#039;histoire &#039;tr&#232;s&#039; &#034;folle&#034; des m&#233;tas en iitalik',
 	'L\'histoire \'tr&egrave;s\' "folle" <strong>des</strong>&nbsp;m&eacute;tas<p>en <em>ii</em>talik</p>',
 ];

// le a` risque de matcher \s

$essais[] =
['allons &#224; la mer', 'allons ' . chr(195) . chr(160) . ' la mer'];

//

// hop ! on y va
//

$err = tester_fun('attribut_html', $essais);

// si le tableau $err est pas vide ca va pas

if ($err) {
	die('<dl>' . implode('', $err) . '</dl>');
}

echo 'OK';
