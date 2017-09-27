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
	public $buscar;
	
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
	
	public function getListaPaciente()
    {
    	$listaPaciente=null;
		if(\Yii::$app->user->can('medico')) {
			$pacientes=Paciente::find()->where(['doctor_id' => Yii::$app->user->id])->all();
			if($pacientes) {
				foreach ($pacientes as $value) {
					$user=Profile::find()->where(['user_id' => $value['user_id']])->one();
					$listaPaciente[$value['id']] = $user['cedula']." - ".$user['name'];
				}
			}
		}
		
		return $listaPaciente;
	}
	
	public function getDataProvider($search)
    {
    	$buscar="";
    	if($search)
			$buscar = " AND (profile.user_id LIKE '$search' OR profile.cedula LIKE '$search' OR profile.name LIKE '%$search%')";
    	
    	$query=null;
		if(\Yii::$app->user->can('medico'))
		{
			if($search)
				$buscar = " WHERE (profile.user_id LIKE '$search' OR profile.cedula LIKE '$search' OR profile.name LIKE '%$search%')";
    	
			$sql =	"SELECT
					IF(MAX(mensaje.id) , MAX(mensaje.id) , 0) AS id,
					IF(mensaje.paciente_id,  mensaje.paciente_id, paciente.id) AS paciente_id,
					IF(mensaje.doctor_id,  mensaje.doctor_id, paciente.doctor_id) AS doctor_id,
					mensaje.mensaje, mensaje.leido, mensaje.origen,  mensaje.fecha, mensaje.ampm
					FROM paciente
					LEFT OUTER JOIN mensaje ON mensaje.paciente_id = paciente.id AND mensaje.origen='paciente' AND mensaje.doctor_id=".Yii::$app->user->id."
					LEFT OUTER JOIN profile ON profile.user_id = paciente.user_id
					".$buscar."
					GROUP BY mensaje.doctor_id, mensaje.paciente_id
					ORDER BY mensaje.doctor_id, mensaje.paciente_id";
					
            $query = Mensaje::findBySql($sql);
		}
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			
			if($paciente)
			{
				$sql =	"SELECT mensaje.* 
						FROM mensaje
						JOIN paciente ON paciente.id = mensaje.paciente_id 
						JOIN profile ON profile.user_id = paciente.doctor_id
						WHERE mensaje.origen='medico' AND mensaje.paciente_id=".$paciente['id']." AND mensaje.id IN (
							SELECT MAX(id) AS id 
							FROM mensaje
							WHERE origen='medico' AND paciente_id=".$paciente['id']." 
							GROUP BY doctor_id, paciente_id
							ORDER BY doctor_id, paciente_id
						)
						".$buscar."
						GROUP BY mensaje.doctor_id, mensaje.paciente_id
						ORDER BY mensaje.doctor_id, mensaje.paciente_id";
						
				$query = Mensaje::findBySql($sql);
			}
		}
		
		return $query;
	}
	
	public function getCount()
    {
    	$count=0;
		if(\Yii::$app->user->can('medico'))
			$query = Mensaje::find()->where(['origen' => 'paciente', 'doctor_id' => \Yii::$app->user->identity->id]);
		else
		{
			$paciente=Paciente::find()->where(['user_id' => Yii::$app->user->id])->one();
			$query = Mensaje::find()->where(['origen' => 'medico', 'paciente_id' => $paciente['id']]);
		}
		
		$count=0;
		if($query)
		{
			$registros = $query->all();
			if($registros) {
				foreach($registros as $value) {
					if($value['leido'] == 0)
						$count += 1;
				}
			}
		}
		
		return $count;
	}
}
