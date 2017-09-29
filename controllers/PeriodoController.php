<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Periodo;
use app\models\Paciente;
use yii\data\ActiveDataProvider;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\filters\VerbFilter;

class PeriodoController extends BaseAdminController
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'paciente'],
                    ],
                    [
                        'actions' => ['login', 'logout'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],    
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
    	$model = new Periodo();
		$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();

		if($model->load(Yii::$app->request->post()))
        {
			$model->fecha=Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->fechaFin=Yii::$app->formatter->asDate($model->fechaFin, 'php: Y-m-d');
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
			if($fecha)
			{
				$proximoPeriodo = strtotime('+28 day', strtotime($fecha));
				$proximoPeriodo = date('d-m-Y', $proximoPeriodo);
			}
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
		$periodos = Periodo::find()->where(['paciente_id' => $paciente['paciente_id']])->orderBy(['fecha' => SORT_DESC])->one();
		if($periodos)
		{
			$model->fechaI=$periodos['fecha'];
			$model->fechaF=$periodos['fechaFin'];
			$model->fechaFC = strtotime('+1 day', strtotime($periodos['fechaFin']));
			$model->fechaFC = date('Y-m-d', $model->fechaFC);
			$model->fechaA=Yii::$app->formatter->asDate($proximoPeriodo, 'php: Y-m-d');
		}

       	return $this->render('index', [
            'dataProvider' => $dataProvider, 'model' => $model, 'proximoPeriodo' => $proximoPeriodo
        ]);
    }
}
