<!-- Portfolio -->
<section id="Portfolio" class="content"> 

    <!-- Container -->
    <div class="container portfolio-title"> 

        <!-- Section Title -->
        <div class="section-title">
            <h2>Publicaciones</h2>
        </div>
        <!--/Section Title --> 

    </div>
    <!-- Container -->

    <div class="portfolio-top"></div>

    <!-- Portfolio Plus Filters -->
    <div class="portfolio"> 

        <!-- Portfolio Filters -->

        <div id="filters" class="sixteen columns">
            <ul class="clearfix"> 

                <li><a id="all" href="#" data-filter="*" class="active">
                        <h5>Todos</h5>
                    </a></li>

                <?php
                $categoria = \common\models\Categoria::find()->all();
                foreach ($categoria as $key => $value):
                    ?>
                    <li><a class="" href="#" data-filter="<?= '.' . $value->id ?>">
                            <h5><?= $value->categoria ?></h5>
                        </a></li>          

                <?php endforeach; ?>

            </ul>
        </div>

        <!--/Portfolio Filters --> 



        <!-- Portfolio Wrap -->
        <div class="isotope" style="position: relative; overflow: hidden; height: 480px;" id="portfolio-wrap"> 
            <?php
            $noticia = common\models\Noticia::find()->all();
            foreach ($noticia as $key => $value_noticia):
                ?>   
                <?php
                
                $val= yii\helpers\ArrayHelper::getValue(\common\models\Categoria::findOne(['id'=>$value_noticia->categoria_id]),'id');
               
          
                if ($value_noticia->categoria_id ==  $val  ):
                    ?>

            <div style="position: absolute; left: 0px; top: 0px; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); width: 337px; opacity: 1;" class="portfolio-item one-four   <?= $value_noticia->categoria_id ?> isotope-item">
                        <div class="portfolio-image"> <img src="<?= Yii::getAlias('@web/img/carpeta.png') ?>"  alt="Portfolio 1"> </div>
                        <a title="Starbucks Coffee" rel="prettyPhoto[galname]" href="<?= \yii\helpers\Url::to(['noticia/' . $value_noticia->seo_slug])?>">
                            <div class="project-overlay">
                                <div class="project-info">
                                    <div class="zoom-icon"></div>
                                    <h4 class="project-name"><?= $value_noticia->titulo ?></h4>
                                    <p class="project-categories"><?= $value_noticia->seo_slug ?></p>
                                </div>
                            </div>
                        </a> </div>          

             
                <?php elseif($value_noticia->categoria_id=='*'): ?>                
                    <div style="position: absolute; left: 0px; top: 0px; transform: translate3d(674px, 0px, 0px) scale3d(1, 1, 1); width: 337px; opacity: 1;" class="portfolio-item one-four  <?= $value_noticia->categoria_id ?>  isotope-item">
                        <div class="portfolio-image"> <img src="<?= Yii::getAlias('@web/img/vacio.jpg') ?>" alt="Portfolio 1"> </div>
                        <div class="project-overlay">
                            <div class="open-project-link"> <a class="open-project" href="" title="Open Project"></a> </div>

                            <div class="project-info">
                                <div class="zoom-icon"></div>
                                <h4 class="project-name">Vacio</h4>
                                <p class="project-categories">No hay elementos en la categoria</p>
                            </div>

                        </div>

                    </div>
             
                <?php endif; ?>


            <?php endforeach; ?>

        </div>

        <!--/Portfolio Wrap --> 

    </div>
    <!--/Portfolio Plus Filters -->

    <div class="portfolio-bottom"></div>

    <!-- Project Page Holder-->
    <div id="project-page-holder">
        <div class="clear"></div>
        <div id="project-page-data"></div>
    </div>
    <!--/Project Page Holder--> 

</section>



