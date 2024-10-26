<?php

namespace app\controllers;

use app\protected\Url\forms\UrlFilterForm;
use app\protected\Url\contracts\UrlRepository;
use Yii;
use yii\web\Controller;

class StatsController extends Controller
{
    private readonly UrlRepository $urlRepository;

    public function __construct($id, $module, UrlRepository $urlRepository, $config = [])
    {
        $this->urlRepository = $urlRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $model = new UrlFilterForm();
        $data = Yii::$app->request->get();
        if ($model->load(['UrlFilterForm' => $data]) && $model->validate()) {
            $dataProvider = $this->urlRepository->getStatsDataProvider($model);
        } else {
            $dataProvider = $this->urlRepository->getStatsDataProvider();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
}
