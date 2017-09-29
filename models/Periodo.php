<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodo".
 *
 * @property integer $id
 * @property integer $paciente_id
 * @property string $fecha
 *
 * @property Paciente $paciente
 */
class Periodo extends \yii\db\ActiveRecord
{
	public $fechaI, $fechaF, $fechaFC, $fechaA;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente_id', 'fecha', 'fechaFin'], 'required'],
            [['paciente_id'], 'integer'],
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
            'paciente_id' => 'Paciente ID',
            'fecha' => 'Fecha Inicio de Periodo',
            'fechaFin' => 'Fecha Fin de Periodo',
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
