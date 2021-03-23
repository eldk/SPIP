<?php

/**
 * Collection de variables CSS
 * @internal
 */
class Spip_Css_Vars_Collection {
    private $vars = [];

    public function add(string $var, string $value) {
        $this->vars[$var] = $value;
    }

    public function getString() : string {
        $string = "";
        foreach ($this->vars as $key => $value) {
            $string .= "$key: $value;\n";
        }
        return $string;
    }

    public function __toString() : string {
        return $this->getString();
    }
}


/**
 * Génère les variables CSS relatif à la typo et langue pour l'espace privé
 *
 * @param Pile $pile Pile
 */
function spip_generer_variables_css_typo(array $Pile) : \Spip_Css_Vars_Collection {
    $vars = new \Spip_Css_Vars_Collection();

	$vars->add("--spip-css-dir", $Pile[0]["dir"]);
	$vars->add("--spip-css-left", $Pile[0]["left"]);
	$vars->add("--spip-css-right", $Pile[0]["right"]);

	$vars->add("--spip-css-font-size", $Pile[0]["font-size"]);
	$vars->add("--spip-css-line-heigh",  $Pile[0]["line-height"]);
	$vars->add("--spip-css-margin-bottom", $Pile[0]["margin-bottom"]);
	$vars->add("--spip-css-text-indent", $Pile[0]["text-indent"]);
	$vars->add("--spip-css-font-family", $Pile[0]["font-family"]);
	$vars->add("--spip-css-background-color", $Pile[0]["background-color"]);
	$vars->add("--spip-css-color", $Pile[0]["color"]);

    return $vars;
}

/**
 * Génère les variables CSS d'un thème de couleur pour l'espace privé
 *
 * @param string $couleur Couleur hex
 */
function spip_generer_variables_css_couleurs_theme(string $couleur) : \Spip_Css_Vars_Collection {
    $vars = new \Spip_Css_Vars_Collection();

    $vars->add("--spip-color-theme--hsl", couleur_hex_to_hsl($couleur, "h, s, l"));
    $vars->add("--spip-color-theme--h", couleur_hex_to_hsl($couleur, "h"));
    $vars->add("--spip-color-theme--s", couleur_hex_to_hsl($couleur, "s"));
    $vars->add("--spip-color-theme--l", couleur_hex_to_hsl($couleur, "l"));

    // un joli dégradé de presque blanc à presque noir…
    $vars->add("--spip-color-theme--100", '#' . couleur_eclaircir($couleur, .99));
    $vars->add("--spip-color-theme--98", '#' . couleur_eclaircir($couleur, .95));
    $vars->add("--spip-color-theme--95", '#' . couleur_eclaircir($couleur, .90));
    $vars->add("--spip-color-theme--90", '#' . couleur_eclaircir($couleur, .75));
    $vars->add("--spip-color-theme--80", '#' . couleur_eclaircir($couleur, .50));
    $vars->add("--spip-color-theme--70", '#' . couleur_eclaircir($couleur, .25));
    $vars->add("--spip-color-theme--60", $couleur);
    $vars->add("--spip-color-theme--50", '#' . couleur_foncer($couleur, .125));
    $vars->add("--spip-color-theme--40", '#' . couleur_foncer($couleur, .25));
    $vars->add("--spip-color-theme--30", '#' . couleur_foncer($couleur, .375));
    $vars->add("--spip-color-theme--20", '#' . couleur_foncer($couleur, .50));
    $vars->add("--spip-color-theme--10", '#' . couleur_foncer($couleur, .75));
    $vars->add("--spip-color-theme--00", '#' . couleur_foncer($couleur, .98));

    return $vars;
}

/**
 * Génère les variables CSS dépendantes des couleurs du thème actif.
 */
function spip_generer_variables_css_couleurs_actives() : \Spip_Css_Vars_Collection {
    $vars = new \Spip_Css_Vars_Collection();

    // nos déclinaisons (basées sur le dégradé précedent, où 60 est là couleur du thème)
    $vars->add("--spip-color-theme-white", "var(--spip-color-theme--100)");
    $vars->add("--spip-color-theme-lightest", "var(--spip-color-theme--95)");
    $vars->add("--spip-color-theme-lighter", "var(--spip-color-theme--90)");
    $vars->add("--spip-color-theme-light", "var(--spip-color-theme--80)");
    $vars->add("--spip-color-theme", "var(--spip-color-theme--60)");
    $vars->add("--spip-color-theme-dark", "var(--spip-color-theme--40)");
    $vars->add("--spip-color-theme-darker", "var(--spip-color-theme--20)");
    $vars->add("--spip-color-theme-darkest", "var(--spip-color-theme--10)");
    $vars->add("--spip-color-theme-black", "var(--spip-color-theme--00)");

    return $vars;
}