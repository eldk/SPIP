<?php

declare(strict_types=1);

/**
 * Test unitaire de la fonction nom_mois du fichier inc/filtres.php
 */

namespace Spip\Test\Filtre\Date;

use PHPUnit\Framework\TestCase;

class NomMoisTest extends TestCase
{
	public static function setUpBeforeClass(): void
	{
		find_in_path('inc/filtres.php', '', true);
	}

	protected function setUp(): void
	{
		changer_langue('fr');
		// ce test est en fr
	}

	/**
	 * @dataProvider providerFiltresNomMois
	 */
	public function testFiltresNomMois($expected, ...$args): void
	{
		$actual = nom_mois(...$args);
		$this->assertSame($expected, $actual);
	}

	public static function providerFiltresNomMois(): array
	{
		return [
			0 => [
				0 => '',
				1 => '2001-00-00 12:33:44',
			],
			1 => [
				0 => 'mars',
				1 => '2001-03-00 09:12:57',
			],
			2 => [
				0 => 'février',
				1 => '2001-02-29 14:12:33',
			],
			3 => [
				0 => '',
				1 => '0000-00-00',
			],
			4 => [
				0 => 'janvier',
				1 => '0001-01-01',
			],
			5 => [
				0 => 'janvier',
				1 => '1970-01-01',
			],
			6 => [
				0 => 'juillet',
				1 => '2001-07-05 18:25:24',
			],
			7 => [
				0 => 'janvier',
				1 => '2001-01-01 00:00:00',
			],
			8 => [
				0 => 'décembre',
				1 => '2001-12-31 23:59:59',
			],
			9 => [
				0 => 'mars',
				1 => '2001-03-01 14:12:33',
			],
			10 => [
				0 => 'février',
				1 => '2004-02-29 14:12:33',
			],
			11 => [
				0 => 'mars',
				1 => '2012-03-20 12:00:00',
			],
			12 => [
				0 => 'mars',
				1 => '2012-03-21 12:00:00',
			],
			13 => [
				0 => 'mars',
				1 => '2012-03-22 12:00:00',
			],
			14 => [
				0 => 'juin',
				1 => '2012-06-20 12:00:00',
			],
			15 => [
				0 => 'juin',
				1 => '2012-06-21 12:00:00',
			],
			16 => [
				0 => 'juin',
				1 => '2012-06-22 12:00:00',
			],
			17 => [
				0 => 'septembre',
				1 => '2012-09-20 12:00:00',
			],
			18 => [
				0 => 'septembre',
				1 => '2012-09-21 12:00:00',
			],
			19 => [
				0 => 'septembre',
				1 => '2012-09-22 12:00:00',
			],
			20 => [
				0 => 'décembre',
				1 => '2012-12-20 12:00:00',
			],
			21 => [
				0 => 'décembre',
				1 => '2012-12-21 12:00:00',
			],
			22 => [
				0 => 'décembre',
				1 => '2012-12-22 12:00:00',
			],
			23 => [
				0 => 'juillet',
				1 => '2001-07-05',
			],
			24 => [
				0 => 'janvier',
				1 => '2001-01-01',
			],
			25 => [
				0 => 'décembre',
				1 => '2001-12-31',
			],
			26 => [
				0 => 'mars',
				1 => '2001-03-01',
			],
			27 => [
				0 => 'février',
				1 => '2004-02-29',
			],
			28 => [
				0 => 'mars',
				1 => '2012-03-20',
			],
			29 => [
				0 => 'mars',
				1 => '2012-03-21',
			],
			30 => [
				0 => 'mars',
				1 => '2012-03-22',
			],
			31 => [
				0 => 'juin',
				1 => '2012-06-20',
			],
			32 => [
				0 => 'juin',
				1 => '2012-06-21',
			],
			33 => [
				0 => 'juin',
				1 => '2012-06-22',
			],
			34 => [
				0 => 'septembre',
				1 => '2012-09-20',
			],
			35 => [
				0 => 'septembre',
				1 => '2012-09-21',
			],
			36 => [
				0 => 'septembre',
				1 => '2012-09-22',
			],
			37 => [
				0 => 'décembre',
				1 => '2012-12-20',
			],
			38 => [
				0 => 'décembre',
				1 => '2012-12-21',
			],
			39 => [
				0 => 'décembre',
				1 => '2012-12-22',
			],
			40 => [
				0 => 'juillet',
				1 => '2001/07/05',
			],
			41 => [
				0 => 'janvier',
				1 => '2001/01/01',
			],
			42 => [
				0 => 'décembre',
				1 => '2001/12/31',
			],
			43 => [
				0 => 'mars',
				1 => '2001/03/01',
			],
			44 => [
				0 => 'février',
				1 => '2004/02/29',
			],
			45 => [
				0 => 'mars',
				1 => '2012/03/20',
			],
			46 => [
				0 => 'mars',
				1 => '2012/03/21',
			],
			47 => [
				0 => 'mars',
				1 => '2012/03/22',
			],
			48 => [
				0 => 'juin',
				1 => '2012/06/20',
			],
			49 => [
				0 => 'juin',
				1 => '2012/06/21',
			],
			50 => [
				0 => 'juin',
				1 => '2012/06/22',
			],
			51 => [
				0 => 'septembre',
				1 => '2012/09/20',
			],
			52 => [
				0 => 'septembre',
				1 => '2012/09/21',
			],
			53 => [
				0 => 'septembre',
				1 => '2012/09/22',
			],
			54 => [
				0 => 'décembre',
				1 => '2012/12/20',
			],
			55 => [
				0 => 'décembre',
				1 => '2012/12/21',
			],
			56 => [
				0 => 'décembre',
				1 => '2012/12/22',
			],
			57 => [
				0 => 'juillet',
				1 => '05/07/2001',
			],
			58 => [
				0 => 'janvier',
				1 => '01/01/2001',
			],
			59 => [
				0 => 'décembre',
				1 => '31/12/2001',
			],
			60 => [
				0 => 'mars',
				1 => '01/03/2001',
			],
			61 => [
				0 => 'février',
				1 => '29/02/2004',
			],
			62 => [
				0 => 'mars',
				1 => '20/03/2012',
			],
			63 => [
				0 => 'mars',
				1 => '21/03/2012',
			],
			64 => [
				0 => 'mars',
				1 => '22/03/2012',
			],
			65 => [
				0 => 'juin',
				1 => '20/06/2012',
			],
			66 => [
				0 => 'juin',
				1 => '21/06/2012',
			],
			67 => [
				0 => 'juin',
				1 => '22/06/2012',
			],
			68 => [
				0 => 'septembre',
				1 => '20/09/2012',
			],
			69 => [
				0 => 'septembre',
				1 => '21/09/2012',
			],
			70 => [
				0 => 'septembre',
				1 => '22/09/2012',
			],
			71 => [
				0 => 'décembre',
				1 => '20/12/2012',
			],
			72 => [
				0 => 'décembre',
				1 => '21/12/2012',
			],
			73 => [
				0 => 'décembre',
				1 => '22/12/2012',
			],
		];
	}
}
