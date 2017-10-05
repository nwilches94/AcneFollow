<?php

namespace app\models;

use dektrium\user\models\Profile as BaseUser;
use Yii;
use yii\helpers\ArrayHelper;

class Profile extends BaseUser
{
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
			$rules['cedulaRequired'] = ['cedula', 'integer'];
			$rules['cedulaPattern'] = ['cedula', 'required', 'on' => ['register', 'create', 'update']];
			$rules['sexo'] = ['sexo', 'required', 'on' => ['register', 'create', 'update']];
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
            'peso'              => \Yii::t('user', 'Peso Kg'),
            'telefono'          => \Yii::t('user', 'Teléfono'),
            'fecha'         	=> \Yii::t('user', 'Fecha de Nacimiento'),
        ];
    }

	public function getName()
    {
    	if(Yii::$app->user->id)
			return Profile::find()->where(['user_id' => Yii::$app->user->id])->one()->name;
		
		return 'Usuario';
    }
	
	public function getEdad($fecha)
	{
		list($anyo,$mes,$dia) = explode("-",$fecha);
		
		$anyo_dif = date("Y") - $anyo;
		$mes_dif  = date("m") - $mes;
		$dia_dif  = date("d") - $dia;
		
		if($dia_dif < 0 || $mes_dif < 0) 
			$anyo_dif--;
		
		return $anyo_dif." años"; 
	}
}