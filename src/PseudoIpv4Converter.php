<?php

namespace Ossinkine\PseudoIpv4;

use Ossinkine\PseudoIpv4\Exception\WrongIpv6Exception;

class PseudoIpv4Converter
{
    public function convert(string $ipv6): string
    {
        $ipv6Addr = @inet_pton($ipv6);
        if ($ipv6Addr === false || strlen($ipv6Addr) !== 16) {
            throw new WrongIpv6Exception(sprintf('IPv6 address expected, "%s" given.', $ipv6));
        }

        if (strpos($ipv6Addr, chr(0x20).chr(0x02)) === 0) { // 6to4 addresses starting with 2002:
            $ipv4Addr = substr($ipv6Addr, 2, 4);
        } else {
            $ipv4Addr = '';
            for ($i = 0; $i < 8; $i += 2) { // Get first 8 bytes because the most of ISP provide addresses with mask /64
                $ipv4Addr .= chr(ord($ipv6Addr[$i]) ^ ord($ipv6Addr[$i + 1]));
            }
            $ipv4Addr[0] = chr(ord($ipv4Addr[0]) | 240); // Class E space
        }
        $ipv4 = inet_ntop($ipv4Addr);

        return $ipv4;
    }
}
