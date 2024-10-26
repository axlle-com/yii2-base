<?php

namespace app\protected\Url\services;

use app\protected\Url\models\Url;
use app\protected\Url\contracts\UrlRepository;
use Random\RandomException;
use yii\db\Exception;

readonly class UrlService implements \app\protected\Url\contracts\UrlService
{
    public function __construct(private UrlRepository $repository)
    {
    }

    /**
     * @throws Exception
     * @throws RandomException
     */
    public function createUrl(string $originalUrl): Url
    {
        $url = new Url();
        $url->original_url = $originalUrl;
        $url->token = $this->generateUniqueToken();

        return $this->repository->saveUrl($url);
    }

    /**
     * @throws RandomException
     */
    private function generateUniqueToken(): string
    {
        do {
            $token = (new Token())->generate();
        } while ($this->repository->findByToken($token) !== null);

        return $token;
    }
}
