<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Trabajador;

/**
 * TrabajadorSearch represents the model behind the search form of `frontend\models\Trabajador`.
 */
class TrabajadorSearch extends Trabajador
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'primerApellido', 'segundoApellido', 'telefono', 'email'], 'safe'],
            [['CI', 'id', 'iduser'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Trabajador::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'CI' => $this->CI,
            'id' => $this->id,
            'iduser' => $this->iduser,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'primerApellido', $this->primerApellido])
            ->andFilterWhere(['like', 'segundoApellido', $this->segundoApellido])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
