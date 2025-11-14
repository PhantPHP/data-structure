<?php

namespace Phant\DataStructure\Web\UserAgent;

enum BrowserFamily: string
{
    case Chrome = 'Chrome';
    case Firefox = 'Firefox';
    case Safari = 'Safari';
    case Edge = 'Edge';
    case Opera = 'Opera';
    case Brave = 'Brave';
    case SamsungInternet = 'Samsung Internet';
    case UcBrowser = 'UC Browser';

    case Other = 'Other';
}
