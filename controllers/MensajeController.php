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
			if(\Yii::$app->user->can('medico'))
				$model->origen='medico';
			else
    			$model->origen='paciente';
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
		{
			$sql =	"SELECT * 
					FROM mensaje
					WHERE origen='paciente' AND doctor_id=".Yii::$app->user->id." AND id IN (
						SELECT MAX(id) AS id 
						FROM mensaje
						WHERE origen='paciente' AND doctor_id=".Yii::$app->user->id." 
						GROUP BY doctor_id, paciente_id
						ORDER BY doctor_id, paciente_id
					)
					GROUP BY doctor_id, paciente_id
					ORDER BY doctor_id, paciente_id";

            $query = Mensaje::findBySql($sql);
		}
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			
			$sql =	"SELECT * 
					FROM mensaje
					WHERE origen='medico' AND paciente_id=".$paciente['id']." AND id IN (
						SELECT MAX(id) AS id 
						FROM mensaje
						WHERE origen='medico' AND paciente_id=".$paciente['id']." 
						GROUP BY doctor_id, paciente_id
						ORDER BY doctor_id, paciente_id
					)
					GROUP BY doctor_id, paciente_id
					ORDER BY doctor_id, paciente_id";
			
            $query = Mensaje::findBySql($sql);
		}
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
		
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
			$model->fecha = date('Y-m-d');

			if($model->validate()) {
				$model->save();
				
				$model = new Mensaje();
			}
			else
				$model->getErrors();
        } 
		
		$query = Mensaje::find()->where(['paciente_id' => $_GET['paciente_id']]);
		
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
		
		if(\Yii::$app->user->can('medico'))
		{
			$sql =	"SELECT * 
					FROM mensaje
					WHERE origen='paciente' AND doctor_id=".Yii::$app->user->id." AND id IN (
						SELECT MAX(id) AS id 
						FROM mensaje
						WHERE origen='paciente' AND doctor_id=".Yii::$app->user->id." 
						GROUP BY doctor_id, paciente_id
						ORDER BY doctor_id, paciente_id
					)
					GROUP BY doctor_id, paciente_id
					ORDER BY doctor_id, paciente_id";

            $query = Mensaje::findBySql($sql);
		}
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			
			$sql =	"SELECT * 
					FROM mensaje
					WHERE origen='medico' AND paciente_id=".$paciente['id']." AND id IN (
						SELECT MAX(id) AS id 
						FROM mensaje
						WHERE origen='medico' AND paciente_id=".$paciente['id']." 
						GROUP BY doctor_id, paciente_id
						ORDER BY doctor_id, paciente_id
					)
					GROUP BY doctor_id, paciente_id
					ORDER BY doctor_id, paciente_id";

            $query = Mensaje::findBySql($sql);
		}
		
		$dataProviderMensaje = new ActiveDataProvider([
			'query' => $query
		]);
		
		return $this->render('view', [
            'model' => $model, 'dataProvider' => $dataProvider, 'listaPaciente' => $listaPaciente, 
            'dataProviderMensaje' => $dataProviderMensaje
        ]);
	}
	
	public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
