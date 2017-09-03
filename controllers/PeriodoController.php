<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Periodo;
use app\models\Paciente;
use yii\data\ActiveDataProvider;

class PeriodoController extends Controller
{
    public function actionIndex()
    {
    	$model = new Periodo();
		$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();

		if($model->load(Yii::$app->request->post()))
        {
			$model->fecha=Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->paciente_id=$paciente['id'];
			
            if($model->validate())
                $model->save();
            else
                $model->getErrors();
			
			$model = new Periodo();
        }
		
		$query = Periodo::find()->where(['paciente_id' => $paciente['id']])->orderBy(['fecha' => SORT_DESC]);
		$proximoPeriodo = null;
		if($query)
		{
			$paciente=$query->one();
			
			$fecha = $paciente['fecha'];
			$proximoPeriodo = strtotime('+28 day', strtotime($fecha));
			$proximoPeriodo = date('d-m-Y', $proximoPeriodo);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
       	return $this->render('index', [
            'dataProvider' => $dataProvider, 'model' => $model, 'proximoPeriodo' => $proximoPeriodo
        ]);
    }

}
