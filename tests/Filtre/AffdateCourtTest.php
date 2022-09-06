<?php

/**
 * Test unitaire de la fonction affdate_court
 * du fichier inc/filtres.php
 *
 */
namespace Spip\Core\Tests\Filtre;

use PHPUnit\Framework\TestCase;
class AffdateCourtTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        find_in_path("inc/filtres.php", '', true);
    }
    /** @dataProvider providerFiltresAffdateCourt */
    public function testFiltresAffdateCourt($expected, ...$args): void
    {
        changer_langue('fr');
        $actual = affdate_court(...$args);
        $this->assertSame($expected, $actual);
        $this->assertEquals($expected, $actual);
    }
    public function providerFiltresAffdateCourt(): array
    {
        return [0 => [0 => ' 2001', 1 => '2001-00-00 12:33:44', 2 => '2011'], 1 => [0 => 'Mars 2001', 1 => '2001-03-00 09:12:57', 2 => '2011'], 2 => [0 => 'Février 2001', 1 => '2001-02-29 14:12:33', 2 => '2011'], 3 => [0 => '0000', 1 => '0000-00-00', 2 => '2011'], 4 => [0 => '0001', 1 => '0001-01-01', 2 => '2011'], 5 => [0 => 'Janvier 1970', 1 => '1970-01-01', 2 => '2011'], 6 => [0 => 'Juillet 2001', 1 => '2001-07-05 18:25:24', 2 => '2011'], 7 => [0 => 'Janvier 2001', 1 => '2001-01-01 00:00:00', 2 => '2011'], 8 => [0 => 'Décembre 2001', 1 => '2001-12-31 23:59:59', 2 => '2011'], 9 => [0 => 'Mars 2001', 1 => '2001-03-01 14:12:33', 2 => '2011'], 10 => [0 => 'Février 2004', 1 => '2004-02-29 14:12:33', 2 => '2011'], 11 => [0 => 'Mars 2012', 1 => '2012-03-20 12:00:00', 2 => '2011'], 12 => [0 => 'Mars 2012', 1 => '2012-03-21 12:00:00', 2 => '2011'], 13 => [0 => 'Mars 2012', 1 => '2012-03-22 12:00:00', 2 => '2011'], 14 => [0 => 'Juin 2012', 1 => '2012-06-20 12:00:00', 2 => '2011'], 15 => [0 => 'Juin 2012', 1 => '2012-06-21 12:00:00', 2 => '2011'], 16 => [0 => 'Juin 2012', 1 => '2012-06-22 12:00:00', 2 => '2011'], 17 => [0 => 'Septembre 2012', 1 => '2012-09-20 12:00:00', 2 => '2011'], 18 => [0 => 'Septembre 2012', 1 => '2012-09-21 12:00:00', 2 => '2011'], 19 => [0 => 'Septembre 2012', 1 => '2012-09-22 12:00:00', 2 => '2011'], 20 => [0 => 'Décembre 2012', 1 => '2012-12-20 12:00:00', 2 => '2011'], 21 => [0 => 'Décembre 2012', 1 => '2012-12-21 12:00:00', 2 => '2011'], 22 => [0 => 'Décembre 2012', 1 => '2012-12-22 12:00:00', 2 => '2011'], 23 => [0 => 'Juillet 2001', 1 => '2001-07-05', 2 => '2011'], 24 => [0 => 'Janvier 2001', 1 => '2001-01-01', 2 => '2011'], 25 => [0 => 'Décembre 2001', 1 => '2001-12-31', 2 => '2011'], 26 => [0 => 'Mars 2001', 1 => '2001-03-01', 2 => '2011'], 27 => [0 => 'Février 2004', 1 => '2004-02-29', 2 => '2011'], 28 => [0 => 'Mars 2012', 1 => '2012-03-20', 2 => '2011'], 29 => [0 => 'Mars 2012', 1 => '2012-03-21', 2 => '2011'], 30 => [0 => 'Mars 2012', 1 => '2012-03-22', 2 => '2011'], 31 => [0 => 'Juin 2012', 1 => '2012-06-20', 2 => '2011'], 32 => [0 => 'Juin 2012', 1 => '2012-06-21', 2 => '2011'], 33 => [0 => 'Juin 2012', 1 => '2012-06-22', 2 => '2011'], 34 => [0 => 'Septembre 2012', 1 => '2012-09-20', 2 => '2011'], 35 => [0 => 'Septembre 2012', 1 => '2012-09-21', 2 => '2011'], 36 => [0 => 'Septembre 2012', 1 => '2012-09-22', 2 => '2011'], 37 => [0 => 'Décembre 2012', 1 => '2012-12-20', 2 => '2011'], 38 => [0 => 'Décembre 2012', 1 => '2012-12-21', 2 => '2011'], 39 => [0 => 'Décembre 2012', 1 => '2012-12-22', 2 => '2011'], 40 => [0 => 'Juillet 2005', 1 => '2001/07/05', 2 => '2011'], 41 => [0 => 'Janvier 2001', 1 => '2001/01/01', 2 => '2011'], 42 => [0 => 'Décembre 2031', 1 => '2001/12/31', 2 => '2011'], 43 => [0 => 'Mars 2001', 1 => '2001/03/01', 2 => '2011'], 44 => [0 => 'Février 2029', 1 => '2004/02/29', 2 => '2011'], 45 => [0 => 'Mars 2020', 1 => '2012/03/20', 2 => '2011'], 46 => [0 => 'Mars 2021', 1 => '2012/03/21', 2 => '2011'], 47 => [0 => 'Mars 2022', 1 => '2012/03/22', 2 => '2011'], 48 => [0 => 'Juin 2020', 1 => '2012/06/20', 2 => '2011'], 49 => [0 => 'Juin 2021', 1 => '2012/06/21', 2 => '2011'], 50 => [0 => 'Juin 2022', 1 => '2012/06/22', 2 => '2011'], 51 => [0 => 'Septembre 2020', 1 => '2012/09/20', 2 => '2011'], 52 => [0 => 'Septembre 2021', 1 => '2012/09/21', 2 => '2011'], 53 => [0 => 'Septembre 2022', 1 => '2012/09/22', 2 => '2011'], 54 => [0 => 'Décembre 2020', 1 => '2012/12/20', 2 => '2011'], 55 => [0 => 'Décembre 2021', 1 => '2012/12/21', 2 => '2011'], 56 => [0 => 'Décembre 2022', 1 => '2012/12/22', 2 => '2011'], 57 => [0 => 'Juillet 2001', 1 => '05/07/2001', 2 => '2011'], 58 => [0 => 'Janvier 2001', 1 => '01/01/2001', 2 => '2011'], 59 => [0 => 'Décembre 2001', 1 => '31/12/2001', 2 => '2011'], 60 => [0 => 'Mars 2001', 1 => '01/03/2001', 2 => '2011'], 61 => [0 => 'Février 2004', 1 => '29/02/2004', 2 => '2011'], 62 => [0 => 'Mars 2012', 1 => '20/03/2012', 2 => '2011'], 63 => [0 => 'Mars 2012', 1 => '21/03/2012', 2 => '2011'], 64 => [0 => 'Mars 2012', 1 => '22/03/2012', 2 => '2011'], 65 => [0 => 'Juin 2012', 1 => '20/06/2012', 2 => '2011'], 66 => [0 => 'Juin 2012', 1 => '21/06/2012', 2 => '2011'], 67 => [0 => 'Juin 2012', 1 => '22/06/2012', 2 => '2011'], 68 => [0 => 'Septembre 2012', 1 => '20/09/2012', 2 => '2011'], 69 => [0 => 'Septembre 2012', 1 => '21/09/2012', 2 => '2011'], 70 => [0 => 'Septembre 2012', 1 => '22/09/2012', 2 => '2011'], 71 => [0 => 'Décembre 2012', 1 => '20/12/2012', 2 => '2011'], 72 => [0 => 'Décembre 2012', 1 => '21/12/2012', 2 => '2011'], 73 => [0 => 'Décembre 2012', 1 => '22/12/2012', 2 => '2011']];
    }
}
