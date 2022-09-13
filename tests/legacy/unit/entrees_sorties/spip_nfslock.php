<?php

	$test = 'spip_nfslock';
	$remonte = __DIR__ . '/';
	while (!is_file($remonte."test.inc"))
		$remonte .= "../";

	require $remonte.'test.inc';
	include_spip("inc/nfslock");

	$verrou = spip_nfslock('monfichier');
	$verrou_ok = spip_nfslock_test('monfichier',$verrou);
	$verrou_absent = spip_nfslock_test('un autre',$verrou);

	$deverrouille = spip_nfsunlock('monfichier',$verrou);
	$birth = false;
	$verrou_absent2 = spip_nfslock_test('monfichier',$birth);

	if ($verrou && $verrou_ok && !$verrou_absent && $deverrouille && !$verrou_absent2){
		echo "OK";
		exit;
	}

	echo "<ul><li>Erreur NFSLock :";
	echo "<ul>";
	echo "<li>verrou sur 'monfichier':{$verrou}</li>";
	echo "<li>test du verrou sur 'monfichier':{$verrou_ok}</li>";
	echo "<li>test du verrou sur 'un autre':{$verrou_absent}</li>";
	echo "<li>deverrouille 'monfichier':{$deverrouille}</li>";
	echo "<li>test du verrou sur 'monfichier':{$verrou_absent2}</li>";
	echo "</ul></li></ul>";


