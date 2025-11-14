<?php

namespace Phant\DataStructure\Web\UserAgent;

enum Device: string
{
    case Desktop = 'desktop';
    case Mobile = 'mobile';
    case Tablet = 'tablet';
}
