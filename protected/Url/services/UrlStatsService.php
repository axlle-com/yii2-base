<?php

namespace app\protected\Url\services;

use app\protected\Url\models\UrlStats;
use app\protected\Url\contracts\UrlStatsRepository;
use yii\db\Exception;

readonly class UrlStatsService implements \app\protected\Url\contracts\UrlStatsService
{
    public function __construct(private UrlStatsRepository $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function createStats(int $urlId, ?string $ip = null): UrlStats
    {
        $urlStats = new UrlStats();
        $urlStats->url_id = $urlId;
        $urlStats->ip = $ip;

        return $this->repository->saveStats($urlStats);
    }
}
