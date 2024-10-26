<?php

namespace app\protected\Url\services;

use Random\RandomException;

readonly class Token
{
    public function __construct(private int $length = 5)
    {
    }

    /**
     * @throws RandomException
     */
    public function generate(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $this->length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}