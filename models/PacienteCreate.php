<?php

namespace app\models;

use Yii;
use yii\base\Model;
use dektrium\user\models\User;
/**
 * This is the model class for table "paciente".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property integer $user_id
 *
 */
class PacienteCreate extends Model
{

    public $email;
    public $doctor_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'doctor_id'], 'required'],
            [['doctor_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doctor_id' => Yii::t('app', 'Doctor ID'),
        ];
    }

}
