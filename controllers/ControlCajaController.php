<?php

namespace app\controllers;

use Yii;
use app\models\ControlCaja;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Paciente;
use dektrium\user\models\Profile;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;

/**
 * ControlCajaController implements the CRUD actions for ControlCaja model.
 */
class ControlCajaController extends BaseAdminController
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
                        'actions' => ['view', 'create', 'update', 'delete'],
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

    /**
     * Lists all ControlCaja models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(\Yii::$app->user->can('medico'))
    		$query = ControlCaja::find()->where(['doctor_id' => Yii::$app->user->id]);
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
    		$query = ControlCaja::find()->where(['paciente_id' => $paciente['id']]);
		}
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ControlCaja model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ControlCaja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ControlCaja();
		
        if($model->load(Yii::$app->request->post())) {
        	
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');

			if($model->validate()) {
				$model->save();
				
				return $this->redirect(['index']);
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
		
		return $this->render('create', [
            'model' => $model, 'listaPaciente' => $listaPaciente
        ]);
    }

    /**
     * Updates an existing ControlCaja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if($model->load(Yii::$app->request->post())) {
        	
			$model->fecha = Yii::$app->formatter->asDate($model->fecha, 'php: Y-m-d');

			if($model->validate()) {
				$model->save();
				
				return $this->redirect(['index']);
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

    /**
     * Deletes an existing ControlCaja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		\Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Fórmula Eliminada'));
		
        return $this->redirect(['/paciente/view', 'id' => $_GET['paciente_id']]);
    }

    /**
     * Finds the ControlCaja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ControlCaja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ControlCaja::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
