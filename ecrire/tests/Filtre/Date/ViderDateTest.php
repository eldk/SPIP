<?php

declare(strict_types=1);

/**
 * Test unitaire de la fonction vider_date du fichier inc/filtres.php
 */

namespace Spip\Test\Filtre\Date;

use PHPUnit\Framework\TestCase;

class ViderDateTest extends TestCase
{
	public static function setUpBeforeClass(): void
	{
		find_in_path('inc/filtres.php', '', true);
	}

	/**
	 * @dataProvider providerFiltresViderDate
	 */
	public function testFiltresViderDate($expected, ...$args): void
	{
		$actual = vider_date(...$args);
		$this->assertSame($expected, $actual);
	}

	public static function providerFiltresViderDate(): array
	{
		return [
			0 => [
				0 => '2001-00-00 12:33:44',
				1 => '2001-00-00 12:33:44',
			],
			1 => [
				0 => '2001-03-00 09:12:57',
				1 => '2001-03-00 09:12:57',
			],
			2 => [
				0 => '2001-02-29 14:12:33',
				1 => '2001-02-29 14:12:33',
			],
			3 => [
				0 => '',
				1 => '0000-00-00',
			],
			4 => [
				0 => '',
				1 => '0001-01-01',
			],
			5 => [
				0 => '',
				1 => '1970-01-01',
			],
			6 => [
				0 => '2001-07-05 18:25:24',
				1 => '2001-07-05 18:25:24',
			],
			7 => [
				0 => '2001-01-01 00:00:00',
				1 => '2001-01-01 00:00:00',
			],
			8 => [
				0 => '2001-12-31 23:59:59',
				1 => '2001-12-31 23:59:59',
			],
			9 => [
				0 => '2001-03-01 14:12:33',
				1 => '2001-03-01 14:12:33',
			],
			10 => [
				0 => '2004-02-29 14:12:33',
				1 => '2004-02-29 14:12:33',
			],
			11 => [
				0 => '2012-03-20 12:00:00',
				1 => '2012-03-20 12:00:00',
			],
			12 => [
				0 => '2012-03-21 12:00:00',
				1 => '2012-03-21 12:00:00',
			],
			13 => [
				0 => '2012-03-22 12:00:00',
				1 => '2012-03-22 12:00:00',
			],
			14 => [
				0 => '2012-06-20 12:00:00',
				1 => '2012-06-20 12:00:00',
			],
			15 => [
				0 => '2012-06-21 12:00:00',
				1 => '2012-06-21 12:00:00',
			],
			16 => [
				0 => '2012-06-22 12:00:00',
				1 => '2012-06-22 12:00:00',
			],
			17 => [
				0 => '2012-09-20 12:00:00',
				1 => '2012-09-20 12:00:00',
			],
			18 => [
				0 => '2012-09-21 12:00:00',
				1 => '2012-09-21 12:00:00',
			],
			19 => [
				0 => '2012-09-22 12:00:00',
				1 => '2012-09-22 12:00:00',
			],
			20 => [
				0 => '2012-12-20 12:00:00',
				1 => '2012-12-20 12:00:00',
			],
			21 => [
				0 => '2012-12-21 12:00:00',
				1 => '2012-12-21 12:00:00',
			],
			22 => [
				0 => '2012-12-22 12:00:00',
				1 => '2012-12-22 12:00:00',
			],
			23 => [
				0 => '2001-07-05',
				1 => '2001-07-05',
			],
			24 => [
				0 => '2001-01-01',
				1 => '2001-01-01',
			],
			25 => [
				0 => '2001-12-31',
				1 => '2001-12-31',
			],
			26 => [
				0 => '2001-03-01',
				1 => '2001-03-01',
			],
			27 => [
				0 => '2004-02-29',
				1 => '2004-02-29',
			],
			28 => [
				0 => '2012-03-20',
				1 => '2012-03-20',
			],
			29 => [
				0 => '2012-03-21',
				1 => '2012-03-21',
			],
			30 => [
				0 => '2012-03-22',
				1 => '2012-03-22',
			],
			31 => [
				0 => '2012-06-20',
				1 => '2012-06-20',
			],
			32 => [
				0 => '2012-06-21',
				1 => '2012-06-21',
			],
			33 => [
				0 => '2012-06-22',
				1 => '2012-06-22',
			],
			34 => [
				0 => '2012-09-20',
				1 => '2012-09-20',
			],
			35 => [
				0 => '2012-09-21',
				1 => '2012-09-21',
			],
			36 => [
				0 => '2012-09-22',
				1 => '2012-09-22',
			],
			37 => [
				0 => '2012-12-20',
				1 => '2012-12-20',
			],
			38 => [
				0 => '2012-12-21',
				1 => '2012-12-21',
			],
			39 => [
				0 => '2012-12-22',
				1 => '2012-12-22',
			],
			40 => [
				0 => '2001/07/05',
				1 => '2001/07/05',
			],
			41 => [
				0 => '2001/01/01',
				1 => '2001/01/01',
			],
			42 => [
				0 => '2001/12/31',
				1 => '2001/12/31',
			],
			43 => [
				0 => '2001/03/01',
				1 => '2001/03/01',
			],
			44 => [
				0 => '2004/02/29',
				1 => '2004/02/29',
			],
			45 => [
				0 => '2012/03/20',
				1 => '2012/03/20',
			],
			46 => [
				0 => '2012/03/21',
				1 => '2012/03/21',
			],
			47 => [
				0 => '2012/03/22',
				1 => '2012/03/22',
			],
			48 => [
				0 => '2012/06/20',
				1 => '2012/06/20',
			],
			49 => [
				0 => '2012/06/21',
				1 => '2012/06/21',
			],
			50 => [
				0 => '2012/06/22',
				1 => '2012/06/22',
			],
			51 => [
				0 => '2012/09/20',
				1 => '2012/09/20',
			],
			52 => [
				0 => '2012/09/21',
				1 => '2012/09/21',
			],
			53 => [
				0 => '2012/09/22',
				1 => '2012/09/22',
			],
			54 => [
				0 => '2012/12/20',
				1 => '2012/12/20',
			],
			55 => [
				0 => '2012/12/21',
				1 => '2012/12/21',
			],
			56 => [
				0 => '2012/12/22',
				1 => '2012/12/22',
			],
			57 => [
				0 => '05/07/2001',
				1 => '05/07/2001',
			],
			58 => [
				0 => '01/01/2001',
				1 => '01/01/2001',
			],
			59 => [
				0 => '31/12/2001',
				1 => '31/12/2001',
			],
			60 => [
				0 => '01/03/2001',
				1 => '01/03/2001',
			],
			61 => [
				0 => '29/02/2004',
				1 => '29/02/2004',
			],
			62 => [
				0 => '20/03/2012',
				1 => '20/03/2012',
			],
			63 => [
				0 => '21/03/2012',
				1 => '21/03/2012',
			],
			64 => [
				0 => '22/03/2012',
				1 => '22/03/2012',
			],
			65 => [
				0 => '20/06/2012',
				1 => '20/06/2012',
			],
			66 => [
				0 => '21/06/2012',
				1 => '21/06/2012',
			],
			67 => [
				0 => '22/06/2012',
				1 => '22/06/2012',
			],
			68 => [
				0 => '20/09/2012',
				1 => '20/09/2012',
			],
			69 => [
				0 => '21/09/2012',
				1 => '21/09/2012',
			],
			70 => [
				0 => '22/09/2012',
				1 => '22/09/2012',
			],
			71 => [
				0 => '20/12/2012',
				1 => '20/12/2012',
			],
			72 => [
				0 => '21/12/2012',
				1 => '21/12/2012',
			],
			73 => [
				0 => '22/12/2012',
				1 => '22/12/2012',
			],
		];
	}
}
