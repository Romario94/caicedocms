<link href="../../../vendor/bower/plantilla/css/letras.css" rel="stylesheet" type="text/css"/>
<br><br><br><br>
<body style="background-color: #219"> 
<div class="container">
    <div class="row">
        <div class="container-fluid text-left">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
               
                <h1>   Titulo:   <?=
                yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                    return $noticia[0]['tituloNoticia'];
                });
                ?></h1><br>

                <h1>Categoría: <?=
                yii\helpers\ArrayHelper::getValue(common\models\Categoria::findOne(['id' => yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                                        return $noticia[0]['categoriaNoticia'];
                                    })]), 'categoria');
                ?></h1><br>

                <h4>    
                <?=
                yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                    return $noticia[0]['detalleNoticia'];
                });
                ?></h4>


            </div>
        </div>  
    </div>
</div>
</body>