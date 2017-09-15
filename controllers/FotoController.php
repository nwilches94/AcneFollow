<?php

namespace app\controllers;
//namespace dektrium\user\controllers;
use dektrium\user\filters\AccessRule;
use dektrium\user\Finder;
use dektrium\rbac\models\Assignment;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use dektrium\user\models\UserSearch;
use dektrium\user\helpers\Password;
use dektrium\user\Module;
use dektrium\user\traits\EventTrait;
use yii;
use yii\base\ExitException;
use yii\base\Model;
use yii\base\Module as Module2;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use dektrium\user\controllers\AdminController as BaseAdminController;

use app\models\Paciente;
use app\models\Foto;
use app\models\Examen;
use nemmo\attachments\models\File;
use yii\data\ActiveDataProvider;

/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class FotoController extends BaseAdminController
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                	[
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['admin', 'paciente'],
                    ],
                    [
                        'actions' => ['galeria', 'download'],
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

    public function actionCreate()
    {
        $model = new Foto();
		
		if(Yii::$app->request->post()) {
			
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$model->paciente_id = $paciente['id'];
			$model->fecha = date('Y-m-d');
			$model->save();

			return $this->redirect('/foto/galeria?id='.$paciente['user_id']);
			
			//\Yii::$app->getSession()->setFlash('success', 'Se ha cargado las Fotos');
		}
		
		$ids=null;
		$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
		$fotos=Foto::find()->where(['paciente_id' => $paciente['id']])->all();
		if($fotos){
			foreach ($fotos as $key => $value) {
				$ids[] = $value['id'];
			}
		}
		
		if($ids)
		{
			$query = File::find()->where(['in', 'itemId', $ids])->andWhere(['model' => 'Foto']);
	        if($query){
		        $dataProvider = new ActiveDataProvider([
		            'query' => $query,
		        ]);
				$fotos=$query->all();
			}
		}
		else
		{
			$dataProvider="";
			$fotos="";
		}

        return $this->render('create', [
            'model' => $model, 'dataProvider' => $dataProvider, 'fotos' => $fotos
        ]);
    }
	
	public function actionGaleria($id)
    {
        $model = new Foto();
		
		if(Yii::$app->request->post()) {
			
			$paciente=Paciente::find()->where(['user_id' => $id])->one();
			$model->paciente_id = $paciente['id'];
			$model->fecha = date('Y-m-d');
			$model->save();

			$model = new Foto();
			
			\Yii::$app->getSession()->setFlash('success', 'Se ha cargado las Fotos');
		}
		
		$ids=null;
		if(\Yii::$app->user->can('medico')) {
			$fotos=Foto::find()->where(['paciente_id' => $id])->all();
			if($fotos){
				foreach ($fotos as $key => $value) {
					$ids[] = $value['id'];
				}
			}
		}
		else {
			$paciente=Paciente::find()->where(['user_id' => $id])->one();
			$fotos=Foto::find()->where(['paciente_id' => $paciente['id']])->all();
			if($fotos){
				foreach ($fotos as $key => $value) {
					$ids[] = $value['id'];
				}
			}	
		}
		
		if($ids)
		{
			$query = File::find()->where(['in', 'itemId', $ids])->andWhere(['model' => 'Foto']);
	        if($query){
		        $dataProvider = new ActiveDataProvider([
		            'query' => $query,
		        ]);
				$fotos=$query->all();
			}
		}
		else
		{
			$dataProvider="";
			$fotos="";
		}

        return $this->render('galeria', [
            'model' => $model, 'dataProvider' => $dataProvider, 'fotos' => $fotos
        ]);
    }
	
	public function actionDelete($id)
    {
		$file = File::findOne($_GET['foto']);
		$fileAll = File::find()->where(['itemId' => $file['itemId'], 'model' => $_GET['type']])->all();

		if(count($fileAll) <= 1)
		{
			if($_GET['type'] == 'Foto')
        		Foto::findOne($file['itemId'])->delete();
			else
				$file->delete();
		}
		else
			$file->delete();
		
		if($_GET['type'] == 'Foto')
        	return $this->redirect(['foto/galeria?id='.$id]);
		else
			return $this->redirect(['examen/view?id='.$id]);
    }
	
	public function actionDownload($id)
    {
		$model = File::find()->where(['id' => $id])->andWhere(['model' => 'Foto'])->one();

		header ("Content-Disposition: attachment; filename=".$model->name.".".$model->type);
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize($model->path));
		readfile($model->path);
    }
}
