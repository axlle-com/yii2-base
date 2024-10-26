<?php

namespace app\protected\Url\repositories;

use app\protected\Url\models\UrlStats;
use yii\db\Exception;

class UrlStatsRepository implements \app\protected\Url\contracts\UrlStatsRepository
{
    /**
     * @throws Exception
     */
    public function saveStats(UrlStats $urlStats): UrlStats
    {
        if ($urlStats->save()) {
            return $urlStats;
        }

        throw new Exception("Can't save url stats");
    }
}
