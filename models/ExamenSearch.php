<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Examen;

/**
 * ExamenSearch represents the model behind the search form about `app\models\Examen`.
 */
class ExamenSearch extends Examen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'paciente_id'], 'integer'],
            [['created_at', 'updated_at', 'fecha', 'tipo', 'notas'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Examen::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		if(\Yii::$app->user->can('paciente')){
	        // grid filtering conditions
	        $query->andFilterWhere([
	            'paciente_id' => Paciente::find()->where(['user_id' => Yii::$app->user->id])->one()->id,
	            'tipo' => $this->tipo
	        ]);
		}
		else{
			// grid filtering conditions
	        $query->andFilterWhere([
	            'tipo' => $this->tipo
	        ]);	
		}
        
        if($this->fecha){
			$mesesNum = ['Ene'=>'01', 'Feb'=>'02', 'Mar'=>'03', 'Abr'=>'04', 'May'=>'05', 'Jun'=>'06', 
						 'Jul'=>'07', 'Ago'=>'08', 'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dic'=>'12'];
			
			$ban=0;
			foreach ($mesesNum as $key => $value) {
				if($key == $this->fecha) 
					$ban=1;
			}
			
			if($ban) {
				$query->andFilterWhere([
					'and',
			    	['like', 'fecha', $mesesNum[$this->fecha]]
				]);
			}
	 
	        $query->andFilterWhere([
			    'or',
			    ['like', 'fecha', $this->fecha],
			    ['like', 'fecha', Yii::$app->formatter->asDate($this->fecha, 'php:Y')]
			]);
		}
		
		$query->andFilterWhere(['like', 'notas', $this->notas]);
		
        return $dataProvider;
    }
}
