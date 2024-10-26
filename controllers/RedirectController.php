<?php

namespace app\controllers;

use app\protected\Url\events\UrlRedirectEvent;
use app\protected\Url\contracts\UrlRepository;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RedirectController extends Controller
{
    private UrlRepository $urlRepository;

    public function __construct($id, $module, UrlRepository $urlRepository, $config = [])
    {
        $this->urlRepository = $urlRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($token): Response
    {
        $url = $this->urlRepository->findByToken($token);
        if ($url === null) {
            throw new NotFoundHttpException('Ссылка не найдена');
        }

        $event = new UrlRedirectEvent();
        $event->urlId = $url->id;
        $event->ip = Yii::$app->request->userIP;
        Yii::$app->trigger('urlRedirected', $event);

        return $this->redirect($url->original_url);
    }
}
