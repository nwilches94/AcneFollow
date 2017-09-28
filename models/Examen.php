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
	public $valorE, $valorR;
	
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
            [['paciente_id', 'fecha', 'tipo'], 'required'],
            [['fecha', 'tipo', 'valorE', 'valorR'], 'required', 'on' => ['grafica']],
            [['paciente_id'], 'integer'],
            [['tipo', 'notas'], 'string'],
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
            'paciente_id' => Yii::t('app', 'Paciente'),
            'fecha' => Yii::t('app', 'Fecha del Examen'),
            'notas' => Yii::t('app', 'Notas'),
            'tipo' => Yii::t('app', 'Tipo de Examen')
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
	
	public function changeDate($fecha, $option)
	{
		if($fecha)
		{
			$mesesNum = ['enero'=>'01', 'febrero'=>'02', 'marzo'=>'03', 'abril'=>'04', 'mayo'=>'05', 'junio'=>'06', 'julio'=>'07',
						 'agosto'=>'08', 'septiembre'=>'09', 'octubre'=>'10', 'noviembre'=>'11', 'diciembre'=>'12'];
			
			$numMeses = ['01'=>'enero',  '02'=>'febrero', '03'=>'marzo', '04'=>'abril', '05'=>'mayo', '06'=>'junio', '07'=>'julio',
						 '08'=>'agosto', '09'=>'septiembre', '10'=>'octubre', '11'=>'noviembre', '12'=>'diciembre'];
					
			if(!$option) {
				$f=explode(" ", $fecha);
				return $f[1]."-".$mesesNum[$f[0]]."-01";
			}
			else {
				
				if($option == 1) {
					$f=explode("-", $fecha);
					return $numMeses[$f[1]]." ".$f[0];
				}
				else
				{
					$numMeses = ['01'=>'Ene', '02'=>'Feb', '03'=>'Mar', '04'=>'Abr', '05'=>'May', '06'=>'Jun', 
							     '07'=>'Jul', '08'=>'Ago', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic'];
					
					$f=explode("-", $fecha);
					return $numMeses[$f[1]];
				}
			}
		}
		
		return;
	}
}
