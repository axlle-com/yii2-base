<?php

namespace app\protected\Url\jobs;

use app\protected\Url\contracts\UrlStatsService;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\di\NotInstantiableException;
use yii\queue\JobInterface;

class UrlStatsJob extends BaseObject implements JobInterface
{
    public int $urlId;
    public ?string $ip;

    /**
     * @throws Exception
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function execute($queue): void
    {
        /** @var UrlStatsService $service */
        $service = Yii::$container->get(UrlStatsService::class);
        $service->createStats($this->urlId, $this->ip);
    }
}
