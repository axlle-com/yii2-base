<?php

namespace app\protected\Url\contracts;

use app\protected\Url\models\UrlStats;
use yii\db\Exception;

interface UrlStatsRepository
{
    /**
     * @throws Exception
     */
    public function saveStats(UrlStats $urlStats): UrlStats;
}
