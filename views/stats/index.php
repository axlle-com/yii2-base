<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\protected\Url\forms\UrlFilterForm */

$this->title = 'Статистика сокращенных ссылок';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="filter-form">
    <?php
    $form = ActiveForm::begin([
        'method' => 'get',
        'action' => [''],
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>

    <?= $form->field($model, 'start_date')->input('date', ['name' => 'start_date'])->label('Начальная дата') ?>
    <?= $form->field($model, 'end_date')->input('date', ['name' => 'end_date'])->label('Конечная дата') ?>

    <?= Html::submitButton('Применить фильтр', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Сбросить', ['url/index'], ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'attribute' => 'token',
            'format' => 'url',
            'label' => 'Сокращенная ссылка',
            'value' => static function ($model) {
                return Yii::$app->request->hostInfo . '/' . $model->token;
            },
        ],
        [
            'attribute' => 'original_url',
            'format' => 'url',
            'label' => 'Оригинальная ссылка',
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d H:i'],
            'label' => 'Дата создания',
        ],
        [
            'label' => 'Количество переходов',
            'value' => 'click_count',
        ],
    ],
]); ?>
