<header id="header_outer">
    <div class="container">
        <div class="header_section">
            <div class="logo"><a href="javascript:void(0)"><img src="img/ntp.jpg" height="80px" width="250px" alt="ntp"></a></div>
            <nav class="nav" id="nav">
                
                <ul class="">
                    <li><a href="<?= \yii\helpers\Url::to(['/site/']) ?>">Inicio</a></li>
                    <!--  <li><a href="#service">Services</a></li>
                      <li><a href="#work_outer">Work</a></li>-->
                    <li><a href="#Portfolio">Publicaciones</a></li>
                    <!-- <li><a href="#client_outer">Clients</a></li>
                     <li><a href="#team">Team</a></li>-->
                    <li><a href="#contact">Contacto</a></li> 
                    <?php
                    if (yii::$app->user->isGuest):
                        ?>
                        <li><a href="<?= \yii\helpers\Url::to(['/user/security/login/']) ?>">Ingresar</a></li>
                        <?php
                    endif;
                    ?>
                    <?php
                    if (!yii::$app->user->isGuest):
                        ?>
                        <li><a href="<?= \yii\helpers\Url::to(['/user/security/logout/']) ?>" data-method="post">salir</a></li>
                        <?php
                    endif;
                    ?>

                </ul>
            </nav>
            <a class="res-nav_click animated wobble wow"  href="javascript:void(0)"><i class="fa-bars"></i></a> </div>
    </div>
</header>