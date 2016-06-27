<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2016                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

// Distinguer une inclusion d'un appel initial
// (cette distinction est obsolete a present, on la garde provisoirement
// par souci de compatiilite).

if (isset($GLOBALS['_INC_PUBLIC'])) {

	echo recuperer_fond($fond, $contexte_inclus, array(), _request('connect'));

} else {

	$GLOBALS['_INC_PUBLIC'] = 0;

	// Faut-il initialiser SPIP ? (oui dans le cas general)
	if (!defined('_DIR_RESTREINT_ABS'))
		if (defined('_DIR_RESTREINT')
		AND @file_exists( _ROOT_RESTREINT . 'inc_version.php')) {
			include_once  _ROOT_RESTREINT . 'inc_version.php';
		}
		else
			die('inc_version absent ?');


	// $fond defini dans le fichier d'appel ?

	else if (isset($fond) AND !_request('fond')) { }

	// fond demande dans l'url par page=xxxx ?
	else if (isset($_GET[_SPIP_PAGE])) {
		$fond = (string)$_GET[_SPIP_PAGE];

		// Securite
		if (strstr($fond, '/')
			AND !(
				isset($GLOBALS['visiteur_session']) // pour eviter d'evaluer la suite pour les anonymes
				AND include_spip('inc/autoriser')
				AND autoriser('webmestre'))) {
			include_spip('inc/minipres');
			echo minipres();
			exit;
		}
		// l'argument Page a priorite sur l'argument action
		// le cas se presente a cause des RewriteRule d'Apache
		// qui permettent d'ajouter un argument dans la QueryString
		// mais pas d'en retirer un en conservant les autres.
		if (isset($_GET['action']) AND $_GET['action'] === $fond)
			unset($_GET['action']);
	# sinon, fond par defaut
	} else {
		// traiter le cas pathologique d'un upload de document ayant echoue
		// car trop gros
		if (empty($_GET) AND empty($_POST) AND empty($_FILES)
		AND isset($_SERVER["CONTENT_LENGTH"])
		AND strstr($_SERVER["CONTENT_TYPE"], "multipart/form-data;")) {
			include_spip('inc/getdocument');
			erreur_upload_trop_gros();
		}

		// sinon fond par defaut (cf. assembler.php)
		$fond = '';
	}

	$tableau_des_temps = array();

	// Particularites de certains squelettes
	if ($fond == 'login')
		$forcer_lang = true;

	if (isset($forcer_lang) AND $forcer_lang AND ($forcer_lang!=='non') AND !_request('action')) {
		include_spip('inc/lang');
		verifier_lang_url();
	}

	$lang = !isset($_GET['lang']) ? '' : lang_select($_GET['lang']);

	// Charger l'aiguilleur des traitements derogatoires
	// (action en base SQL, formulaires CVT, AJax)
	if (_request('action') OR _request('var_ajax') OR _request('formulaire_action')){
		include_spip('public/aiguiller');
		if (
			// cas des appels actions ?action=xxx
			traiter_appels_actions()
		OR
			// cas des hits ajax sur les inclusions ajax
			traiter_appels_inclusions_ajax()
		 OR
			// cas des formulaires charger/verifier/traiter
			traiter_formulaires_dynamiques())
			exit; // le hit est fini !
	}

	// si signature de petition, l'enregistrer avant d'afficher la page
	// afin que celle-ci contienne la signature

	if (isset($_GET['var_confirm'])) {
		$reponse_confirmation = charger_fonction('reponse_confirmation','formulaires/signature');
		$reponse_confirmation($_GET['var_confirm']);
	}

	// Il y a du texte a produire, charger le metteur en page
	include_spip('public/assembler');
	$page = assembler($fond, _request('connect'));

	if (isset($page['status'])) {
		include_spip('inc/headers');
		http_status($page['status']);
	}

	// Tester si on est admin et il y a des choses supplementaires a dire
	// type tableau pour y mettre des choses au besoin.
	$debug = ((_request('var_mode') == 'debug') OR $tableau_des_temps) ? array(1) : array();

	// Mettre le Content-Type Html si manquant 
	// Idem si debug, avec retrait du Content-Disposition pour pouvoir le voir

	if ($debug OR !isset($page['entetes']['Content-Type'])) {
		$page['entetes']['Content-Type'] = 
			"text/html; charset=" . $GLOBALS['meta']['charset'];
		if ($debug) unset($page['entetes']['Content-Disposition']);
		$html = true;
	} else {
		$html = preg_match(',^\s*text/html,',$page['entetes']['Content-Type']);
	}

	$affiche_boutons_admin = ((!!$debug)
		OR ($html AND isset($_COOKIE['spip_admin']) AND !$flag_preserver)
		OR ($html AND ($_GET['var_mode']=='preview') AND !$flag_preserver)
		);

	if ($affiche_boutons_admin)
		include_spip('balise/formulaire_admin');

 	// decompte des visites, on peut forcer a oui ou non avec le header X-Spip-Visites
 	// par defaut on ne compte que les pages en html (ce qui exclue les js,css et flux rss)
 	$spip_compter_visites = $html?'oui':'non';
 	if (isset($page['entetes']['X-Spip-Visites'])){
		$spip_compter_visites = in_array($page['entetes']['X-Spip-Visites'],array('oui','non'))?$page['entetes']['X-Spip-Visites']:$spip_compter_visites;
		unset($page['entetes']['X-Spip-Visites']);
 	}

	// Execution de la page calculee

	// traitements sur les entetes avant envoi
	// peut servir pour le plugin de stats
	$page['entetes'] = pipeline('affichage_entetes_final', $page['entetes']);

	if ($page['process_ins'] != 'html') {
	// Cas d'une page contenant du PHP :
	// Attention cette partie eval() doit imperativement
	// etre declenchee dans l'espace des globales (donc pas
	// dans une fonction).
	// inclure_balise_dynamique nous enverra peut-etre
	// quelques en-tetes de plus (voire qq envoyes directement)

        gunzip_page($page);
		// restaurer l'etat des notes
		if (isset($page['notes']) AND $page['notes']){
			$notes = charger_fonction("notes","inc");
			$notes($page['notes'],'restaurer_etat');
		}
		ob_start(); 
		xml_hack($page, true);
		$page['process_ins'] = eval('?' . '>' . $page['texte']);
		$page['texte'] = ob_get_contents(); 
		xml_hack($page);
		ob_end_clean();
	}

	if ($var_preview
	AND $var_preview = charger_fonction('previsualisation', 'public', true)) {
		$page = $var_preview($page);
		// Cette variable a ete calculee trop tot
		// on laisse son calcul ci-dessus pour compatibilite
		// bien que l'enlever a l'air sans incidence
		$html = preg_match(',^\s*text/html,',$page['entetes']['Content-Type']);
	}

	// en cas d'erreur lors du eval,
	// la memoriser dans le tableau des erreurs
	if ($page['process_ins'] === false) {
			$msg = array('zbug_erreur_execution_page');
			erreur_squelette($msg);
	}
	//
	// Post-traitements pour pages HTML (font perdre la compression initiale)
	//
	if ($html) {
        // S'il faut inserer une balise Base du fait de profondeur_url > 0
        if (page_base_define()) {
            // Compatibilite vieux caches
            if (!isset($page['base'])) {
                gunzip_page($page);
                $page['base']= page_base_presente($page['texte']);
            }
            if ($page['base']) {
                gunzip_page($page);
                page_base_href($page['texte'], $page['base']);
            }
        }
        // S'il faut surligner une recherche
        // ce code semble mort, car dependant du filtre url_var_recherche
        // de la 1.9.2 disparu en 2.0. Y a un plugin qui s'en sert ?
        if (_request('var_recherche') AND isset($_SERVER['HTTP_REFERER'])) {
            gunzip_page($page);
            include_spip('inc/surligne');
            $page['texte'] = surligner_mots($page['texte'], _request('var_recherche'));
        }
        // Si on veut appliquer un validateur local
        if ($xhtml) {
            gunzip_page($page);
            $page['texte'] = f_tidy($page['texte']);
        }
        // Si on a un cookie de session d'admin
        if ($affiche_boutons_admin) {
            gunzip_page($page);
            $page['texte'] = f_admin($page['texte']);
        }
    }

	// Ce pipeline fait perdre la possibilite d'envoyer la version compressee
    if ($spip_pipeline['affichage_final']) {
        gunzip_page($page);
        $page['texte'] = pipeline('affichage_final', $page['texte']);
    }

	// Ces dernieres operations ont pu lever des erreurs (inclusion manquante)
	// il faut tester a nouveau 

	$debug = ((_request('var_mode') == 'debug') OR $tableau_des_temps) ? array(1) : array();

    // Si pas d'ajout ulterieur, 
    // fournir Content-Length et compresser si possible, utile et pas deja fait
    if ($debug) {
        gunzip_page($page);
    } else {
        // si page deja compressee la servir comme ca si possible
        if ($page['gz'] == 'deflate') {
            if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') !==false) {
                $page['entetes']['Content-Length'] = strlen($page['texte']);
                $page['entetes']['Content-Encoding'] = 'deflate';
#                spip_log("gain d'une decompression pour $fond");
            } else gunzip_page($page);
        }
        // si pas compressee ou decompressee a l'instant, essayer en gzip
        if ($page['gz'] != 'deflate') {
            $page['entetes']['Content-Length'] = strlen($page['texte']);
            if (($page['entetes']['Content-Length']>8192)
            AND ($GLOBALS['meta']['auto_compress_http'] == 'oui')
            AND (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !==false)) {
                    $page['texte'] = gzencode($page['texte']);
                    $page['entetes']['Content-Encoding'] = 'gzip';
                    $page['entetes']['Content-Length'] = strlen($page['texte']);
            }
        }
    }
    envoyer_entetes($page['entetes']);
    echo $page['texte'];

	if ($lang) lang_select();

	// Appel au debusqueur en cas d'erreurs ou de demande de trace
	if ($debug) {
			if (!_request('var_mode_affiche'))
				set_request('var_mode_affiche', 'resultat');
			$var_mode_affiche = _request('var_mode_affiche');
			$var_mode_objet = _request('var_mode_objet');
			$GLOBALS['debug_objets'][$var_mode_affiche][$var_mode_objet . 'tout'] = ($var_mode_affiche== 'validation' ? $page['texte'] :"");
			echo erreur_squelette(false);
	} else {
		if (isset($GLOBALS['meta']['date_prochain_postdate'])
		AND $GLOBALS['meta']['date_prochain_postdate'] <= time()) {
			include_spip('inc/rubriques');
			calculer_prochain_postdate(true);
		}

		// Effectuer une tache de fond ?
		// si #SPIP_CRON est present, on ne le tente que pour les navigateurs
		// en mode texte (par exemple), et seulement sur les pages web
		if (defined('_DIRECT_CRON_FORCE')
			OR (
			!defined('_DIRECT_CRON_INHIBE')
			AND $html
			AND !strstr($page['texte'], '<!-- SPIP-CRON -->')
			AND !preg_match(',msie|mozilla|opera|konqueror,i', $_SERVER['HTTP_USER_AGENT']))
			)
			cron();

		// sauver le cache chemin si necessaire
		save_path_cache();
	}

 	// Gestion des statistiques du site public
	if (($GLOBALS['meta']["activer_statistiques"] != "non")
	AND $spip_compter_visites!='non'
	AND $stats = charger_fonction('stats', 'public', true))
		$stats();
}

?>
