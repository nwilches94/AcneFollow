<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Paciente;
use app\models\Examen;
use dektrium\user\models\profile;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estadísticas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            	
            	<h1><?= Html::encode($this->title) ?></h1>
    
    			<?= $this->render('_form', ['model' => $model]) ?>
	
            </div>
        </div>
    </div>
</div>
