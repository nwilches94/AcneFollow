<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\PacienteCreate;
use app\models\Paciente;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use dektrium\user\models\Profile;

use app\models\Foto;
use app\models\Periodo;
use nemmo\attachments\models\File;

/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends Controller
{
    /**
     * @inheritdoc
     */
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
                        'actions' => ['index', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['medico', 'admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex()
    {
		$pacienteSearch = new Paciente;
        $sql = null;
		
        if($pacienteSearch->load(Yii::$app->request->get()))
        {
            if($pacienteSearch->validate())
            {
                $search = Html::encode($pacienteSearch->buscar);

				$sql =	"SELECT paciente.* 
						FROM profile 
						JOIN paciente ON paciente.user_id = profile.user_id
						WHERE paciente.doctor_id = ".\Yii::$app->user->identity->id." AND (profile.user_id LIKE '%$search%' OR profile.name LIKE '%$search%')";

                $query = Paciente::findBySql($sql);
            }
            else
                $pacienteSearch->getErrors();
        }
		else 
		{
			if(Yii::$app->user->identity->isAdmin)
				$query = Paciente::find();
	        else
	            $query = Paciente::find()->where(['doctor_id'=> \Yii::$app->user->identity->id]);
        }
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		
		$model = Paciente::find()->one();
		
        return $this->render('index', [
            'dataProvider' => $dataProvider, 'model' => $model
        ]);
    }

	public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$paciente=Paciente::find()->where(['id' => $id])->one();
		$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
		
        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                'model' => $model, 'profile' => $profile
            ]);
        }
    }

    /**
     * Displays a single Paciente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$ids=null; $query=null;
		
    	if(\Yii::$app->user->can('medico'))
			$fotos=Foto::find()->where(['paciente_id' => $id])->all();
		else 
		{
	    	$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$fotos=Foto::find()->where(['paciente_id' => $paciente['id']])->all();
		}
		
		if($fotos){
			foreach ($fotos as $key => $value){
				$ids[] = $value['id'];
			}
		}
		
		if($ids){
			$query = File::find()->where(['in', 'itemId', $ids])->andWhere(['model' => 'Foto']);
	        $dataProvider = new ActiveDataProvider([
	            'query' => $query,
	        ]);
		}
		else
			$dataProvider = '';
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);

		$query=null;
		
		if(\Yii::$app->user->can('medico'))
			$query=Periodo::find()->where(['paciente_id' => $id])->orderBy(['fecha' => SORT_DESC]);
		
		$dataProviderPeriodo = new ActiveDataProvider([
			'query' => $query
		]);
		
        return $this->render('view', [
            'model' => $this->findModel($id), 'dataProvider' => $dataProvider, 'dataProviderPeriodo' => $dataProviderPeriodo
        ]);
    }

    /**
     * Deletes an existing Paciente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paciente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
