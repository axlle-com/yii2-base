<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var app\protected\Url\forms\UrlForm $model
 */

?>
<div class="url-form">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['/create'],
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>
    <?= $form->field($model, 'original_url')->textInput(['placeholder' => 'Введите URL'])->label(false) ?>
    <?= Html::submitButton('Сократить ссылку', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
