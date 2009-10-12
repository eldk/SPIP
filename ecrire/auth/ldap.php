<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2009                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

// Authentifie via LDAP et retourne la ligne SQL decrivant l'utilisateur si ok

// http://doc.spip.org/@inc_auth_ldap_dist
function auth_ldap_dist ($login, $pass) {

	if (!spip_connect_ldap())
		return false;

	#spip_log("ldap $login " . ($pass ? "mdp fourni" : "mdp absent"));
	// Securite contre un serveur LDAP laxiste
	if (!$login || !$pass) return array();

	// Utilisateur connu ?
	if (!($dn = auth_ldap_search($login, $pass))) return array();

	// Si l'utilisateur figure deja dans la base, y recuperer les infos
	$result = sql_fetsel("*", "spip_auteurs", "login=" . sql_quote($login) . " AND source='ldap'");

	if ($result) return $result;

	// sinon importer les infos depuis LDAP, 
	// avec le statut par defaut a l'install

	$n = auth_ldap_inserer($dn, $GLOBALS['meta']["ldap_statut_import"], $login);
	if ($n)	return sql_fetsel("*", "spip_auteurs", "id_auteur=$n");
	spip_log("Creation de l'auteur '$login' impossible");
	return array();
}

// http://doc.spip.org/@auth_ldap_search
function auth_ldap_search($login, $pass){
	$ldap = spip_connect_ldap();
	$ldap_link = $ldap['link'];
	$ldap_base = $ldap['base'];

	// Attributs testes pour egalite avec le login
	$atts = array('sAMAccountName', 'uid', 'login', 'userid', 'cn', 'sn');
	$login_search = preg_replace("/[^-@._\s\d\w]/", "", $login); // securite

	// Tenter une recherche pour essayer de retrouver le DN
	reset($atts);
	while (list(, $att) = each($atts)) {
		$result = @ldap_search($ldap_link, $ldap_base, "$att=$login_search", array("dn"));
		$info = @ldap_get_entries($ldap_link, $result);
			// Ne pas accepter les resultats si plus d'une entree
			// (on veut un attribut unique)
		if (is_array($info) AND $info['count'] == 1) {
			$dn = $info[0]['dn'];
			if (@ldap_bind($ldap_link, $dn, $pass)) return $dn;
		}
	}

	if (!isset($dn)) {
		// Si echec, essayer de deviner le DN
		reset($atts);
		while (list(, $att) = each($atts)) {
			$dn = "$att=$login_search, $ldap_base";
			if (@ldap_bind($ldap_link, $dn, $pass))
				return "$att=$login_search, $ldap_base";
		}
	}
	return '';
}

function auth_ldap_retrouver($dn, $desc='')
{
	if (!$desc) $desc = array('nom' => "cn",
				  'email' => "mail", 
				  'bio' => "description");

	// Lire les infos sur l'utilisateur a partir de son DN depuis LDAP

	$ldap_link = spip_connect_ldap();
	$ldap_link = $ldap_link['link'];
	$result = @ldap_read($ldap_link, $dn, "objectClass=*", array_values($desc));

	if (!$result) return array();

	// Recuperer les donnees du premier (unique?) compte de l'auteur
	$val = @ldap_get_entries($ldap_link, $result);
	if (!is_array($val) OR !is_array($val[0])) return array();
	$val = $val[0];

	// Convertir depuis UTF-8 (jeu de caracteres par defaut)
	include_spip('inc/charsets');

	foreach ($desc as $k => $v)
		$desc[$k] = importer_charset($val[strtolower($v)][0], 'utf-8');
	return $desc;
}


// http://doc.spip.org/@auth_ldap_inserer
// Ajout du parametre $login
function auth_ldap_inserer($dn, $statut, $login='', $desc='')
{
	// refuser d'importer n'importe qui 
	if (!$statut) return array();

	$val = auth_ldap_retrouver($dn);
	if (!$val) return array();

	return sql_insertq('spip_auteurs', array(
				'source' => 'ldap',
				'login' => $login,
				'statut' => $statut,
				'email' => $val['email'],
				'nom' => $val['nom'],
				'bio' => $val['bio'],
				'pass' => ''));
}


/**
 * Retrouver le login de quelqu'un qui cherche a se loger
 *
 * @param string $login
 * @return string
 */
function auth_ldap_retrouver_login($login){
	// Si l'utilisateur figure deja dans la base, y recuperer les infos
	$result = sql_fetsel("*", "spip_auteurs", "login=" . sql_quote($login) . " AND source='ldap'");
	$ldap = spip_connect_ldap();
	$ldap_link = $ldap['link'];
	$ldap_base = $ldap['base'];

	// Attributs testes pour egalite avec le login
	$atts = array('sAMAccountName', 'uid', 'login', 'userid', 'cn', 'sn');
	$login_search = preg_replace("/[^-@._\s\d\w]/", "", $login); // securite

	// Tenter une recherche pour essayer de retrouver le DN
	reset($atts);
	while (list(, $att) = each($atts)) {
		$result = @ldap_search($ldap_link, $ldap_base, "$att=$login_search", array("dn"));
		$info = @ldap_get_entries($ldap_link, $result);
		// Ne pas accepter les resultats si plus d'une entree
		// (on veut un attribut unique)
		if (is_array($info) AND $info['count'] == 1) {
			$dn = $info[0]['dn'];
			return $login;
		}
	}

	// sans le mot de passe, on ne peut faire de devinettes
	return '';
}

?>