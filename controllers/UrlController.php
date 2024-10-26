<?php

namespace app\controllers;

use app\protected\Url\forms\UrlForm;
use app\protected\Url\contracts\UrlService;
use Random\RandomException;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class UrlController extends Controller
{
    private UrlService $service;

    public function __construct($id, $module, UrlService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     */
    public function actionIndex(): string
    {
        return $this->render('create', ['model' => new UrlForm()]);
    }

    /**
     * @throws Exception
     * @throws RandomException
     */
    public function actionCreate(): string
    {
        $model = new UrlForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $url = $this->service->createUrl($model->original_url);
            return $this->render('success', ['shortUrl' => Yii::$app->request->hostInfo . '/' . $url->token]);
        }

        return $this->render('create', ['model' => $model]);
    }
}
