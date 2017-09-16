<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "controlCaja".
 *
 * @property integer $id
 * @property integer $paciente_id
 * @property integer $doctor_id
 * @property string $fecha
 * @property integer $cajaTomada
 * @property integer $dosisAcumulada
 * @property integer $dosisRestante
 * @property integer $dosisCaja
 */
class ControlCaja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'controlCaja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente_id', 'doctor_id', 'fecha', 'cajaTomada', 'dosisAcumulada', 'dosisRestante', 'dosisCaja'], 'required'],
            [['paciente_id', 'doctor_id', 'cajaTomada'], 'integer'],
            [['dosisAcumulada', 'dosisRestante', 'dosisCaja'], 'number'],
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
            'cajaTomada' => '# Cajas Tomadas',
            'dosisAcumulada' => 'Dosis Acumuladas',
            'dosisRestante' => 'Dosis Restantes (mg)',
            'dosisCaja' => 'Dosis Restante de Cajas',
        ];
    }
}
