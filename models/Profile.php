<?php

namespace app\models;

use dektrium\user\models\Profile as BaseUser;

class Profile extends BaseUser
{
    public function init() {
        /*$this->on(self::BEFORE_REGISTER, function() {
            $this->username = $this->email;
        });*/

        parent::init();
    }

    public function rules() {
        $rules = parent::rules();
        
		$rules['name'] = ['name', 'required', 'on' => ['register', 'create', 'update']];
		$rules['sexo'] = ['sexo', 'required', 'on' => ['register', 'create', 'update']];
		$rules['peso'] = ['peso', 'required', 'on' => ['register', 'create', 'update']];
		$rules['telefono'] = ['telefono', 'required', 'on' => ['register', 'create', 'update']];
		$rules['fecha'] = ['fecha', 'required', 'on' => ['register', 'create', 'update']];
		
        return $rules;
    }
	
    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Nombre'),
        	'sexo'           => \Yii::t('user', 'Sexo'),
        	'peso'           => \Yii::t('user', 'Peso'),
        	'telefono'       => \Yii::t('user', 'Teléfono'),
        	'fecha'      	 => \Yii::t('user', 'Fecha de Nacimiento'),
        ];
    }
}