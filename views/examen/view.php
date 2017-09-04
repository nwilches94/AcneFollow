<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Paciente;
use dektrium\user\models\profile;

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
            'notas:ntext',
        ],
    ]) ?>

    <?= \nemmo\attachments\components\AttachmentsTable::widget(['model' => $model]) ?>
</div>
