<?php

namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "examen".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $paciente_id
 * @property string $fecha
 * @property string $notas
 *
 * @property Paciente $paciente
 */
class Examen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examen';
    }

    public function behaviors()
    {
        return [
            'fileBehavior' => [
                'class' => \nemmo\attachments\behaviors\FileBehavior::className()
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'fecha'], 'safe'],
            [['paciente_id'], 'required'],
            [['paciente_id'], 'integer'],
            [['notas'], 'string'],
            [['paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['paciente_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'paciente_id' => Yii::t('app', 'Paciente ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'paciente_id']);
    }

    /**
     * @inheritdoc
     * @return ExamenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExamenQuery(get_called_class());
    }
}
