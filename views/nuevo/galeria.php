<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Galería');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fotos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foto-create">
	
    <h1><?= Html::encode($this->title) ?></h1><br>
	
    <div class="bs-example" data-example-id="simple-thumbnails">
		<div class="row"> 
    		<?php 	if($fotos) {
			    		foreach ($fotos as $value) {
				    		echo 	'<div class="col-xs-6 col-md-3">
						    			<a href="#" class="thumbnail" style="margin-bottom: 5px;"> 
						    				<img alt="100%x180" data-src="/attachments/file/download?id='.$value['id'].'" style="height: 180px; width: 100%; display: block;" 
						    				src="/attachments/file/download?id='.$value['id'].'" data-holder-rendered="true"> 
						    			</a>
						    			<p align="right"><a href="/nuevo/delete?id='.$value['itemId'].'" title="Eliminar" aria-label="Eliminar" data-pjax="0" data-confirm="¿Está seguro de eliminar este elemento?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a></p>
							    	</div>';
						}
					}
					else
					{
						echo 	'<div class="form-group field-formula-dosis required">
										<div class="col-sm-9">
											<p style="color:#FF0000; padding-top:1%; padding-bottom:0px">No se han cargado Fotos a la Galería</p>
										</div>
									</div>';
					}
			?>  	
    	</div> 
    </div>
    
    <br><br>
    
    <?= Html::a(Yii::t('app', 'Regresar'), \Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
    
</div>
