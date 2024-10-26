<?php

namespace app\protected\Url\contracts;

use app\protected\Url\models\Url;
use Random\RandomException;
use yii\db\Exception;

interface UrlService
{
    /**
     * @throws Exception
     * @throws RandomException
     */
    public function createUrl(string $originalUrl): Url;
}
