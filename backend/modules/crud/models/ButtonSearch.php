<?php

namespace backend\modules\crud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Button;

/**
 * ButtonSearch represents the model behind the search form of `common\models\Button`.
 */
class ButtonSearch extends Button
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'widget_id'], 'integer'],
            [['action_type', 'action_data', 'created_at', 'updated_at'], 'safe'],
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
        $query = Button::find();

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
            'widget_id' => $this->widget_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'action_type', $this->action_type])
            ->andFilterWhere(['ilike', 'action_data', $this->action_data]);

        return $dataProvider;
    }
}
