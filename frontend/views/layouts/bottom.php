<?php

use frontend\models\ContactForm;

$model = new ContactForm();
if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
        Yii::$app->session->setFlash('success', 'Gracias por contactarte conmigo. Te responderé lo más pronto posible');
    } else {
        Yii::$app->session->setFlash('error', 'Ocurrió un error al mandar el mensaje, intente de nuevo.');
    }
}
?>
<section id="bottom" class="wet-asphalt">

</section><!--/#bottom-->