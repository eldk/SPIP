<?php

declare(strict_types=1);

namespace Spip\Core\Tests\Squelettes\Balise;

use Spip\Core\Testing\SquelettesTestCase;
use Spip\Core\Testing\Templating;

class BaliseDetacheeTest extends SquelettesTestCase
{
	public function testNecessiteNomSite(): void
	{
		$this->assertNotEmptyCode('<BOUCLE_meta(spip_meta){nom=nom_site}>#VALEUR</BOUCLE_meta>');
	}

	/**
	 * @depends testNecessiteNomSite
	 */
	public function testBaliseDetacheeInterne(): void
	{
		$templating = Templating::fromString();
		$expected = $templating->render('<BOUCLE_meta(spip_meta){nom=nom_site}>#VALEUR</BOUCLE_meta>');
		$actual = $templating->render(
			'<BOUCLE_meta(spip_meta){nom=nom_site}>
				<BOUCLE_meta2(spip_meta){nom=adresse_site}>
					#_meta:VALEUR
				</BOUCLE_meta2>
			</BOUCLE_meta>'
		);

		$this->assertEquals($expected, trim($actual));
	}

	public function testBaliseDetacheeHorsBoucle(): void
	{
		// en dehors de sa boucle, une balise detachee n'est pas reconnue
		$this->assertEmptyCode(
			'<BOUCLE_meta(spip_meta){nom=nom_site}></BOUCLE_meta>
			<BOUCLE_meta2(spip_meta){nom=version_base}>#_meta:VALEUR</BOUCLE_meta2>'
		);
	}

	/**
	 * @depends testBaliseDetacheeInterne
	 */
	public function testBaliseDetacheeComplexe(): void
	{
		$this->assertOkSquelette(__DIR__ . '/data/balise_detachee.html');
	}
}
