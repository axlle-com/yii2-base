<?php

namespace app\protected\Url\contracts;

use app\protected\Url\models\UrlStats;
use yii\db\Exception;

interface UrlStatsService
{
    /**
     * @throws Exception
     */
    public function createStats(int $urlId, ?string $ip = null): UrlStats;
}
