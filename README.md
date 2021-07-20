# Tests pour SPIP

Suite de tests bas�e sur PHPUnit, avec un wrapper pour les tests historiques �crits en script PHP standalone ou en squelette HTML

## Installation

```
git clone https://git.spip.net/spip/tests.git
cd tests
composer install
```

## Lancer tous les tests

Lancer

```
vendor/bin/phpunit --colors tests
```

Pour voir le d�tail de tous les tests lanc�s (y compris leurs noms)

```
vendor/bin/phpunit --colors --debug tests
```


Pour filtrer les tests et n'en executer que certains :
```
vendor/bin/phpunit --colors --debug tests --filter=unit/propre/
```

## Ajouter des tests

TODO

## Legacy

Les tests historiques �crits sous forme de PHP ou de squelette HTML sont jou�s via les 2 composants `LegacyUnitHtmlTest.php` et `LegacyUnitPhpTest.php`

Il est encore possible de lancer dans le navigateur la suite de tests legacy via l'url `monsite.spip/tests/` mais cette m�thode est depr�ci�e et ne lancera pas les tests �crits directement pour PHPUnit
