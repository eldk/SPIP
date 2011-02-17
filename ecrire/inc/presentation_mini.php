<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2011                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) return;

// http://doc.spip.org/@echo_log
function echo_log($f, $ret) {
	spip_log("Page " . self() . " function $f: echo ".substr($ret,0,50)."...",'echo');
	echo
	(_SIGNALER_ECHOS?"#Echo par $f#" :"")
		. $ret;
}


//
// Cadre centre (haut de page)
//

// http://doc.spip.org/@debut_grand_cadre
function debut_grand_cadre($return=false){
	$res =  "\n<div class='table_page'>\n";
	if ($return) return $res; else echo_log('debut_grand_cadre',$res);
}

// http://doc.spip.org/@fin_grand_cadre
function fin_grand_cadre($return=false){
	$res = "\n</div>";
	if ($return) return $res; else echo_log('fin_grand_cadre',$res);
}

//
// Debut de la colonne de gauche
//

// http://doc.spip.org/@debut_gauche
function debut_gauche($rubrique = "accueil", $return=false) {
	global $spip_display;
	global $spip_ecran, $spip_lang_rtl, $spip_lang_left;

	// div navigation fermee par creer_colonne_droite qui ouvre
	// div extra lui-meme ferme par debut_droite qui ouvre
	// div contenu lui-meme ferme par fin_gauche() ainsi que
	// div conteneur

	$res = "<div id='conteneur' class='".(_INTERFACE_ONGLETS ? "onglets" : "no_onglets")  ."'>
		\n<div id='navigation'>\n";

	if ($spip_display == 4) $res .= "<!-- ";

	if ($return) return $res; else echo_log('debut_gauche',$res);
}

// http://doc.spip.org/@fin_gauche
function fin_gauche()
{
	return "</div></div><br class='nettoyeur' />";
}

//
// Presentation de l''interface privee, marge de droite
//

// http://doc.spip.org/@creer_colonne_droite
function creer_colonne_droite($rubrique="", $return= false){
	static $deja_colonne_droite;
	global $spip_ecran, $spip_lang_rtl, $spip_lang_left;

	if ((!($spip_ecran == "large")) OR $deja_colonne_droite) return '';
	$deja_colonne_droite = true;

	$res = "\n</div><div id='extra'>";

	if ($return) return $res; else echo_log('creer_colonne_droite',$res);
}

// http://doc.spip.org/@debut_droite
function debut_droite($rubrique="", $return= false) {
	global $spip_ecran, $spip_display, $spip_lang_left;

	$res = '';

	if ($spip_display == 4) $res .= " -->";

	$res .= liste_objets_bloques();

	$res .= creer_colonne_droite($rubrique, true)
	. "</div>";

	$res .= "\n<div id='contenu'>";

	// touche d'acces rapide au debut du contenu : z
	// Attention avant c'etait 's' mais c'est incompatible avec
	// le ctrl-s qui fait "enregistrer"
	$res .= "\n<a id='saut' href='#saut' accesskey='z'></a>\n";

	if ($return) return $res; else echo_log('debut_droite',$res);
}

// http://doc.spip.org/@liste_articles_bloques
function liste_objets_bloques($id_auteur=null){
	if (is_null($id_auteur))
		$id_auteur = $GLOBALS['visiteur_session']['id_auteur'];

	$res = '';
	if ($GLOBALS['meta']["articles_modif"] != "non") {
		include_spip('inc/drapeau_edition');
		$objets_ouverts = liste_drapeau_edition($id_auteur);
		if (count($objets_ouverts)) {
			$res .= recuperer_fond('prive/objets/liste/objets-en-edition',array(),array('ajax'=>true));
		}
	}
	return $res;
}

//
// Fin de page de l'interface privee.
// Elle comporte une image invisible declenchant une tache de fond

// http://doc.spip.org/@fin_page
function fin_page()
{
	global $spip_display, $tableau_des_temps;

	$debug = ((_request('exec') !== 'valider_xml')  AND ((_request('var_mode') == 'debug') OR $tableau_des_temps AND isset($_COOKIE['spip_admin'])));

	// avec &var_profile=1 on a le tableau de mesures SQL
	if ($debug) {
		$chrono = erreur_squelette();
	} else $chrono = '';
	
	if (_SPIP_AJAX AND !defined('_TESTER_NOSCRIPT')) {
	  // pour le pied de page (deja defini si on est validation XML)
		define('_TESTER_NOSCRIPT',
			"<noscript>\n<div style='display:none;'><img src='"
		        . generer_url_ecrire('test_ajax', 'js=-1')
		        . "' width='1' height='1' alt='' /></div></noscript>\n");
	}

	return debut_grand_cadre(true)
	. (($spip_display == 4)
		? ("<div><a href='"
		   . generer_action_auteur('preferer','display:2', self('&'))
			. "'>"
			.  _T("access_interface_graphique")
			. "</a></div>")
		: ("<div id='copyright'>"

			. info_maj_spip()
			. info_copyright()
			. "<br />"
		 	. _T('info_copyright_doc',
				array('spipnet' => $GLOBALS['home_server']
				      . '/' .    $GLOBALS['spip_lang']))
			     . '</div>'))

	. fin_grand_cadre(true)
	. "</div>\n" // cf. div centered ouverte dans conmmencer_page()
	. $GLOBALS['rejoue_session']
	. '<div style="background-image: url(\''
	. generer_url_action('cron')
	. '\');"></div>'
	. (defined('_TESTER_NOSCRIPT') ? _TESTER_NOSCRIPT : '')
	   . $chrono
	. "</body></html>\n";
}

function info_maj_spip(){

	$maj = $GLOBALS['meta']['info_maj_spip'];
	if (!$maj)
		return "";

	$maj = explode('|',$maj);
	// c'est une ancienne notif, on a fait la maj depuis !
	if ($GLOBALS['spip_version_branche']!==reset($maj))
		return "";

	if (!autoriser('webmestre'))
		return "";

	array_shift($maj);
	$maj = implode('|',$maj);

	return "$maj<br />";
}

// http://doc.spip.org/@info_copyright
function info_copyright() {
	global $spip_version_affichee, $spip_lang;

	$version = $spip_version_affichee;

	//
	// Mention, le cas echeant, de la revision SVN courante
	//
	if ($svn_revision = version_svn_courante(_DIR_RACINE)) {
		$version .= ' ' . (($svn_revision < 0) ? 'SVN ':'')
		. "[<a href='http://core.spip.org/trac/spip/changeset/"
		. abs($svn_revision) . "' onclick=\"window.open(this.href); return false;\">"
		. abs($svn_revision) . "</a>]";
	}

	// et la version de l'ecran de securite
	$secu = defined('_ECRAN_SECURITE')
		? "<br />"._L(' + ecran_securite v&nbsp;')._ECRAN_SECURITE
		: '';

	return _T('info_copyright',
		   array('spip' => "<b>SPIP $version</b> ",
			 'lien_gpl' =>
			 "<a href='". generer_url_ecrire("aide_index", "aide=licence&var_lang=$spip_lang") . "' onclick=\"window.open(this.href, 'spip_aide', 'scrollbars=yes,resizable=yes,width=740,height=580'); return false;\">" . _T('info_copyright_gpl')."</a>"))
		. $secu;

}

// http://doc.spip.org/@formulaire_recherche
function formulaire_recherche($page, $complement=""){
	$recherche = _request('recherche');
	$recherche_aff = entites_html($recherche);
	if (!strlen($recherche)) {
		$recherche_aff = _T('info_rechercher');
		$onfocus = " onfocus=\"this.value='';\"";
	} else $onfocus = '';

	$form = '<input type="text" size="10" value="'.$recherche_aff.'" name="recherche" class="recherche" accesskey="r"' . $onfocus . ' />';
	$form .= "<input type='image' src='" . chemin_image('rechercher-20.png') . "' name='submit' class='submit' alt='"._T('info_rechercher')."' />";
	return "<div class='spip_recherche'>".generer_form_ecrire($page, $form . $complement, " method='get'")."</div>";
}

?>
