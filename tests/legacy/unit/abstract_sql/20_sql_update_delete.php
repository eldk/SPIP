<?php

declare(strict_types=1);

// nom du test

$test = 'sql/sql_update_delete';

$remonte = __DIR__ . '/';

while (! is_file($remonte . 'test.inc')) {
	$remonte .= '../';
}

require $remonte . 'test.inc';

include __DIR__ . '/inc-sql_datas.inc';

include_spip('base/abstract_sql');

/*
 * Update/delete, de tables dans la base de donnee
 *
 */

/*
 * Updates
 */

function test_update_data()
{
	$err = [];
	$essais = [];
	// ajouter un champ
	$nb = sql_getfetsel('un_bigint', 'spip_test_tintin', 'id_tintin=' . sql_quote(1));
	sql_update('spip_test_tintin', [
		'un_bigint' => 'un_bigint+2',
	]);
	$nb2 = sql_getfetsel('un_bigint', 'spip_test_tintin', 'id_tintin=' . sql_quote(1));
	if ($nb + 2 != $nb2) {
		$err[] = "sql_update n'a pas fait l'adition ! ({$nb} + 2 != {$nb2})";
	}

	// affichage
	if ($err) {
		return '<b>Updates</b><dl><dd>' . implode('</dd><dd>', $err) . '</dd></dl>';
	}
}

/*
 * Delete
 */

function test_delete_data()
{
	$err = [];
	$essais = [];
	// supprimer une colonne
	sql_delete('spip_test_tintin', 'id_tintin=' . sql_quote(1));
	$nb = sql_countsel('spip_test_tintin');
	if ($nb !== 2) {
		$err[] = "sql_delete n'a rate sa suppression de id_tintin=1";
	}

	// supprimer une colonne
	sql_delete('spip_test_tintin');
	$nb = sql_countsel('spip_test_tintin');
	if ($nb !== 0) {
		$err[] = "sql_delete n'a rate le vidage de la table spip_test_tintin";
	}

	// affichage
	if ($err) {
		return '<b>Updates</b><dl><dd>' . implode('</dd><dd>', $err) . '</dd></dl>';
	}
}

$err = '';

// supprimer les eventuelles tables

$err .= test_drop_table();

// creer les eventuelles tables

$err .= test_create_table();

// inserer les donnees dans la table

$err .= test_insert_data();

// mettre a jour les donnees dans la table

$err .= test_update_data();

// supprimer les donnees dans la table

$err .= test_delete_data();

// supprimer les tables

$err .= test_drop_table();

if ($err !== '' && $err !== '0') {
	die($err);
}

echo 'OK';
