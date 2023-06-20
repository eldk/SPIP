<?php

declare(strict_types=1);

namespace Spip\Test\Squelettes\Balise;

use Spip\Test\SquelettesTestCase;
use Spip\Test\Templating;

/**
 * FIXME: Déplacer dans le plugin Medias
 */
class MimeTypeTest extends SquelettesTestCase
{
	public function testMimeTypeDocumentJpg() {
		$templating = Templating::fromString();
		$result = $templating->render(
			"<BOUCLE_d(DOCUMENTS){extension IN jpg}{0,1}>
				[(#MIME_TYPE|match{^image/jpeg$}|?{OK, erreur mime_type : #MIME_TYPE})]
			</BOUCLE_d>
			NA Ce test ne fonctionne que s'il y a au moins un document jpg dans le site !
			<//B_d>"
		);
		if ($this->isNa($result)) {
			$this->markTestSkipped($result);
		}

		$this->assertOkCode($result);
	}
}
