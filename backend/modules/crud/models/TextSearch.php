<?php

namespace backend\modules\crud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Text;

/**
 * TextSearch represents the model behind the search form of `common\models\Text`.
 */
class TextSearch extends Text
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'text_source_id', 'widget_id'], 'integer'],
            [['styles', 'size', 'font_family', 'align', 'letter_spacing', 'color', 'created_at', 'updated_at'], 'safe'],
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
        $query = Text::find();

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
            'text_source_id' => $this->text_source_id,
            'widget_id' => $this->widget_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'styles', $this->styles])
            ->andFilterWhere(['ilike', 'size', $this->size])
            ->andFilterWhere(['ilike', 'font_family', $this->font_family])
            ->andFilterWhere(['ilike', 'align', $this->align])
            ->andFilterWhere(['ilike', 'letter_spacing', $this->letter_spacing])
            ->andFilterWhere(['ilike', 'color', $this->color]);

        return $dataProvider;
    }
}
