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
use yii\helpers\Html;
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
use app\models\Formula;
use app\models\ControlCaja;
use app\models\Paciente;
use app\models\Periodo;
use app\models\Foto;
use app\models\Examen;
use app\models\Mensaje;
use nemmo\attachments\models\File;
use yii\data\ActiveDataProvider;
	
/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends BaseAdminController
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
                        'actions' => ['index', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['admin', 'medico', 'paciente'],
                    ],
                    [
                        'actions' => ['delete'],
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
						WHERE paciente.doctor_id = ".\Yii::$app->user->identity->id." AND (profile.user_id LIKE '%$search%' OR profile.cedula LIKE '%$search%' OR profile.name LIKE '%$search%')";
                
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
		
		$model = new Paciente();

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'model' => $model
        ]);
    }

	function actionCreate()
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
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'El Paciente ha sido Creado'));
                $this->trigger(self::EVENT_AFTER_CREATE, $event);

                // colocarle rol de paciente
                $rol = Yii::createObject([
                    'class'   => Assignment::className(),
                    'user_id' => $user->id,
                ]);
                
                $rol->items = ['paciente'];
				
				$attributes=\Yii::$app->request->post();
				
				$profile = Profile::find()->where(['user_id' => $user->id])->one();
				$profile->cedula=$attributes['User']['cedula'];
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

	public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$paciente=Paciente::find()->where(['id' => $id])->one();
		$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
		$profile->fecha=Yii::$app->formatter->asDate($profile['fecha'], 'php: d-m-Y');
		
        if($profile->load(Yii::$app->request->post())) {
			\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'El Paciente ha sido Actualizado'));
			
        	$attributes=Yii::$app->request->post();
			
			$profile->cedula=$attributes['Profile']['cedula'];
			$profile->name=$attributes['Profile']['name'];
			$profile->sexo=$attributes['Profile']['sexo'];
			$profile->peso=$attributes['Profile']['peso'];
			$profile->telefono=$attributes['Profile']['telefono'];
			$profile->fecha=Yii::$app->formatter->asDate($attributes['Profile']['fecha'], 'php: Y-m-d');
			$profile->save();

            return $this->redirect(['view', 'id' => $id]);
        } 
        else {
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

		$query=null;
		if(\Yii::$app->user->can('medico'))
		{
			$query=Periodo::find()->where(['paciente_id' => $id])->orderBy(['fecha' => SORT_DESC]);
				$dataProviderPeriodo = new ActiveDataProvider([
				'query' => $query
			]);
		}
		else
			$dataProviderPeriodo = '';
		
		$formula = new Formula();
		if($formula->load(Yii::$app->request->post())) {
			
			$formula->fecha = Yii::$app->formatter->asDate($formula->fecha, 'php: Y-m-d');

			if($formula->validate()) {
				$formula->save();
				
				//Creo el control de cajas
				$controlCajas = new ControlCaja();
				$controlCajas->paciente_id=$formula->paciente_id;
				$controlCajas->formula_id=$formula->id;
				$controlCajas->doctor_id= Yii::$app->user->id;
				$controlCajas->fecha=$formula->fecha;
				$controlCajas->cajaTomada=$formula->cajas;
				$controlCajas->dosisAcumulada=($formula->cajas)*(30*$formula->capsula);
				$controlCajas->dosisRestante=(($formula->peso*$formula->dosis)-($controlCajas->dosisAcumulada));
				$controlCajas->dosisCaja=((($formula->peso*$formula->dosis)/($formula->capsula*30))-($formula->cajas));
				$controlCajas->save();
			}
        } 
		
		$examen = new Examen();
		$examen->scenario = 'grafica';
		
		$formula = new Formula();
		
        $controlCaja = new ActiveDataProvider([
            'query' => ControlCaja::find()->where(['doctor_id' => Yii::$app->user->id, 'paciente_id' => $_GET['id']])
        ]);
		
		
		
		$modelP = new Periodo();
		$paciente=Paciente::find()->where(['id' => $_GET['id']])->one();
		$query = Periodo::find()->where(['paciente_id' => $paciente['id']])->orderBy(['fecha' => SORT_DESC]);
		$proximoPeriodo = null;
		if($query)
		{
			$paciente=$query->one();
			
			$fecha = $paciente['fecha'];
			if($fecha)
			{
				$proximoPeriodo = strtotime('+28 day', strtotime($fecha));
				$proximoPeriodo = date('d-m-Y', $proximoPeriodo);
			}
		}
		
		$periodos = Periodo::find()->where(['paciente_id' => $paciente['paciente_id']])->orderBy(['fecha' => SORT_DESC])->one();
		if($periodos)
		{
			$modelP->fechaI=$periodos['fecha'];
			$modelP->fechaF=$periodos['fechaFin'];
			$modelP->fechaA=Yii::$app->formatter->asDate($proximoPeriodo, 'php: Y-m-d');
		}
		
        return $this->render('view', [
            'model' => $this->findModel($id), 'dataProvider' => $dataProvider, 
            'dataProviderPeriodo' => $dataProviderPeriodo, 'examen' => $examen,
            'formula' => $formula, 'controlCaja' => $controlCaja, 'modelP' => $modelP
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
    	\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'El Paciente se ha eliminado'));
		
        $this->findModel($id)->delete();
		
		$examen=Examen::find()->where(['paciente_id' => $id])->all();
		if($examen){
			foreach ($examen as $value) {
				Examen::delete($value['id']);
			}
		}
		
		//File::find()->where(['itemId' => $i])->all()->delete();
		
		$foto=Foto::find()->where(['paciente_id' => $id])->all();
		if($foto){
			foreach ($foto as $value) {
				Foto::delete($value['id']);
			}
		}
		
		$msj=Mensaje::find()->where(['paciente_id' => $id])->all();
		if($msj){
			foreach ($msj as $value) {
				Mensaje::delete($value['id']);
			}
		}
		
		$periodo=Periodo::find()->where(['paciente_id' => $id])->all();
		if($periodo){
			foreach ($periodo as $value) {
				Periodo::delete($value['id']);
			}
		}
		
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
