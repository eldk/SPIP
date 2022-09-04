<?php
/**
 * Test unitaire de la fonction extraire_multi
 * du fichier ./inc/filtres.php
 *
 */
namespace Spip\Core\Tests;

find_in_path("./inc/filtres.php",'',true);
find_in_path("./inc/lang.php",'',true);

/**
 * La fonction appelee pour chaque jeu de test
 * Nommage conventionnel : test_[[dossier1_][[dossier2_]...]]fichier
 * @param ...$args
 * @return mixed
 */
function test_filtres_extraire_multi(...$args) {
	return extraire_multi(...$args);
}


/**
 * La fonction qui fournit les jeux de test
 * Nommage conventionnel : essais_[[dossier1_][[dossier2_]...]]fichier
 * @return array
 *  [ output, input1, input2, input3...]
 */
function essais_filtres_extraire_multi(){
		return [
  0 => 
   [
    0 => 'english',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'en',
  ],
  1 => 
   [
    0 => 'deutsch',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'de',
  ],
  2 => 
   [
    0 => 'francais',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'fr',
  ],
  3 => 
   [
    0 => "<span lang='fr'>francais</span>",
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'it',
  ],
  4 => 
   [
    0 => "<span lang='fr' dir='ltr'>francais</span>",
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'ar',
  ],
  5 => 
   [
    0 => 'english',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'en',
    3 => true,
  ],
  6 => 
   [
    0 => 'deutsch',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'de',
    3 => true,
  ],
  7 => 
   [
    0 => 'francais',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'fr',
    3 => true,
  ],
  8 => 
   [
    0 => '<span class="base64multi" title="ZnJhbmNhaXM=" lang="fr"></span>',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'it',
    3 => true,
  ],
  9 => 
   [
    0 => '<span class="base64multi" title="ZnJhbmNhaXM=" lang="fr" dir="ltr"></span>',
    1 => '<multi>[fr]francais[en]english[de]deutsch</multi>',
    2 => 'ar',
    3 => true,
  ],
];
	}
