<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formula".
 *
 * @property integer $id
 * @property integer $paciente_id
 * @property string $fecha
 * @property integer $dosis
 * @property integer $capsula
 * @property integer $cajas
 *
 * @property Paciente $paciente
 */
class Formula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente_id', 'doctor_id', 'fecha', 'dosis', 'capsula', 'cajas'], 'required'],
            [['paciente_id', 'doctor_id', 'dosis', 'capsula', 'cajas'], 'integer'],
            [['fecha'], 'safe'],
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
            'paciente_id' => 'Paciente',
            'doctor_id' => 'Doctor',
            'fecha' => 'Fecha',
            'dosis' => 'Dosis',
            'capsula' => 'Capsula',
            'cajas' => 'Cajas Tomadas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'paciente_id']);
    }
}
