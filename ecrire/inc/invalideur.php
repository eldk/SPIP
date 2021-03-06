<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2018                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/**
 * Gestion du cache et des invalidations de cache
 *
 * @package SPIP\Core\Cache
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('base/serial');

/** Estime la taille moyenne d'un fichier cache, pour ne pas les regarder (10ko) */
if (!defined('_TAILLE_MOYENNE_FICHIER_CACHE')) {
	define('_TAILLE_MOYENNE_FICHIER_CACHE', 1024 * 10);
}
/**
 * Si un fichier n'a pas été servi (fileatime) depuis plus d'une heure, on se sent
 * en droit de l'éliminer
 */
if (!defined('_AGE_CACHE_ATIME')) {
	define('_AGE_CACHE_ATIME', 3600);
}

/**
 * Calcul le nombre de fichiers à la racine d'un répertoire ainsi qu'une
 * approximation de la taille du répertoire
 *
 * On ne calcule que la racine pour pour aller vite.
 *
 * @param string $dir Chemin du répertoire
 * @param string $nb_estim_taille Nombre de fichiers maximum pour estimer la taille
 * @return bool|array
 *
 *     - false si le répertoire ne peut pas être ouvert
 *     - array(nombre de fichiers, approximation de la taille en octet) sinon
 **/
function nombre_de_fichiers_repertoire($dir, $nb_estim_taille = 20) {
	$taille = 0; // mesurer la taille de N fichiers au hasard dans le repertoire
	$nb = $nb_estim_taille;
	if (!$h = opendir($dir)) {
		return false;
	}
	$total = 0;
	while (($fichier = @readdir($h)) !== false) {
		if ($fichier[0] != '.' and !is_dir("$dir/$fichier")) {
			$total++;
			if ($nb and rand(1, 10) == 1) {
				$taille += filesize("$dir/$fichier");
				$nb--;
			}
		}
	}
	closedir($h);

	return array($total, $taille ? $taille / ($nb_estim_taille - $nb) : _TAILLE_MOYENNE_FICHIER_CACHE);
}


/**
 * Évalue approximativement la taille du cache
 *
 * Pour de gros volumes, impossible d'ouvrir chaque fichier,
 * on y va donc à l'estime !
 *
 * @return int Taille approximative en octets
 **/
function taille_du_cache() {
	# check dirs until we reach > 500 files
	$t = 0;
	$n = 0;
	$time = isset($GLOBALS['meta']['cache_mark']) ? $GLOBALS['meta']['cache_mark'] : 0;
	for ($i=0; $i < 256; $i++) {
		$dir = _DIR_CACHE.sprintf('%02s', dechex($i));
		if (@is_dir($dir) and is_readable($dir) and $d = opendir($dir)) {
			while (($f = readdir($d)) !== false) {
				if (preg_match(',^[[0-9a-f]+\.cache$,S', $f) and $a = stat("$dir/$f")) {
					$n++;
					if ($a['mtime'] >= $time) {
						if ($a['blocks'] > 0) {
							$t += 512*$a['blocks'];
						} else {
							$t += $a['size'];
						}
					}
				}
			}
		}
		if ($n > 500) {
			return intval(256*$t/(1+$i));
		}
	}
	return $t;
}


/**
 * Invalider les caches liés à telle condition
 *
 * Les invalideurs sont de la forme 'objet/id_objet'.
 * La condition est géneralement "id='objet/id_objet'".
 *
 * Ici on se contente de noter la date de mise à jour dans les metas,
 * pour le type d'objet en question (non utilisé cependant) et pour
 * tout le site (sur la meta `derniere_modif`)
 *
 * @global derniere_modif_invalide
 *     Par défaut à `true`, la meta `derniere_modif` est systématiquement
 *     calculée dès qu'un invalideur se présente. Cette globale peut
 *     être mise à `false` (aucun changement sur `derniere_modif`) ou
 *     sur une liste de type d'objets (changements uniquement lorsqu'une
 *     modification d'un des objets se présente).
 *
 * @param string $cond
 *     Condition d'invalidation
 * @param bool $modif
 *     Inutilisé
 **/
function suivre_invalideur($cond, $modif = true) {
	if (!$modif) {
		return;
	}

	// determiner l'objet modifie : forum, article, etc
	if (preg_match(',["\']([a-z_]+)[/"\'],', $cond, $r)) {
		$objet = objet_type($r[1]);
	}

	// stocker la date_modif_$objet (ne sert a rien pour le moment)
	if (isset($objet)) {
		ecrire_meta('derniere_modif_' . $objet, time());
	}

	// si $derniere_modif_invalide est un array('article', 'rubrique')
	// n'affecter la meta que si un de ces objets est modifie
	if (is_array($GLOBALS['derniere_modif_invalide'])) {
		if (in_array($objet, $GLOBALS['derniere_modif_invalide'])) {
			ecrire_meta('derniere_modif', time());
		}
	} // sinon, cas standard, toujours affecter la meta
	else {
		ecrire_meta('derniere_modif', time());
	}
}


/**
 * Purge un répertoire de ses fichiers
 *
 * Utilisée entre autres pour vider le cache depuis l'espace privé
 *
 * @uses supprimer_fichier()
 *
 * @param string $dir
 *     Chemin du répertoire à purger
 * @param array $options
 *     Tableau des options. Peut être :
 *
 *     - atime : timestamp pour ne supprimer que les fichiers antérieurs
 *       à cette date (via fileatime)
 *     - mtime : timestamp pour ne supprimer que les fichiers antérieurs
 *       à cette date (via filemtime)
 *     - limit : nombre maximum de suppressions
 * @return int
 *     Nombre de fichiers supprimés
 **/
function purger_repertoire($dir, $options = array()) {
	if (!is_dir($dir) or !is_readable($dir)) {
		return;
	}
	$handle = opendir($dir);
	if (!$handle) {
		return;
	}

	$total = 0;

	while (($fichier = @readdir($handle)) !== false) {
		// Eviter ".", "..", ".htaccess", ".svn" etc.
		if ($fichier[0] == '.') {
			continue;
		}
		$chemin = "$dir/$fichier";
		if (is_file($chemin)) {
			if ((!isset($options['atime']) or (@fileatime($chemin) < $options['atime']))
				and (!isset($options['mtime']) or (@filemtime($chemin) < $options['mtime']))
			) {
				supprimer_fichier($chemin);
				$total++;
			}
		} else {
			if (is_dir($chemin)) {
				$opts = $options;
				if (isset($options['limit'])) {
					$opts['limit'] = $options['limit'] - $total;
				}
				$total += purger_repertoire($chemin, $opts);
				if (isset($options['subdir']) && $options['subdir']) {
					spip_unlink($chemin);
				}
			}
		}

		if (isset($options['limit']) and $total >= $options['limit']) {
			break;
		}
	}
	closedir($handle);

	return $total;
}


//
// Destruction des fichiers caches invalides
//

// Securite : est sur que c'est un cache
// http://code.spip.net/@retire_cache
function retire_cache($cache) {

	if (preg_match(
		',^([0-9a-f]/)?([0-9]+/)?[0-9a-f]+\.cache(\.gz)?$,i',
		$cache
	)) {
		// supprimer le fichier (de facon propre)
		supprimer_fichier(_DIR_CACHE . $cache);
	} else {
		spip_log("Nom de fichier cache incorrect : $cache");
	}
}

#######################################################################
##
## Ci-dessous les fonctions qui restent appellees dans le core
## pour pouvoir brancher le plugin invalideur ;
## mais ici elles ne font plus rien
##

// Supprimer les caches marques "x"
// A priori dans cette version la fonction ne sera pas appelee, car
// la meta est toujours false ; mais evitons un bug si elle est appellee
// http://code.spip.net/@retire_caches
function retire_caches($chemin = '') {
	if (isset($GLOBALS['meta']['invalider_caches'])) {
		effacer_meta('invalider_caches');
	} # concurrence
}


// Fonction permettant au compilo de calculer les invalideurs d'une page
// (note: si absente, n'est pas appellee)
/*
// http://code.spip.net/@calcul_invalideurs
function calcul_invalideurs($corps, $primary, &$boucles, $id_boucle) {
	return $corps;
}
*/

// Cette fonction permet de supprimer tous les invalideurs
// Elle ne touche pas aux fichiers cache eux memes ; elle est
// invoquee quand on vide tout le cache en bloc (action/purger)
//
// http://code.spip.net/@supprime_invalideurs
function supprime_invalideurs() {
}


// Calcul des pages : noter dans la base les liens d'invalidation
// http://code.spip.net/@maj_invalideurs
function maj_invalideurs($fichier, &$page) {
}


// les invalideurs sont de la forme "objet/id_objet"
// http://code.spip.net/@insere_invalideur
function insere_invalideur($inval, $fichier) {
}


//
// Marquer les fichiers caches invalides comme etant a supprimer
//
// http://code.spip.net/@applique_invalideur
function applique_invalideur($depart) {
}
