<?php

namespace Ossinkine\PseudoIpv4;

use Ossinkine\PseudoIpv4\Exception\WrongIpv6Exception;
use PHPUnit\Framework\TestCase;

class PseudoIpv4ConverterTest extends TestCase
{
    /**
     * @var PseudoIpv4Converter
     */
    private $converter;

    protected function setUp(): void
    {
        $this->converter = new PseudoIpv4Converter();
    }

    /**
     * @dataProvider provideIpv6
     */
    public function testConvert(string $expectedIpv4, string $ipv6): void
    {
        $ipv4 = $this->converter->convert($ipv6);

        $this->assertSame($expectedIpv4, $ipv4);
    }

    public function provideIpv6(): array
    {
        return [
            '6to4' => ['1.2.3.4', '2002:0102:0304:0:0:0:0:0'],
            'ipv6' => ['241.1.1.1', '0001:0203:0405:0607:0809:0a0b:0c0d:0e0f'],
        ];
    }

    /**
     * @dataProvider provideWrongIpv6
     */
    public function testConvertException(string $wrongIpv6): void
    {
        $this->expectException(WrongIpv6Exception::class);

        $this->converter->convert($wrongIpv6);
    }

    public function provideWrongIpv6(): array
    {
        return [
            'ipv4' => ['1.2.3.4'],
            'junk' => ['foo'],
        ];
    }
}
