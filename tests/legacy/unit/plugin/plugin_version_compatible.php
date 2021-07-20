<?php
/**
 * Test unitaire de la fonction plugin_version_compatible
 * du fichier ./inc/plugin.php
 *
 * genere automatiquement par TestBuilder
 * le 2011-05-14 11:13
 */

	$test = 'plugin_version_compatible';
	$remonte = __DIR__ . '/';
	while (!is_file($remonte."test.inc"))
		$remonte = $remonte."../";
	require $remonte.'test.inc';
	find_in_path("./inc/plugin.php",'',true);

	// chercher la fonction si elle n'existe pas
	if (!function_exists($f='plugin_version_compatible')){
		find_in_path("inc/filtres.php",'',true);
		$f = chercher_filtre($f);
	}

	//
	// hop ! on y va
	//
	$err = tester_fun($f, essais_plugin_version_compatible());
	
	// si le tableau $err est pas vide ca va pas
	if ($err) {
		die ('<dl>' . join('', $err) . '</dl>');
	}

	echo "OK";
	

	function essais_plugin_version_compatible(){
		$essais = array (
  0 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2',
  ),
  1 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0',
  ),
  2 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0',
  ),
  3 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0dev',
  ),
  4 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0alpha',
  ),
  5 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0beta',
  ),
  6 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0rc',
  ),
  7 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0#',
  ),
  8 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.0pl',
  ),
  9 => 
  array (
    0 => true,
    1 => '[1.0.0;3.0.0]',
    2 => '2.0.1',
  ),
  10 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2',
  ),
  11 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0',
  ),
  12 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0',
  ),
  13 => 
  array (
    0 => false,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0dev',
  ),
  14 => 
  array (
    0 => false,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0alpha',
  ),
  15 => 
  array (
    0 => false,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0beta',
  ),
  16 => 
  array (
    0 => false,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0rc',
  ),
  17 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0#',
  ),
  18 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.0pl',
  ),
  19 => 
  array (
    0 => true,
    1 => '[2.0.0;3.0.0]',
    2 => '2.0.1',
  ),
  20 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2',
  ),
  21 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0',
  ),
  22 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0',
  ),
  23 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0dev',
  ),
  24 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0alpha',
  ),
  25 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0beta',
  ),
  26 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0rc',
  ),
  27 => 
  array (
    0 => false,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0#',
  ),
  28 => 
  array (
    0 => true,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.0pl',
  ),
  29 => 
  array (
    0 => true,
    1 => ']2.0.0;3.0.0]',
    2 => '2.0.1',
  ),
  30 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2',
  ),
  31 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0',
  ),
  32 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0',
  ),
  33 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0dev',
  ),
  34 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0alpha',
  ),
  35 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0beta',
  ),
  36 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0rc',
  ),
  37 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0#',
  ),
  38 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.0pl',
  ),
  39 => 
  array (
    0 => false,
    1 => ')2.0.0;3.0.0]',
    2 => '2.0.1',
  ),
  40 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2',
  ),
  41 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0',
  ),
  42 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0',
  ),
  43 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0dev',
  ),
  44 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0alpha',
  ),
  45 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0beta',
  ),
  46 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0rc',
  ),
  47 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0#',
  ),
  48 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.0pl',
  ),
  49 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0]',
    2 => '2.0.1',
  ),
  50 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2',
  ),
  51 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0',
  ),
  52 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0',
  ),
  53 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0dev',
  ),
  54 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0alpha',
  ),
  55 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0beta',
  ),
  56 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0rc',
  ),
  57 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0#',
  ),
  58 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.0pl',
  ),
  59 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.0[',
    2 => '2.0.1',
  ),
  60 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2',
  ),
  61 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0',
  ),
  62 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0',
  ),
  63 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0dev',
  ),
  64 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0alpha',
  ),
  65 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0beta',
  ),
  66 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0rc',
  ),
  67 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0#',
  ),
  68 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.0pl',
  ),
  69 => 
  array (
    0 => false,
    1 => '[1.0.0;2.0.*[',
    2 => '2.0.1',
  ),
  70 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2',
  ),
  71 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0',
  ),
  72 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0',
  ),
  73 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0dev',
  ),
  74 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0alpha',
  ),
  75 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0beta',
  ),
  76 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0rc',
  ),
  77 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0#',
  ),
  78 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.0pl',
  ),
  79 => 
  array (
    0 => true,
    1 => '[1.0.0;2.0.*]',
    2 => '2.0.1',
  ),
  80 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2',
  ),
  81 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0',
  ),
  82 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0',
  ),
  83 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0dev',
  ),
  84 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0alpha',
  ),
  85 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0beta',
  ),
  86 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0rc',
  ),
  87 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0#',
  ),
  88 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.0pl',
  ),
  89 => 
  array (
    0 => true,
    1 => '[1.0.0;2.*]',
    2 => '2.0.1',
  ),
);
		return $essais;
	}


