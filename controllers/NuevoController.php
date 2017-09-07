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
class NuevoController extends BaseAdminController
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
                        'actions' => ['paciente'],
                        'allow' => true,
                        'roles' => ['admin', 'medico'],
                    ],
                    [
                        'actions' => ['foto'],
                        'allow' => true,
                        'roles' => ['admin', 'paciente'],
                    ],
                    [
                        'actions' => ['galeria'],
                        'allow' => true,
                        'roles' => ['admin', 'medico', 'paciente'],
                    ],
                     [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin', 'medico', 'paciente'],
                    ],
                    [
                        'actions' => ['futuros'],
                        'allow' => true,
                        'roles' => ['?', '@', 'admin'],
                    ],
                ],
            ],
        ];
    }

    function actionPaciente()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
        if($user->load(\Yii::$app->request->post())){

            $user->username = $user->email;

            if ($user->create()) {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Pacient has been created'));
                $this->trigger(self::EVENT_AFTER_CREATE, $event);

                // colocarle rol de paciente
                $rol = Yii::createObject([
                    'class'   => Assignment::className(),
                    'user_id' => $user->id,
                ]);
                
                $rol->items = ['paciente'];
				
				$attributes=\Yii::$app->request->post();
				
				$profile = Profile::find()->where(['user_id' => $user->id])->one();
				$profile->name=$attributes['User']['name'];
				$profile->sexo=$attributes['User']['sexo'];
				$profile->peso=$attributes['User']['peso'];
				$profile->telefono=$attributes['User']['telefono'];
				$profile->fecha=Yii::$app->formatter->asDate($attributes['User']['fecha'], 'php: Y-m-d');
				$profile->save();
				
                $rol->updateAssignments();
				
                $paciente = new Paciente();
                $paciente->user_id = $user->id;
                $paciente->doctor_id = Yii::$app->user->identity->id;
                $paciente->save();
            }

            return $this->redirect(['paciente/index']);
        }

        return $this->render('create', [
            'user' => $user,
        ]);
    }

    public function actionFoto()
    {
        $model = new Foto();
		
		if(Yii::$app->request->post()) {
			
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$model->paciente_id = $paciente['id'];
			$model->fecha = date('Y-m-d');
			$model->save();

			return $this->redirect('/nuevo/galeria?id='.$paciente['user_id']);
			
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

        return $this->render('foto', [
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
        	return $this->redirect(['nuevo/galeria?id='.$id]);
		else
			return $this->redirect(['examen/view?id='.$id]);
    }
}
