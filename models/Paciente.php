<?php

namespace app\models;

use Yii;
use app\models\Profile;

/**
 * This is the model class for table "paciente".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property integer $user_id
 *
 * @property User $doctor
 * @property User $user
 */
class Paciente extends \yii\db\ActiveRecord
{
	public $cedula, $name, $sexo, $peso, $telefono, $fecha, $buscar;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'user_id'], 'required', 'on' => ['create', 'update']],
            [['doctor_id', 'user_id'], 'integer'],
            ["buscar", "match", "pattern" => "/^[0-9a-záéíóúñ\s]+$/i", "message" => "Sólo se aceptan letras y números"],
            'buscar' => ['buscar', 'required', 'on' => ['index']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doctor_id' => Yii::t('app', 'Doctor'),
            'user_id' => Yii::t('app', 'User'),
            'buscar' => Yii::t('app', 'Buscar'),
         
			'cedula' 	=> Yii::t('app','Cedula'),
            'name'     	=> Yii::t('app', 'Nombre'),
        	'sexo'    	=> Yii::t('app', 'Sexo'),
        	'peso'    	=> Yii::t('app', 'Peso'),
        	'telefono' 	=> Yii::t('app', 'Teléfono'),
        	'fecha'   	=> Yii::t('app','Fecha de Nacimiento'),
        ];
    }
	
	public function search()
    {
        
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(User::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return PacienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PacienteQuery(get_called_class());
    }
	
	public static function viewMenu()
    {
    	$profile=null;
		
       	if(\Yii::$app->user->can('paciente') && isset(Yii::$app->user->id))
		{
			$profile=Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

			if($profile && $profile['sexo'] == 'Mujer')
				return true;
		}

		return false;
    }
	
	public static function getSexo()
    {
    	$profile=null;
		
		if(isset($_GET['id']))
		{
			$paciente=Paciente::find()->where(['id' => $_GET['id']])->one();
			$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
		}
		
		if($profile && $profile['sexo'] == 'Mujer')
			return true;

		return false;
    }
}
