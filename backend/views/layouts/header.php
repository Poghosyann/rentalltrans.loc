<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
Yii::$app->name = 'Rent All Trans';
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Rent All Trans</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <div class="pull-right">
                <?= Html::a(
                    'Sign out',
                    ['/site/logout'],
                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                ) ?>
            </div>
        </div>
    </nav>
</header>
