<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Empresa;

/**
 * EmpresaSearch represents the model behind the search form of `frontend\models\Empresa`.
 */
class EmpresaSearch extends Empresa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'provinciaid', 'status'], 'integer'],
            [['nombre', 'nombre_corto', 'direccion', 'email', 'telefono'], 'safe'],
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
        $query = Empresa::find();

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
            'id' => $this->id,
            'provinciaid' => $this->provinciaid,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'nombre_corto', $this->nombre_corto])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
