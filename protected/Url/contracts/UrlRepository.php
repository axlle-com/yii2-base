<?php

namespace app\protected\Url\contracts;

use app\protected\Url\forms\UrlFilterForm;
use app\protected\Url\models\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

interface UrlRepository
{
    /**
     * @throws Exception
     */
    public function saveUrl(Url $url): Url;

    public function findByToken(string $shortUrl): ?Url;

    public function getStatsDataProvider(?UrlFilterForm $form = null): ActiveDataProvider;
}
