<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Paciente;
use dektrium\user\models\profile;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Examens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="examen-view">

    <h1><?= Html::encode('Ver Examen') ?></h1><br>

    <p>
        <?= Html::a(Yii::t('app', 'Regresar'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
		        'attribute' => 'fecha',
		        'format' => 'text',
		        'label' => 'Fecha del Examen',
		        'value' => function ($data) {
					return Yii::$app->formatter->asDate($data->fecha, 'php: M, Y');
			     }
		    ],
		    'tipo',
            'notas:ntext',
        ],
    ]) ?>

    <div class="bs-example" data-example-id="simple-thumbnails">
		<div class="row"> 
    		<?php 	if($fotos) {
			    		foreach ($fotos as $value) {
				    		echo 	'<div class="col-xs-6 col-md-3">';
							
									if($value['type'] == 'jpg' || $value['type'] == 'png'|| $value['type'] == 'gif'){
						    			echo 	'<a class="thumbnail" style="margin-bottom: 5px;" type="button" data-toggle="modal" data-target="#w'.$value['id'].'"> 
							    					<img data-src="/attachments/file/download?id='.$value['id'].'" style="height: 180px; width: 100%; display: block;" 
							    					src="/attachments/file/download?id='.$value['id'].'" data-holder-rendered="true"> 
							    				</a>';
									}
									else{
										echo  	'<a class="thumbnail" style="margin-bottom: 5px;" type="button" data-toggle="modal" data-target="#w'.$value['id'].'"> 
						    						<img data-src="/img/default.jpg" style="height: 180px; width: 100%; display: block;" 
						    						src="/img/default.jpg" data-holder-rendered="true"> 
						    					</a>';
						    		}
						    			Modal::begin(
						    				[
						    					'id' => 'w'.$value['id'],
											    'header' => $value['name'].".".$value['type'],
											    //'toggleButton' => ['label' => 'Ver Imagen'],
											]);
											
											if($value['type'] == 'jpg' || $value['type'] == 'png'|| $value['type'] == 'gif'){
								    			echo 	'<img data-src="/attachments/file/download?id='.$value['id'].'" style="height: 100%; width: 100%; display: block;" 
								    				 	src="/attachments/file/download?id='.$value['id'].'" data-holder-rendered="true">';
											}
											else{
												echo 	'<img data-src="/img/default2.jpg" style="height: 100%; width: 100%; display: block;" 
								    				  	src="/img/default2.jpg" data-holder-rendered="true">';
								    		}
										Modal::end();
										
							echo		'<p align="right">
											<a type="button" data-toggle="modal" data-target="#w'.$value['id'].'" title="Ver" aria-label="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
						    				<a href="/examen/download?id='.$value['id'].'" title="Descargar"><span class="glyphicon glyphicon-download"></span></a>
						    				<a href="/foto/delete?id='.$_GET['id'].'&foto='.$value['id'].'&type=Examen" title="Eliminar" aria-label="Eliminar" data-pjax="0" data-confirm="¿Está seguro de eliminar este elemento?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
						    			</p>
							    	</div>';
						}
					}
					else
					{
						echo 	'<div class="form-group field-formula-dosis required">
										<div class="col-sm-9">
											<p style="color:#FF0000; padding-top:1%; padding-bottom:0px">No se han cargado imagenes del Examen</p>
										</div>
									</div>';
					}
			?>  	
    	</div> 
    </div>
</div>
