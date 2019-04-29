# Pseudo IPv4

[![Build Status](https://travis-ci.org/ossinkine/pseudo-ipv4.svg?branch=master)](https://travis-ci.org/ossinkine/pseudo-ipv4)

Pseudo IPv4 is a library which converts IPv6 address to IPv4 in Class E space (240.0.0.0 - 255.255.255.255).
It can be helpful is your app operates with IPv4 only but the customer uses IPv6.
For more information see [CloudFlare solution](https://blog.cloudflare.com/eliminating-the-last-reasons-to-not-enable-ipv6/)

## How it works

Pseudo IPv4 determines if given address is 6to4 and gets original IPv4.
Otherwise it gets 8 first bytes from given IPv6 address and converts them to 4 bytes.

## Installation

```bash
composer require ossinkine/pseudo-ipv4
```

## Usage

Create a converter instance and pass an IPv6 address into it.

```php
use Ossinkine\PseudoIpv4\PseudoIpv4Converter;

$ipv6 = '2001:0db8:11a3:09d7:1f34:8a2e:07a0:765d';
$converter = new PseudoIpv4Converter();
$ipv4 = $converter->convert($ipv6);
```

If you unsure the address is IPv6 you can catch an appropriate exception.

```php
use Ossinkine\PseudoIpv4\Exception\WrongIpv6Exception;
use Ossinkine\PseudoIpv4\PseudoIpv4Converter;

$ip = $_SERVER['REMOTE_ADDR'];
$converter = new PseudoIpv4Converter();
try {
    $ipv4 = $converter->convert($ip);
} catch (WrongIpv6Exception $exception) {
    $ipv4 = $ip;
}
```

## License

[Pseudo IPv4](https://github.com/ossinkine/pseudo-ipv4) is licensed under the [MIT license](LICENSE).
