<?php

namespace app\models;

use dektrium\user\models\Profile as BaseUser;
use Yii;

class Profile extends BaseUser
{
	const BEFORE_CREATE   = 'beforeCreate';
    const BEFORE_REGISTER = 'beforeRegister';
	
	public function init() {
        /*$this->on(self::BEFORE_REGISTER, function() {
            $this->name = $this->name;
        });
        $this->on(self::BEFORE_CREATE, function() {
            $this->name = $this->name;
        });*/

        parent::init();
    }

    public function rules() {
        $rules = parent::rules();
        
		$rules['name'] = ['name', 'required', 'on' => ['register', 'create', 'update']];
		
		if(!Yii::$app->user->identity->isAdmin)
		{
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
            'name'           => \Yii::t('user', 'Nombre'),
        	'sexo'           => \Yii::t('user', 'Sexo'),
        	'peso'           => \Yii::t('user', 'Peso'),
        	'telefono'       => \Yii::t('user', 'Teléfono'),
        	'fecha'      	 => \Yii::t('user', 'Fecha de Nacimiento'),
        ];
    }
	
	public function getName()
    {
		return Profile::find()->where(['user_id' => Yii::$app->user->id])->one()->name;
    }
}