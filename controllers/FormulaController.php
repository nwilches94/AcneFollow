<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Formula;
use app\models\Paciente;
use app\models\ControlCaja;
use dektrium\user\models\Profile;
use yii\data\ActiveDataProvider;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\filters\VerbFilter;

class FormulaController extends BaseAdminController
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
                        'actions' => ['view', 'create', 'update', 'delete', 'peso'],
                        'allow' => true,
                        'roles' => ['admin', 'medico'],
                    ],
                    [
                        'actions' => ['index'],
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
    	if(\Yii::$app->user->can('medico'))
    		$query = Formula::find()->where(['doctor_id' => Yii::$app->user->id]);
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
    		$query = Formula::find()->where(['paciente_id' => $paciente['id']]);
		}
		
        $dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
       	return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
	
	public function actionCreate()
    {
    	$model = new Formula();
		
		if($model->load(Yii::$app->request->post())) {
			
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');

			if($model->validate()) {
				$model->save();
				
				//Creo el control de cajas
				$controlCajas = new ControlCaja();
				$controlCajas->paciente_id=$model->paciente_id;
				$controlCajas->formula_id=$model->id;
				$controlCajas->doctor_id= Yii::$app->user->id;
				$controlCajas->fecha=$model->fecha;
				$controlCajas->cajaTomada=$model->cajas;
				$controlCajas->dosisAcumulada=($model->cajas)*(30*$model->capsula);
				$controlCajas->dosisRestante=(($model->peso*$model->dosis)-($controlCajas->dosisAcumulada));
				$controlCajas->dosisCaja=((($model->peso*$model->dosis)/($model->capsula*30))-($model->cajas));
				$controlCajas->save();
				
				return $this->redirect(['index']);
			}
        } 
		
		$listaPaciente=null;
		if(\Yii::$app->user->can('medico')) {
			$pacientes=Paciente::find()->where(['doctor_id' => Yii::$app->user->id])->all();
			if($pacientes) {
				foreach ($pacientes as $value) {
					$user=Profile::find()->where(['user_id' => $value['user_id']])->one();
					$listaPaciente[$value['id']] = $user['name'];
				}
			}
		}
		
       	return $this->render('create', [
            'model' => $model, 'listaPaciente' => $listaPaciente
        ]);
    }

	public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
		
		if($model->load(Yii::$app->request->post())) {
			
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');

			if($model->validate()) {
				$model->save();
				
				//Creo el control de cajas
				$controlCajas=ControlCaja::find()->where(['formula_id' => $model->id])->one();
				$controlCajas->paciente_id=$model->paciente_id;
				$controlCajas->formula_id=$model->id;
				//$controlCajas->doctor_id= Yii::$app->user->id;
				//$controlCajas->fecha=$model->fecha;
				$controlCajas->cajaTomada=$model->cajas;
				$controlCajas->dosisAcumulada=($model->cajas)*(30*$model->capsula);
				$controlCajas->dosisRestante=(($model->peso*$model->dosis)-($controlCajas->dosisAcumulada));
				$controlCajas->dosisCaja=((($model->peso*$model->dosis)/($model->capsula*30))-($model->cajas));
				$controlCajas->save();
				
				return $this->redirect('index');
			}
			else
				$model->getErrors();
        }
		
		$listaPaciente=null;
		if(\Yii::$app->user->can('medico')) {
			$pacientes=Paciente::find()->where(['doctor_id' => Yii::$app->user->id])->all();
			if($pacientes) {
				foreach ($pacientes as $value) {
					$user=Profile::find()->where(['user_id' => $value['user_id']])->one();
					$listaPaciente[$value['id']] = $user['name'];
				}
			}
		}
		
       	return $this->render('update', [
            'model' => $model, 'listaPaciente' => $listaPaciente
        ]);
    }

	public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	protected function findModel($id)
    {
        if (($model = Formula::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionPeso($id)
    {
    	$paciente = Paciente::findOne($id);
        $profile = Profile::findOne($paciente['user_id']);
		
		return $profile['peso'];
    }
}
