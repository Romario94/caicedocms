<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use mihaildev\elfinder\ElFinder;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model common\models\Noticia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>



    <?=
    $form->field($model, 'detalle')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => ElFinder::ckeditorOptions('elfinder', [
            'language' => 'es',
        ]),
    ])
    ?>

    <?=
    $form->field($model, 'categoria_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(common\models\Categoria::find()->all(), 'id', 'categoria'),
        'language' => 'es',
        'options' => ['placeholder' => 'Elija la categoria ..'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])
    ?> 
    
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
