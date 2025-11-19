<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\UserAgent\Browser;
use Phant\DataStructure\Web\UserAgent\BrowserFamily;
use Phant\DataStructure\Web\UserAgent\Device;
use Phant\DataStructure\Web\UserAgent\OperatingSystem;
use Phant\DataStructure\Web\UserAgent\OperatingSystemFamily;
use Phant\DataStructure\Web\UserAgent\Version;

class UserAgent
{
    public function __construct(
        public readonly Device $device,
        public readonly OperatingSystem $operatingSystem,
        public readonly Browser $browser
    ) {

    }

    public static function getDeviceFromString(string $userAgent): Device
    {
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent)) {
            if (preg_match('/iPad/i', $userAgent)) {
                return Device::Tablet;
            }
            if (preg_match('/Android/i', $userAgent) && !preg_match('/Mobile/i', $userAgent)) {
                return Device::Tablet;
            }
            return Device::Mobile;
        }

        return Device::Desktop;
    }

    public static function getOperatingSystemFromString(string $userAgent): OperatingSystem
    {
        if (preg_match('/Windows NT ([0-9.]+)/i', $userAgent, $matches)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::Windows, new Version($matches[1]));
            // Convert NT version to Windows version
            $ntVersions = [
                '10.0' => '10/11',
                '6.3' => '8.1',
                '6.2' => '8',
                '6.1' => '7',
                '6.0' => 'Vista',
                '5.1' => 'XP',
            ];
            if (isset($ntVersions[$matches[1]])) {
                $operatingSystem = new OperatingSystem(OperatingSystemFamily::Windows, new Version($ntVersions[$matches[1]]));
            }
        } elseif (preg_match('/Mac OS X ([0-9_]+)/i', $userAgent, $matches)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::MacOS, new Version(str_replace('_', '.', $matches[1])));
        } elseif (preg_match('/Android ([0-9.]+)/i', $userAgent, $matches)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::Android, new Version($matches[1]));
        } elseif (preg_match('/iPhone OS ([0-9_]+)/i', $userAgent, $matches)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::iOS, new Version(str_replace('_', '.', $matches[1])));
        } elseif (preg_match('/iPad.*OS ([0-9_]+)/i', $userAgent, $matches)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::iPadOS, new Version(str_replace('_', '.', $matches[1])));
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $operatingSystem = new OperatingSystem(OperatingSystemFamily::Linux, new Version(''));
        }

        return $operatingSystem ?? new OperatingSystem(OperatingSystemFamily::Other, new Version(''));
    }

    public static function getBrowserFromString(string $userAgent): Browser
    {
        if (preg_match('/Edg\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::Edge, new Version($matches[1]));
        } elseif (preg_match('/OPR\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::Opera, new Version($matches[1]));
        } elseif (preg_match('/Brave\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::Brave, new Version($matches[1]));
        } elseif (preg_match('/SamsungBrowser\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::SamsungInternet, new Version($matches[1]));
        } elseif (preg_match('/UCBrowser\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::UcBrowser, new Version($matches[1]));
        } elseif (preg_match('/Chrome\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::Chrome, new Version($matches[1]));
        } elseif (preg_match('/Firefox\/([0-9.]+)/i', $userAgent, $matches)) {
            $browser = new Browser(BrowserFamily::Firefox, new Version($matches[1]));
        } elseif (preg_match('/Safari\/([0-9.]+)/i', $userAgent, $matches) && !preg_match('/Chrome/i', $userAgent)) {
            // Safari version is in Version/ not Safari/
            if (preg_match('/Version\/([0-9.]+)/i', $userAgent, $versionMatches)) {
                $browser = new Browser(BrowserFamily::Safari, new Version($versionMatches[1]));
            }
        }

        return $browser ?? new Browser(BrowserFamily::Other, new Version(''));
    }

    public static function fromString(string $userAgent): self
    {
        return new static(
            device: self::getDeviceFromString($userAgent),
            operatingSystem: self::getOperatingSystemFromString($userAgent),
            browser: self::getBrowserFromString($userAgent)
        );
    }
}
