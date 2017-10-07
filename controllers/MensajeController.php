<?php

namespace app\controllers;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\models\Mensaje;
use app\models\Paciente;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use yii\data\ActiveDataProvider;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\filters\VerbFilter;

class MensajeController extends BaseAdminController
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
                        'actions' => ['index', 'leido', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['admin', 'medico', 'paciente'],
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
    	$model = new Mensaje();
		
		$search=null;
		if($model->load(Yii::$app->request->get())) {
			
			$attributes = Yii::$app->request->get();
			
			if($attributes['Mensaje']['buscar'])
			{
				$search = $attributes['Mensaje']['buscar'];
				$query = Mensaje::getDataProvider($attributes['Mensaje']['buscar']);
			}
		}
		
		if($model->load(Yii::$app->request->post())) {
			
			if(\Yii::$app->user->can('medico'))
				$model->origen='medico';
			else
    			$model->origen='paciente';
			$model->leido = 0;
			$model->fecha = date('Y-m-d h:i:s');
			$model->ampm = date('A');
			
			if($model->validate()) {
				$model->save();
				
				\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'El Mensaje se ha enviado'));
				$model = new Mensaje();
			}
			else
				$model->getErrors();
        } 
		
		//Obtengo Listado de Pacientes
		$listaPaciente = Mensaje::getListaPaciente();
		
		if(!$search)
			$query = Mensaje::getDataProvider(null);
			
		//Obtengo la data
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
		//Contador de mensajes nuevos
		$count = Mensaje::getCount();

        return $this->render('index', [
            'model' => $model, 'listaPaciente' => $listaPaciente, 
            'dataProvider' => $dataProvider, 'count' => $count
        ]);
    }

	public function actionLeido($id)
	{
		if(\Yii::$app->user->can('medico'))
			Mensaje::updateAll(['leido' => 1], 'origen="paciente" AND doctor_id='.$id.' AND paciente_id='.$_GET['paciente_id']);
		else
    		Mensaje::updateAll(['leido' => 1], 'origen="medico" AND doctor_id='.$id.' AND paciente_id='.$_GET['paciente_id']);
    	
		return $this->redirect(['view', 'id' => $id, 'paciente_id' => $_GET['paciente_id']]);
	}

 	public function actionView($id)
    {
    	$model = new Mensaje();
		
		if($model->load(Yii::$app->request->post())) {
			if(\Yii::$app->user->can('medico'))
				$model->origen='medico';
			else
    			$model->origen='paciente';
			$model->leido = 0;
			$model->fecha = date('Y-m-d h:i:s');
			$model->ampm = date('A');

			if($model->validate()) {
				$model->save();
				
				\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'El Mensaje se ha enviado'));
				$model = new Mensaje();
			}
			else
				$model->getErrors();
        } 
		
		$query = Mensaje::find()->where(['paciente_id' => $_GET['paciente_id']]);
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
		//Obtengo Listado de Pacientes
		$listaPaciente = Mensaje::getListaPaciente();
		
		//Obtengo la data
		$dataProviderMensaje = new ActiveDataProvider([
			'query' => Mensaje::getDataProvider(null)
		]);
		
		return $this->render('view', [
            'model' => $model, 'dataProvider' => $dataProvider, 'listaPaciente' => $listaPaciente, 
            'dataProviderMensaje' => $dataProviderMensaje
        ]);
	}
	
	public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Mensaje Eliminado'));

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Mensaje::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
