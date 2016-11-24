<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria')->textInput(['maxlength' => true]) ?>

      <?=
    // your fileinput widget for single file upload

    $form->field($model, 'imagen')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg', 'png'],
            'browseIcon' => '<i class="glyphicon glyphicon-open-file"></i> ',
            'browseLabel' => $model->verifBrowseLabel(),
        ],
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
