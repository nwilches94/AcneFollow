<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Formula;
use app\models\Paciente;
use dektrium\user\models\Profile;
use yii\data\ActiveDataProvider;

class FormulaController extends Controller
{
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
				
				return $this->redirect(['index']);
			}
			else
				$model->getErrors();
        } 
		
		if(\Yii::$app->user->can('medico'))
    		$query = Formula::find()->where(['doctor_id' => Yii::$app->user->id]);
		else
			$query = Formula::find()->where(['paciente_id' => Yii::$app->user->id]);
		
        $dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
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
            'model' => $model, 'dataProvider' => $dataProvider, 'listaPaciente' => $listaPaciente
        ]);
    }

	public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
		
		if($model->load(Yii::$app->request->post())) {
			
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');

			if($model->validate()) {
				$model->save();
				
				return $this->redirect('index');
			}
			else
				$model->getErrors();
        }
		
		if(\Yii::$app->user->can('medico'))
    		$query = Formula::find()->where(['doctor_id' => Yii::$app->user->id]);
		else
			$query = Formula::find()->where(['paciente_id' => Yii::$app->user->id]);
		
        $dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
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
            'model' => $model, 'dataProvider' => $dataProvider, 'listaPaciente' => $listaPaciente
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
}
