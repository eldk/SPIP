<?php

/**
 * Test unitaire de la fonction plugin_version_compatible
 * du fichier ./inc/plugin.php
 *
 */
namespace Spip\Core\Tests\Plugin;

use PHPUnit\Framework\TestCase;
class PluginVersionCompatibleTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        find_in_path("./inc/plugin.php", '', true);
    }
    /** @dataProvider providerPluginPluginVersionCompatible */
    public function testPluginPluginVersionCompatible($expected, ...$args): void
    {
        $actual = plugin_version_compatible(...$args);
        $this->assertSame($expected, $actual);
        $this->assertEquals($expected, $actual);
    }
    public function providerPluginPluginVersionCompatible(): array
    {
        return [0 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2'], 1 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0'], 2 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0'], 3 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0dev'], 4 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0alpha'], 5 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0beta'], 6 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0rc'], 7 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0#'], 8 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.0pl'], 9 => [0 => true, 1 => '[1.0.0;3.0.0]', 2 => '2.0.1'], 10 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2'], 11 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2.0'], 12 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0'], 13 => [0 => false, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0dev'], 14 => [0 => false, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0alpha'], 15 => [0 => false, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0beta'], 16 => [0 => false, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0rc'], 17 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0#'], 18 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2.0.0pl'], 19 => [0 => true, 1 => '[2.0.0;3.0.0]', 2 => '2.0.1'], 20 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2'], 21 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0'], 22 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0'], 23 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0dev'], 24 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0alpha'], 25 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0beta'], 26 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0rc'], 27 => [0 => false, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0#'], 28 => [0 => true, 1 => ']2.0.0;3.0.0]', 2 => '2.0.0pl'], 29 => [0 => true, 1 => ']2.0.0;3.0.0]', 2 => '2.0.1'], 30 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2'], 31 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0'], 32 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0'], 33 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0dev'], 34 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0alpha'], 35 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0beta'], 36 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0rc'], 37 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0#'], 38 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.0pl'], 39 => [0 => false, 1 => ')2.0.0;3.0.0]', 2 => '2.0.1'], 40 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2'], 41 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0'], 42 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0'], 43 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0dev'], 44 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0alpha'], 45 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0beta'], 46 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0rc'], 47 => [0 => true, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0#'], 48 => [0 => false, 1 => '[1.0.0;2.0.0]', 2 => '2.0.0pl'], 49 => [0 => false, 1 => '[1.0.0;2.0.0]', 2 => '2.0.1'], 50 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2'], 51 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2.0'], 52 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0'], 53 => [0 => true, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0dev'], 54 => [0 => true, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0alpha'], 55 => [0 => true, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0beta'], 56 => [0 => true, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0rc'], 57 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0#'], 58 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2.0.0pl'], 59 => [0 => false, 1 => '[1.0.0;2.0.0[', 2 => '2.0.1'], 60 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2'], 61 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2.0'], 62 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0'], 63 => [0 => true, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0dev'], 64 => [0 => true, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0alpha'], 65 => [0 => true, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0beta'], 66 => [0 => true, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0rc'], 67 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0#'], 68 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2.0.0pl'], 69 => [0 => false, 1 => '[1.0.0;2.0.*[', 2 => '2.0.1'], 70 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2'], 71 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0'], 72 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0'], 73 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0dev'], 74 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0alpha'], 75 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0beta'], 76 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0rc'], 77 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0#'], 78 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.0pl'], 79 => [0 => true, 1 => '[1.0.0;2.0.*]', 2 => '2.0.1'], 80 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2'], 81 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0'], 82 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0'], 83 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0dev'], 84 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0alpha'], 85 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0beta'], 86 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0rc'], 87 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0#'], 88 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.0pl'], 89 => [0 => true, 1 => '[1.0.0;2.*]', 2 => '2.0.1']];
    }
}
