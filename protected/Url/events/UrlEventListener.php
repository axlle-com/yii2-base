<?php

namespace app\protected\Url\events;

use app\protected\Url\jobs\UrlStatsJob;
use Yii;

class UrlEventListener
{
    public static function onRedirected(UrlRedirectEvent $event): void
    {
        Yii::$app->queue->push(
            new UrlStatsJob([
                'urlId' => $event->urlId,
                'ip' => $event->ip,
            ])
        );
    }
}
