<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
//use frontend\models\Post;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use frontend\models\ContactForm;

if (Yii::$app->controller->action->id == "contact") {
    return Yii::$app->getResponse()->redirect(['site/error']);
}

AppAsset::register($this);
$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <?= $this->render('header.php', ['baseUrl' => $baseUrl]) ?>
        <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'error') { ?>
       
        <?php } ?>
        <?php if (Yii::$app->controller->id == 'profile') {
            ?>
            <div class=" jumbotron col-lg-12 col-sm-12 col-md-12 ">
                <div class="well well-sm">
                    <div class="row">
                        <?php
                    }
                    ?>
                    <?php
                    if (Yii::$app->controller->action == 'site') {
                        return $this->goBack();
                    }
                    ?>
                    <?= $content ?> 

                    <?php if (Yii::$app->controller->id == 'profile') {
                        ?>
                    </div> 
                </div> 
            </div>

            <?php
        }
        ?>      
        <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'error') { ?>
            <!--?= $this->render('servicios.php', ['baseUrl' => $baseUrl]) ?-->
            <?= $this->render('blog.php', ['baseUrl' => $baseUrl]) ?>
        <?php } ?>
        <?= $this->render('footer.php', ['baseUrl' => $baseUrl]) ?>

        <!--        <div class="control-sidebar-bg"></div>
                <div class="container">
        
                </div>-->


        <?php
        $model = new ContactForm();
        Modal::begin([
            'header' => '<h2>Contacto</h2>',
            'id' => 'contacto',
            'size' => 'modal-lg',
        ]);
        $form = ActiveForm::begin();
        include('../views/site/contact.php');
        ?>

        <!--?=$this->render('../site/contact.php', ['baseUrl' => $baseUrl]) ?-->
        <?php
        ActiveForm::end();
        $this->registerJs(
                "$(document).on('click', '#enviar', (function() {
        $.get(
            $(this).data('url'),
            function (data) {
                $('.modal-body').html(data);
                $('#modal').modal();
            }
        );
    }));"
        );
        Modal::begin([
            'id' => 'modal',
            'header' => '<h4 class="modal-title">Complete</h4>',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
        ]);

        echo "<div class='well'></div>";

        Modal::end();
        Modal::end();
        ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>