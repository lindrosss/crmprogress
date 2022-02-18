<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
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

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Progress',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 2){
		
        $items = [
            ['label' => 'Главная', 'url' => ['/']],		
			['label' => 'Компании', 'url' => ['/companies']],
		//	['label' => 'Кандидаты', 'url' => ['/candidates']],
		//	['label' => 'Оператор (Запись)', 'url' => ['/vacanciesoperator']],        
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/authout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ];
	}elseif(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 5){
		/*
		$items = [
            ['label' => 'Главная', 'url' => ['/']],					
			['label' => 'Оператор (Запись)', 'url' => ['/vacanciesoperator']],        
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ];
		*/
	}else{
		$items = [
            ['label' => 'Главная', 'url' => ['/']],				
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/auth']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/authout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ];
	}
	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => $items,
		
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
			'homeLink' => ['label' => 'Главная', 'url' => Url::to(['/'])],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Progress <?= date('Y') ?></p>

        <p class="pull-right">Progress</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
