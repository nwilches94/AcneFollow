<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Mensaje;
use app\models\Paciente;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use yii\data\ActiveDataProvider;

class MensajeController extends Controller
{
    public function actionIndex()
    {
    	$model = new Mensaje();
		
		if($model->load(Yii::$app->request->post())) {
			
			$model->leido = 0;
			$model->fecha = date('Y-m-d');

			if($model->validate()) {
				$model->save();
				
				$model = new Mensaje();
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
		
		if(\Yii::$app->user->can('medico'))
			$query = Mensaje::find()->where(['origen' => 'paciente', 'doctor_id' => \Yii::$app->user->identity->id]);
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$query = Mensaje::find()->where(['origen' => 'medico', 'paciente_id' => $paciente['id']]);
		}
		
		$count=0;
		if($query)
		{
			$registros = $query->all();
			if($registros) {
				foreach($registros as $value) {
					if($value['leido'] == 0)
						$count += 1;
				}
			}
		}
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);

        return $this->render('index', [
            'model' => $model, 'listaPaciente' => $listaPaciente, 
            'dataProvider' => $dataProvider, 'count' => $count
        ]);
    }

 	public function actionView($id)
    {
    	if($_GET['id']) {
			$model = Mensaje::find()->where(['id' => $_GET['id']])->one();
			$model->leido=1;
			$model->save();

			return $this->render('view', [
	            'model' => $model
	        ]);
		}
		
		return $this->redirect('index');
	}
}
