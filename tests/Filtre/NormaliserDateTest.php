<?php

/**
 * Test unitaire de la fonction normaliser_date
 * du fichier inc/filtres.php
 *
 */
namespace Spip\Core\Tests\Filtre;

use PHPUnit\Framework\TestCase;
class NormaliserDateTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        find_in_path("inc/filtres.php", '', true);
    }
    public function setUp(): void
    {
        // Pour que le tests soit independant de la timezone du serveur
        date_default_timezone_set('Europe/Paris');
    }
    /** @dataProvider providerFiltresNormaliserDate */
    public function testFiltresNormaliserDate($expected, ...$args): void
    {
        $actual = normaliser_date(...$args);
        $this->assertSame($expected, $actual);
        $this->assertEquals($expected, $actual);
    }
    public function providerFiltresNormaliserDate(): array
    {
        return [0 => [0 => '2001-01-01 12:33:44', 1 => '2001-00-00 12:33:44', 2 => true], 1 => [0 => '2001-00-00 12:33:44', 1 => '2001-00-00 12:33:44', 2 => false], 2 => [0 => '2001-03-01 09:12:57', 1 => '2001-03-00 09:12:57', 2 => true], 3 => [0 => '2001-03-00 09:12:57', 1 => '2001-03-00 09:12:57', 2 => false], 4 => [0 => '2001-03-01 14:12:33', 1 => '2001-02-29 14:12:33', 2 => true], 5 => [0 => '2001-03-01 14:12:33', 1 => '2001-02-29 14:12:33', 2 => false], 6 => [0 => '2001-07-05 18:25:24', 1 => '2001-07-05 18:25:24', 2 => true], 7 => [0 => '2001-07-05 18:25:24', 1 => '2001-07-05 18:25:24', 2 => false], 8 => [0 => '2001-01-01 00:00:00', 1 => '2001-01-01 00:00:00', 2 => true], 9 => [0 => '2001-01-01 00:00:00', 1 => '2001-01-01 00:00:00', 2 => false], 10 => [0 => '2001-12-31 23:59:59', 1 => '2001-12-31 23:59:59', 2 => true], 11 => [0 => '2001-12-31 23:59:59', 1 => '2001-12-31 23:59:59', 2 => false], 12 => [0 => '2001-03-01 14:12:33', 1 => '2001-03-01 14:12:33', 2 => true], 13 => [0 => '2001-03-01 14:12:33', 1 => '2001-03-01 14:12:33', 2 => false], 14 => [0 => '2004-02-29 14:12:33', 1 => '2004-02-29 14:12:33', 2 => true], 15 => [0 => '2004-02-29 14:12:33', 1 => '2004-02-29 14:12:33', 2 => false], 16 => [0 => '2012-03-20 12:00:00', 1 => '2012-03-20 12:00:00', 2 => true], 17 => [0 => '2012-03-20 12:00:00', 1 => '2012-03-20 12:00:00', 2 => false], 18 => [0 => '2012-03-21 12:00:00', 1 => '2012-03-21 12:00:00', 2 => true], 19 => [0 => '2012-03-21 12:00:00', 1 => '2012-03-21 12:00:00', 2 => false], 20 => [0 => '2012-03-22 12:00:00', 1 => '2012-03-22 12:00:00', 2 => true], 21 => [0 => '2012-03-22 12:00:00', 1 => '2012-03-22 12:00:00', 2 => false], 22 => [0 => '2012-06-20 12:00:00', 1 => '2012-06-20 12:00:00', 2 => true], 23 => [0 => '2012-06-20 12:00:00', 1 => '2012-06-20 12:00:00', 2 => false], 24 => [0 => '2012-06-21 12:00:00', 1 => '2012-06-21 12:00:00', 2 => true], 25 => [0 => '2012-06-21 12:00:00', 1 => '2012-06-21 12:00:00', 2 => false], 26 => [0 => '2012-06-22 12:00:00', 1 => '2012-06-22 12:00:00', 2 => true], 27 => [0 => '2012-06-22 12:00:00', 1 => '2012-06-22 12:00:00', 2 => false], 28 => [0 => '2012-09-20 12:00:00', 1 => '2012-09-20 12:00:00', 2 => true], 29 => [0 => '2012-09-20 12:00:00', 1 => '2012-09-20 12:00:00', 2 => false], 30 => [0 => '2012-09-21 12:00:00', 1 => '2012-09-21 12:00:00', 2 => true], 31 => [0 => '2012-09-21 12:00:00', 1 => '2012-09-21 12:00:00', 2 => false], 32 => [0 => '2012-09-22 12:00:00', 1 => '2012-09-22 12:00:00', 2 => true], 33 => [0 => '2012-09-22 12:00:00', 1 => '2012-09-22 12:00:00', 2 => false], 34 => [0 => '2012-12-20 12:00:00', 1 => '2012-12-20 12:00:00', 2 => true], 35 => [0 => '2012-12-20 12:00:00', 1 => '2012-12-20 12:00:00', 2 => false], 36 => [0 => '2012-12-21 12:00:00', 1 => '2012-12-21 12:00:00', 2 => true], 37 => [0 => '2012-12-21 12:00:00', 1 => '2012-12-21 12:00:00', 2 => false], 38 => [0 => '2012-12-22 12:00:00', 1 => '2012-12-22 12:00:00', 2 => true], 39 => [0 => '2012-12-22 12:00:00', 1 => '2012-12-22 12:00:00', 2 => false], 40 => [0 => '2001-07-05 00:00:00', 1 => '2001-07-05', 2 => true], 41 => [0 => '2001-07-05 00:00:00', 1 => '2001-07-05', 2 => false], 42 => [0 => '2001-01-01 00:00:00', 1 => '2001-01-01', 2 => true], 43 => [0 => '2001-01-01 00:00:00', 1 => '2001-01-01', 2 => false], 44 => [0 => '2001-12-31 00:00:00', 1 => '2001-12-31', 2 => true], 45 => [0 => '2001-12-31 00:00:00', 1 => '2001-12-31', 2 => false], 46 => [0 => '2001-03-01 00:00:00', 1 => '2001-03-01', 2 => true], 47 => [0 => '2001-03-01 00:00:00', 1 => '2001-03-01', 2 => false], 48 => [0 => '2004-02-29 00:00:00', 1 => '2004-02-29', 2 => true], 49 => [0 => '2004-02-29 00:00:00', 1 => '2004-02-29', 2 => false], 50 => [0 => '2012-03-20 00:00:00', 1 => '2012-03-20', 2 => true], 51 => [0 => '2012-03-20 00:00:00', 1 => '2012-03-20', 2 => false], 52 => [0 => '2012-03-21 00:00:00', 1 => '2012-03-21', 2 => true], 53 => [0 => '2012-03-21 00:00:00', 1 => '2012-03-21', 2 => false], 54 => [0 => '2012-03-22 00:00:00', 1 => '2012-03-22', 2 => true], 55 => [0 => '2012-03-22 00:00:00', 1 => '2012-03-22', 2 => false], 56 => [0 => '2012-06-20 00:00:00', 1 => '2012-06-20', 2 => true], 57 => [0 => '2012-06-20 00:00:00', 1 => '2012-06-20', 2 => false], 58 => [0 => '2012-06-21 00:00:00', 1 => '2012-06-21', 2 => true], 59 => [0 => '2012-06-21 00:00:00', 1 => '2012-06-21', 2 => false], 60 => [0 => '2012-06-22 00:00:00', 1 => '2012-06-22', 2 => true], 61 => [0 => '2012-06-22 00:00:00', 1 => '2012-06-22', 2 => false], 62 => [0 => '2012-09-20 00:00:00', 1 => '2012-09-20', 2 => true], 63 => [0 => '2012-09-20 00:00:00', 1 => '2012-09-20', 2 => false], 64 => [0 => '2012-09-21 00:00:00', 1 => '2012-09-21', 2 => true], 65 => [0 => '2012-09-21 00:00:00', 1 => '2012-09-21', 2 => false], 66 => [0 => '2012-09-22 00:00:00', 1 => '2012-09-22', 2 => true], 67 => [0 => '2012-09-22 00:00:00', 1 => '2012-09-22', 2 => false], 68 => [0 => '2012-12-20 00:00:00', 1 => '2012-12-20', 2 => true], 69 => [0 => '2012-12-20 00:00:00', 1 => '2012-12-20', 2 => false], 70 => [0 => '2012-12-21 00:00:00', 1 => '2012-12-21', 2 => true], 71 => [0 => '2012-12-21 00:00:00', 1 => '2012-12-21', 2 => false], 72 => [0 => '2012-12-22 00:00:00', 1 => '2012-12-22', 2 => true], 73 => [0 => '2012-12-22 00:00:00', 1 => '2012-12-22', 2 => false], 74 => [0 => '2001-07-05 00:00:00', 1 => '2001/07/05', 2 => true], 75 => [0 => '2001-07-05 00:00:00', 1 => '2001/07/05', 2 => false], 76 => [0 => '2001-01-01 00:00:00', 1 => '2001/01/01', 2 => true], 77 => [0 => '2001-01-01 00:00:00', 1 => '2001/01/01', 2 => false], 78 => [0 => '2001-12-31 00:00:00', 1 => '2001/12/31', 2 => true], 79 => [0 => '2001-12-31 00:00:00', 1 => '2001/12/31', 2 => false], 80 => [0 => '2001-03-01 00:00:00', 1 => '2001/03/01', 2 => true], 81 => [0 => '2001-03-01 00:00:00', 1 => '2001/03/01', 2 => false], 82 => [0 => '2004-02-29 00:00:00', 1 => '2004/02/29', 2 => true], 83 => [0 => '2004-02-29 00:00:00', 1 => '2004/02/29', 2 => false], 84 => [0 => '2012-03-20 00:00:00', 1 => '2012/03/20', 2 => true], 85 => [0 => '2012-03-20 00:00:00', 1 => '2012/03/20', 2 => false], 86 => [0 => '2012-03-21 00:00:00', 1 => '2012/03/21', 2 => true], 87 => [0 => '2012-03-21 00:00:00', 1 => '2012/03/21', 2 => false], 88 => [0 => '2012-03-22 00:00:00', 1 => '2012/03/22', 2 => true], 89 => [0 => '2012-03-22 00:00:00', 1 => '2012/03/22', 2 => false], 90 => [0 => '2012-06-20 00:00:00', 1 => '2012/06/20', 2 => true], 91 => [0 => '2012-06-20 00:00:00', 1 => '2012/06/20', 2 => false], 92 => [0 => '2012-06-21 00:00:00', 1 => '2012/06/21', 2 => true], 93 => [0 => '2012-06-21 00:00:00', 1 => '2012/06/21', 2 => false], 94 => [0 => '2012-06-22 00:00:00', 1 => '2012/06/22', 2 => true], 95 => [0 => '2012-06-22 00:00:00', 1 => '2012/06/22', 2 => false], 96 => [0 => '2012-09-20 00:00:00', 1 => '2012/09/20', 2 => true], 97 => [0 => '2012-09-20 00:00:00', 1 => '2012/09/20', 2 => false], 98 => [0 => '2012-09-21 00:00:00', 1 => '2012/09/21', 2 => true], 99 => [0 => '2012-09-21 00:00:00', 1 => '2012/09/21', 2 => false], 100 => [0 => '2012-09-22 00:00:00', 1 => '2012/09/22', 2 => true], 101 => [0 => '2012-09-22 00:00:00', 1 => '2012/09/22', 2 => false], 102 => [0 => '2012-12-20 00:00:00', 1 => '2012/12/20', 2 => true], 103 => [0 => '2012-12-20 00:00:00', 1 => '2012/12/20', 2 => false], 104 => [0 => '2012-12-21 00:00:00', 1 => '2012/12/21', 2 => true], 105 => [0 => '2012-12-21 00:00:00', 1 => '2012/12/21', 2 => false], 106 => [0 => '2012-12-22 00:00:00', 1 => '2012/12/22', 2 => true], 107 => [0 => '2012-12-22 00:00:00', 1 => '2012/12/22', 2 => false], 108 => [0 => '2001-05-07 00:00:00', 1 => '05/07/2001', 2 => true], 109 => [0 => '2001-05-07 00:00:00', 1 => '05/07/2001', 2 => false], 110 => [0 => '2001-01-01 00:00:00', 1 => '01/01/2001', 2 => true], 111 => [0 => '2001-01-01 00:00:00', 1 => '01/01/2001', 2 => false], 112 => [0 => '1970-01-01 01:00:00', 1 => '31/12/2001', 2 => true], 113 => [0 => '1970-01-01 01:00:00', 1 => '31/12/2001', 2 => false], 114 => [0 => '2001-01-03 00:00:00', 1 => '01/03/2001', 2 => true], 115 => [0 => '2001-01-03 00:00:00', 1 => '01/03/2001', 2 => false], 116 => [0 => '1970-01-01 01:00:00', 1 => '29/02/2004', 2 => true], 117 => [0 => '1970-01-01 01:00:00', 1 => '29/02/2004', 2 => false], 118 => [0 => '1970-01-01 01:00:00', 1 => '20/03/2012', 2 => true], 119 => [0 => '1970-01-01 01:00:00', 1 => '20/03/2012', 2 => false], 120 => [0 => '1970-01-01 01:00:00', 1 => '21/03/2012', 2 => true], 121 => [0 => '1970-01-01 01:00:00', 1 => '21/03/2012', 2 => false], 122 => [0 => '1970-01-01 01:00:00', 1 => '22/03/2012', 2 => true], 123 => [0 => '1970-01-01 01:00:00', 1 => '22/03/2012', 2 => false], 124 => [0 => '1970-01-01 01:00:00', 1 => '20/06/2012', 2 => true], 125 => [0 => '1970-01-01 01:00:00', 1 => '20/06/2012', 2 => false], 126 => [0 => '1970-01-01 01:00:00', 1 => '21/06/2012', 2 => true], 127 => [0 => '1970-01-01 01:00:00', 1 => '21/06/2012', 2 => false], 128 => [0 => '1970-01-01 01:00:00', 1 => '22/06/2012', 2 => true], 129 => [0 => '1970-01-01 01:00:00', 1 => '22/06/2012', 2 => false], 130 => [0 => '1970-01-01 01:00:00', 1 => '20/09/2012', 2 => true], 131 => [0 => '1970-01-01 01:00:00', 1 => '20/09/2012', 2 => false], 132 => [0 => '1970-01-01 01:00:00', 1 => '21/09/2012', 2 => true], 133 => [0 => '1970-01-01 01:00:00', 1 => '21/09/2012', 2 => false], 134 => [0 => '1970-01-01 01:00:00', 1 => '22/09/2012', 2 => true], 135 => [0 => '1970-01-01 01:00:00', 1 => '22/09/2012', 2 => false], 136 => [0 => '1970-01-01 01:00:00', 1 => '20/12/2012', 2 => true], 137 => [0 => '1970-01-01 01:00:00', 1 => '20/12/2012', 2 => false], 138 => [0 => '1970-01-01 01:00:00', 1 => '21/12/2012', 2 => true], 139 => [0 => '1970-01-01 01:00:00', 1 => '21/12/2012', 2 => false], 140 => [0 => '1970-01-01 01:00:00', 1 => '22/12/2012', 2 => true], 141 => [0 => '1970-01-01 01:00:00', 1 => '22/12/2012', 2 => false]];
    }
}
