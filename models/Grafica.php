<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grafica".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $tipo
 * @property string $valorExamen
 * @property string $valorReferencia
 */
class Grafica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grafica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente_id', 'fecha', 'tipo', 'valorExamen', 'valorReferencia'], 'required'],
            [['paciente_id'], 'integer'],
            [['fecha'], 'safe'],
            [['tipo', 'valorExamen', 'valorReferencia'], 'string', 'max' => 255],
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
            'fecha' => 'Fecha',
            'tipo' => 'Tipo',
            'valorExamen' => 'Valor Examen',
            'valorReferencia' => 'Valor Referencia',
        ];
    }
}
