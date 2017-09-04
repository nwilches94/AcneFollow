<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensaje".
 *
 * @property integer $id
 * @property integer $paciente_id
 * @property integer $doctor_id
 * @property string $mensaje
 * @property string $leido
 * @property string $fecha
 *
 * @property Paciente $paciente
 */
class Mensaje extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensaje';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente_id', 'doctor_id', 'mensaje', 'leido', 'fecha'], 'required'],
            [['paciente_id', 'doctor_id'], 'integer'],
            [['mensaje'], 'string'],
            [['fecha'], 'safe'],
            [['leido'], 'integer', 'max' => 1],
            [['paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['paciente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paciente_id' => 'Paciente ID',
            'doctor_id' => 'Doctor ID',
            'mensaje' => 'Mensaje',
            'leido' => 'Leido',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'paciente_id']);
    }
	
	public function nuevoMensaje($id)
    {
        $model = Mensaje::find()->where(['id' => $id])->one();
		if(!$model['leido'])
			$style = 'font-weight:bold; color:#777777';
		else
			$style = 'font-weight:normal';

		return $style;
    }
	
	public function getLabel()
    {
   		if(\Yii::$app->user->can('paciente'))
			return 'Médico';
		else
			return 'Paciente';
    }	
}
