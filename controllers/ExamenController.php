<?php

namespace app\controllers;

use Yii;
use app\models\Examen;
use app\models\ExamenSearch;
use app\models\Grafica;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Paciente;
use app\models\User;
use app\models\Foto;
use nemmo\attachments\models\File;
use yii\data\ActiveDataProvider;

use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
/**
 * ExamenController implements the CRUD actions for Examen model.
 */
class ExamenController extends BaseAdminController
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
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['admin', 'paciente'],
                    ],
                    [
                        'actions' => ['index', 'view',  'delete', 'imagen', 'download'],
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

    /**
     * Lists all Examen models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(isset($_GET['id'])){
			$query = Examen::find()->where(['paciente_id' => $_GET['id']]);
			
			$dataProvider = new ActiveDataProvider([
				'query' => $query
			]);
		}
		else {
			$searchModel = new ExamenSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		}	
		
		$grafica = new Grafica();
		
		//Graficas
		$graficas = array();
		
		if(isset($_GET['id']))
			$graficas = Grafica::find()->where(['paciente_id' => $_GET['id']])->orderBy(['tipo' => SORT_ASC, 'fecha' => SORT_DESC]);
		
		$dataProviderG = new ActiveDataProvider([
			'query' => $graficas
		]);	
		
		$dataProvider->pagination->pageSize=5;
		
        return $this->render('index', [
            'dataProvider' => $dataProvider, 'grafica' => $grafica, 'dataProviderG' => $dataProviderG
        ]);
    }

    /**
     * Displays a single Examen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$ids=null;
		$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
		$examenes=Examen::find()->where(['id' => $id, 'paciente_id' => $paciente['id']])->all();
		if($examenes){
			foreach ($examenes as $key => $value){
				$ids[] = $value['id'];
			}
		}	

		if($ids){
			$query = File::find()->where(['in', 'itemId', $ids])->andWhere(['model' => 'Examen']);
	        if($query){
		        $dataProvider = new ActiveDataProvider([
		            'query' => $query,
		        ]);
				$fotos=$query->all();
			}
		}
		else{
			$dataProvider="";
			$fotos="";
		}
		
		return $this->render('view', [
            'model' => $this->findModel($id), 'dataProvider' => $dataProvider, 'fotos' => $fotos
        ]);
    }
	
    /**
     * Creates a new Examen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Examen();
		
		$pacientes=Paciente::find()->all();
		if($pacientes) {
			foreach ($pacientes as $value) {
				$user=User::find()->where(['id' => $value['user_id']])->one();
				$listaPaciente[$user['id']] = $user['username'];
			}
		}

		if($model->load(Yii::$app->request->post())) {
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->save();
			
            return $this->redirect(['view', 'id' => $model->id]);
        } 	
        else {
            return $this->render('create', [
                'model' => $model, 'listaPaciente' => $listaPaciente
            ]);
        }
    }
	
    /**
     * Updates an existing Examen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: d-m-Y');

        if ($model->load(Yii::$app->request->post())) {
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');
			$model->save();
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Examen model.
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
     * Finds the Examen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Examen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Examen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionImagen($id)
    {
    	$model = Examen::findOne($id);
		
		//Fotos
		$fotos = array();
		$query = File::find()->where(['in', 'itemId', $id])->andWhere(['model' => 'Examen']);
        if($query)
			$fotos=$query->all();
		
        return $this->render('imagen', [
            'model' => $model, 'fotos' => $fotos
        ]);
    }
	
	public function actionDownload($id)
    {
		$model = File::find()->where(['id' => $id])->andWhere(['model' => 'Examen'])->one();
		
		header ("Content-Disposition: attachment; filename=".str_replace(" ", "_", $model->name).".".$model->type);
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize($model->path));
		readfile($model->path);
    }
}
