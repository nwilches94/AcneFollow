<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;
use yii;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
	const AFTER_UPDATE = 'afterUpdate';
	
	public $cedula, $name, $sexo, $peso, $telefono, $fecha;
	
    public function init() {
        $this->on(self::BEFORE_REGISTER, function() {
            $this->username = $this->email;
        });
        $this->on(self::BEFORE_CREATE, function() {
            $this->username = $this->email;
        });
		
		$this->on(self::AFTER_REGISTER, function() {
            $this->username = $this->email;
			$profile=Profile::find()->where(['user_id' => $this->id])->one();
			$profile->name=$this->name;
			$profile->save();
        });
		$this->on(self::AFTER_CREATE, function() {
            $this->username = $this->email;
			$profile=Profile::find()->where(['user_id' => $this->id])->one();
			$profile->name=$this->name;
			$profile->save();
        });
		
		$this->on(self::AFTER_UPDATE, function() {
            $this->username = $this->email;
			$profile=Profile::find()->where(['user_id' => $this->id])->one();
			$profile->name=$this->name;
			$profile->save();
        });
		
        parent::init();
    }

    public function rules() {
        $rules = parent::rules();
        unset($rules['usernameRequired']);
		
		$rules['name'] = ['name', 'required', 'on' => ['register', 'create', 'update']];
		
		if(!Yii::$app->user->identity->isAdmin)
		{
			$rules['cedulaRequired'] = ['cedula', 'integer'];
			$rules['cedulaPattern'] = ['cedula', 'required', 'on' => ['register', 'create', 'update']];
			$rules['sexo'] = ['sexo', 'required', 'on' => ['register', 'create', 'update']];
			$rules['pesoRequired'] = ['peso', 'integer'];
			$rules['pesoPattern'] = ['peso', 'required', 'on' => ['register', 'create', 'update']];
			$rules['telefono'] = ['telefono', 'required', 'on' => ['register', 'create', 'update']];
			$rules['fecha'] = ['fecha', 'required', 'on' => ['register', 'create', 'update']];
		}
		
        return $rules;
    }
	
    public function attributeLabels()
    {
        return [
            'cedula'         	=> \Yii::t('user', 'Cédula'),
            'name'         		=> \Yii::t('user', 'Nombres'),
            'sexo'              => \Yii::t('user', 'Sexo'),
            'peso'              => \Yii::t('user', 'Peso'),
            'telefono'          => \Yii::t('user', 'Teléfono'),
            'fecha'         	=> \Yii::t('user', 'Fecha de Nacimiento'),
            'password'			=> \Yii::t('user', 'Contraseña')
        ];
    }
}