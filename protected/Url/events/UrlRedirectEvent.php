<?php

namespace app\protected\Url\events;

use yii\base\Event;

class UrlRedirectEvent extends Event
{
    public int $urlId;
    public ?string $ip;
}
