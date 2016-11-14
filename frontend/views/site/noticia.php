

<br><br><br><br>

        <!--Top_content-->
<section id="top_content" class="top_cont_outer">
  <div class="top_cont_inner">
    <div class="container">
      <div class="top_content">
        <div class="row">
          <div class="col-lg-5 col-sm-7">
            <div class="top_left_cont flipInY wow animated">
              <h3>Titulo:   <?=
                yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                    return $noticia[0]['tituloNoticia'];
                });
                ?></h3>
              <h2>Categoría: <?=
                yii\helpers\ArrayHelper::getValue(common\models\Categoria::findOne(['id' => yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                                        return $noticia[0]['categoriaNoticia'];
                                    })]), 'categoria');
                ?></h2>
              <p> <?=
                yii\helpers\ArrayHelper::getValue($noticia, function ($noticia, $defaultValue) {
                    return $noticia[0]['detalleNoticia'];
                });
                ?> </p>
              
          </div>
          <div class="col-lg-7 col-sm-5"> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Top_content--> 
