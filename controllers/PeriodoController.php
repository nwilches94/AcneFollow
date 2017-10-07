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
                        'actions' => ['index', 'update', 'delete'],
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
		
		$periodos = Periodo::find()->where(['paciente_id' => $paciente['paciente_id']])->orderBy(['fecha' => SORT_DESC])->all();
		if($periodos)
		{
			foreach($periodos as $key => $value) {
				$model->fechaI[$key] = $value['fecha'];
				$model->fechaF[$key] = $value['fechaFin'];
				$model->fechaFC[$key] = strtotime('+1 day', strtotime($value['fechaFin']));
				$model->fechaFC[$key] = date('Y-m-d', $model->fechaFC[$key]);
				$proximoP = strtotime('+28 day', strtotime($value['fecha']));
				$proximoP = date('d-m-Y', $proximoP);
				$model->fechaA[$key] = Yii::$app->formatter->asDate($proximoP, 'php: Y-m-d');
			}
		}
		
       	return $this->render('index', [
            'dataProvider' => $dataProvider, 'model' => $model, 'proximoPeriodo' => $proximoPeriodo
        ]);
    }

	public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
		
		if($model->load(Yii::$app->request->post()))
        {
			$model->fecha=Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->fechaFin=Yii::$app->formatter->asDate($model->fechaFin, 'php: Y-m-d');
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$model->paciente_id=$paciente['id'];
			
            if($model->validate())
			{
                $model->save();
				
				\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Periodo Actualizado'));
				
				return $this->redirect('index');
			}
            else
                $model->getErrors();
        }
		
		$model->fecha=Yii::$app->formatter->asDate($model->fecha, 'php: d-m-Y');
		$model->fechaFin=Yii::$app->formatter->asDate($model->fechaFin, 'php: d-m-Y');
		
		return $this->render('update', [
            'model' => $model
        ]);

    }
	
	public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Periodo Eliminado'));
		
        return $this->redirect(['index']);
    }
	
	protected function findModel($id)
    {
        if (($model = Periodo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
