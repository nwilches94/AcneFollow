<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Examen */

$this->title = Yii::t('app', 'Galería');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fotos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<divclass="foto-create">
	
    <h1><?= Html::encode($this->title) ?></h1><br>
    
    <?php if(\Yii::$app->user->can('medico')) { ?>
    	<?= Html::a(Yii::t('app', 'Regresar'), '/paciente/view?id='.$_GET['id'], ['class' => 'btn btn-primary']) ?>
    <?php } else { ?>
    	<?= Html::a(Yii::t('app', 'Regresar'), '/foto/create', ['class' => 'btn btn-primary']) ?>
    <?php } ?>
    
     <br><br>
	
    <div class="bs-example" data-example-id="simple-thumbnails">
		<div class="row"> 
    		<?php 	if($fotos) {
			    		foreach ($fotos as $key => $value) {
				    		echo 	'<div class="col-xs-3 col-md-3" style="padding-left: 1%; padding-right: 1%;">
				    					<div class="thumbnail" style="height: 100%">
				    						<p align="left">'.$fechas[$value['itemId']].'</p>
						    				<a class="thumbnail" style="margin-bottom: 5px;" type="button" data-toggle="modal" data-target="#w'.$value['id'].'"> 
							    				<img data-src="/attachments/file/download?id='.$value['id'].'" style="height: 180px; width: 100%; display: block;" 
							    				src="/attachments/file/download?id='.$value['id'].'" data-holder-rendered="true"> 
						    				</a>';
								
							    			Modal::begin(
							    				[
							    					'id' => 'w'.$value['id'],
												    'header' => $value['name'].".".$value['type'],
												    //'toggleButton' => ['label' => 'Ver Imagen'],
												]);
												echo 	'<img data-src="/attachments/file/download?id='.$value['id'].'" style="height: 100%; width: 100%; display: block;" 
							    						src="/attachments/file/download?id='.$value['id'].'" data-holder-rendered="true">';
											Modal::end();
							
											if(\Yii::$app->user->can('paciente')){		
													echo	'<div class="caption">
																<p align="right">
																	<a type="button" data-toggle="modal" data-target="#w'.$value['id'].'" title="Ver" aria-label="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
												    				<a href="/foto/download?id='.$value['id'].'" title="Descargar"><span class="glyphicon glyphicon-download"></span></a>
												    				<a href="/foto/delete?id='.$_GET['id'].'&foto='.$value['id'].'&type=Foto" title="Eliminar" aria-label="Eliminar" data-pjax="0" data-confirm="¿Está seguro de eliminar este elemento?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
												    			</p>
												    		</div>';
											}
											else
											{
													echo 	'<div class="caption">
																<p align="right">
																	<a type="button" data-toggle="modal" data-target="#w'.$value['id'].'" title="Ver" aria-label="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
											    					<a href="/foto/download?id='.$value['id'].'" title="Descargar"><span class="glyphicon glyphicon-download"></span></a>
											    				</p>
											    			</div>';
											}
									if($notas[$value['itemId']]) $nota = $notas[$value['itemId']]; else $nota ='<br>';
									echo   '<p align="left"><strong>'.$nota.'</strong></p>
				    					</div>
				    		     	</div>';
						}
					}
					else{
						echo 	'<div class="form-group field-formula-dosis required">
									<div class="col-sm-9">
										<p style="color:#FF0000; padding-top:1%; padding-bottom:0px">No se han cargado Fotos a la Galería</p>
									</div>
								</div>';
					}
			?>  	
    	</div> 
    </div>
</div>
