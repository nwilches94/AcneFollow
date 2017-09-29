<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Grafica;
use app\models\Examen;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use dektrium\user\controllers\AdminController as BaseAdminController;

class GraficaController extends BaseAdminController
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
                        'roles' => ['admin', 'medico'],
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
    	$model = new Grafica();
		
		if($model->load(Yii::$app->request->post())) {
			$model->paciente_id = $_GET['paciente_id'];
			$model->examen_id = $_GET['id'];
			$model->fecha = Examen::changeDate($model->fecha, 0);
			$model->save();
			
			return $this->redirect(['/paciente/view', 'id' => $_GET['paciente_id']]);
		}

        return $this->render('index', ['model' => $model]);
    }	
	
	public function actionUpdate($id)
    {
		$model = $this->findModel($_GET['grafica']);
		$model->fecha = Examen::changeDate($model->fecha, 1);
		
		if($model->load(Yii::$app->request->post())) {
			$model->fecha = Examen::changeDate($model->fecha, 0);
			$model->save();
			
			return $this->redirect(['/examen/imagen?id='.$_GET['id'].'&paciente_id='.$_GET['paciente_id']]);
		}

		return $this->render('update', ['model' => $model]);
	}
	
	public function actionDelete($id)
    {
		$this->findModel($_GET['grafica'])->delete();
			
		return $this->redirect(['/examen/imagen?id='.$_GET['id'].'&paciente_id='.$_GET['paciente_id']]);
    }
	
	protected function findModel($id)
    {
        if (($model = Grafica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
