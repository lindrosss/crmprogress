<?php

/* @var $this yii\web\View */

$this->title = 'CRM ООО "Прогресс';
use yii\helpers\Url;
?>
<div class="site-index">


	<?php 	
		
		/*
		echo Yii::getVersion();
		$posts = Yii::$app->db->createCommand('SELECT * FROM users')
            ->queryAll();		
			
		
	
		var_dump($posts);
		
		echo '<br/>';
		*/
		//echo Yii::$app->user->identity->role;	
		
	?>
	
	
	
	
	
    <div class="jumbotron">
        <h1>CRM ООО "Прогресс"</h1>


        
    </div>

    <div class="body-content">
		<?php
				if(Yii::$app->user->isGuest){
                  echo '<p class="lead">Для перехода в нужный раздел администрирования системы необходимо авторизоваться</p>';
				}else{ ?>
				<div class="row">
			
					<?php if(Yii::$app->user->identity->role == 2){?>
						<div class="col-lg-4">
							<h2>Компании</h2>
							<p>Список компаний</p>
							<p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/companies']);?>">Перейти</a></p>
						</div>
						
						<div class="col-lg-4">
							<h2>Контакты</h2>
							<p>Список контактов компаний</p>
							<p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/contacts']);?>">Перейти</a></p>
						</div>
						
						<div class="col-lg-4">
                            <h2>Задачи</h2>
                            <p>Список задач</p>
                            <p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/tasks']);?>">Перейти</a></p>
						</div>
					
			
				</div>
				
				
				
		
		<?php }elseif(Yii::$app->user->identity->role == 5){ ?>
			
				
		<?php }

		
	}	
		?>

    </div>
</div>
<?php //echo var_dump($get);?>