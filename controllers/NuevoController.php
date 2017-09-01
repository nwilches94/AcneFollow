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
                        'actions' => ['futuros'],
                        'allow' => true,
                        'roles' => ['?', '@', 'admin'],
                    ],
                ],
            ],
        ];
    }


    function actionPaciente(){
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
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));
                $this->trigger(self::EVENT_AFTER_CREATE, $event);

                // colocarle rol de paciente

                $rol = Yii::createObject([
                    'class'   => Assignment::className(),
                    'user_id' => $user->id,
                ]);
                
                $rol->items = ['paciente'];

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

    function actionPacienteExistente($id){

    }

}
