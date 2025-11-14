<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

enum OperatingSystemFamily: string
{
    case Windows = 'Windows';
    case MacOS = 'MacOS';
    case Linux = 'Linux';
    case Android = 'Android';
    case iOS = 'iOS';
    case iPadOS = 'iPadOS';

    case Other = 'Other';
}
