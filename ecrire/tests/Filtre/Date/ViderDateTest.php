<?php

declare(strict_types=1);

/**
 * Test unitaire de la fonction vider_date du fichier inc/filtres.php
 */

namespace Spip\Test\Filtre\Date;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ViderDateTest extends TestCase
{
	public static function setUpBeforeClass(): void {
		find_in_path('inc/filtres.php', '', true);
	}

	#[DataProvider('providerFiltresViderDate')]
	public function testFiltresViderDate($expected, ...$args): void {
		$actual = vider_date(...$args);
		$this->assertSame($expected, $actual);
	}

	public static function providerFiltresViderDate(): array {
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
				0 => '2012-12-22 12:00:00',
				1 => '2012-12-22 12:00:00',
			],
			13 => [
				0 => '2001-07-05',
				1 => '2001-07-05',
			],
			14 => [
				0 => '2001-01-01',
				1 => '2001-01-01',
			],
			15 => [
				0 => '2001-12-31',
				1 => '2001-12-31',
			],
			16 => [
				0 => '2001-03-01',
				1 => '2001-03-01',
			],
			17 => [
				0 => '2004-02-29',
				1 => '2004-02-29',
			],
			18 => [
				0 => '2012-03-20',
				1 => '2012-03-20',
			],
			19 => [
				0 => '2012-12-22',
				1 => '2012-12-22',
			],
			20 => [
				0 => '2001/07/05',
				1 => '2001/07/05',
			],
			21 => [
				0 => '2001/01/01',
				1 => '2001/01/01',
			],
			22 => [
				0 => '2001/12/31',
				1 => '2001/12/31',
			],
			23 => [
				0 => '2001/03/01',
				1 => '2001/03/01',
			],
			24 => [
				0 => '2004/02/29',
				1 => '2004/02/29',
			],
			25 => [
				0 => '2012/03/20',
				1 => '2012/03/20',
			],
			26 => [
				0 => '2012/12/22',
				1 => '2012/12/22',
			],
			27 => [
				0 => '05/07/2001',
				1 => '05/07/2001',
			],
			28 => [
				0 => '01/01/2001',
				1 => '01/01/2001',
			],
			29 => [
				0 => '31/12/2001',
				1 => '31/12/2001',
			],
			30 => [
				0 => '01/03/2001',
				1 => '01/03/2001',
			],
			31 => [
				0 => '29/02/2004',
				1 => '29/02/2004',
			],
			32 => [
				0 => '20/03/2012',
				1 => '20/03/2012',
			],
			33 => [
				0 => '22/12/2012',
				1 => '22/12/2012',
			],
		];
	}
}
