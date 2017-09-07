<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;
use yii;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
	public $name, $sexo, $peso, $telefono, $fecha;
	
    public function init() {
        $this->on(self::BEFORE_REGISTER, function() {
            $this->username = $this->email;
        });
        $this->on(self::BEFORE_CREATE, function() {
            $this->username = $this->email;
        });

        parent::init();
    }

    public function rules() {
        $rules = parent::rules();
        unset($rules['usernameRequired']);
		
		if(!Yii::$app->user->identity->isAdmin)
		{
			$rules['name'] = ['name', 'required', 'on' => ['register', 'create', 'update']];
			$rules['sexo'] = ['sexo', 'required', 'on' => ['register', 'create', 'update']];
			$rules['peso'] = ['peso', 'required', 'on' => ['register', 'create', 'update']];
			$rules['telefono'] = ['telefono', 'required', 'on' => ['register', 'create', 'update']];
			$rules['fecha'] = ['fecha', 'required', 'on' => ['register', 'create', 'update']];
		}
		
        return $rules;
    }
	
    public function attributeLabels()
    {
        return [
            'name'         		=> \Yii::t('user', 'Nombres'),
            'sexo'              => \Yii::t('user', 'Sexo'),
            'peso'              => \Yii::t('user', 'Peso'),
            'telefono'          => \Yii::t('user', 'Teléfono'),
            'fecha'         	=> \Yii::t('user', 'Fecha de Nacimiento'),
        ];
    }
}