<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1>Post: <?php echo var_dump($post); ?> end</h1>
	<h1>any: <?php echo $any; ?> end</h1>
	
	<p><?= Html::encode($this->title) ?></p>

    <p>
        This is the SMS page. 
    </p>

    <code><?= __FILE__ ?></code>
</div>
