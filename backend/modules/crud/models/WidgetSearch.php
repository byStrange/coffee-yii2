<?php

namespace backend\modules\crud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Widget;

/**
 * WidgetSearch represents the model behind the search form of `common\models\Widget`.
 */
class WidgetSearch extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'widget_type_id', 'class', 'order', 'parent_widget_id', 'section_id'], 'integer'],
            [['style', 'background', 'margin', 'padding', 'created_at', 'updated_at'], 'safe'],
            [['hidden', 'center'], 'boolean'],
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
        $query = Widget::find();

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
            'widget_type_id' => $this->widget_type_id,
            'class' => $this->class,
            'hidden' => $this->hidden,
            'order' => $this->order,
            'parent_widget_id' => $this->parent_widget_id,
            'section_id' => $this->section_id,
            'center' => $this->center,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'style', $this->style])
            ->andFilterWhere(['ilike', 'background', $this->background])
            ->andFilterWhere(['ilike', 'margin', $this->margin])
            ->andFilterWhere(['ilike', 'padding', $this->padding]);

        return $dataProvider;
    }
}
