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
			$model->paciente_id = $_GET['id'];
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->save();
			
			\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Estadística Generada'));
			
			return $this->redirect(['/examen/index', 'id' => $_GET['id']]);
		}

        return $this->render('index', ['model' => $model]);
    }	
	
	public function actionUpdate($id)
    {
		$model = $this->findModel($_GET['grafica']);
		$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: d-m-Y');
		
		if($model->load(Yii::$app->request->post())) {
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->save();
			
			\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Estadística Actualizada'));
			
			return $this->redirect(['/examen/index?id='.$_GET['id']]);
		}

		return $this->render('update', ['model' => $model]);
	}
	
	public function actionDelete($id)
    {
		$this->findModel($_GET['grafica'])->delete();
			
		\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Estadística Eliminada'));
		
		return $this->redirect(['/examen/index?id='.$_GET['id']]);
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
