<?php

namespace backend\modules\crud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WidgetType;

/**
 * WidgetTypeSearch represents the model behind the search form of `common\models\WidgetType`.
 */
class WidgetTypeSearch extends WidgetType
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'label_text_source_id', 'icon_source_id'], 'integer'],
      [['type', 'created_at', 'updated_at'], 'safe'],
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
    $query = WidgetType::find();

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
      'label_text_source_id' => $this->label_text_source_id,
      'icon_source_id' => $this->icon_source_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ]);

    $query->andFilterWhere(['ilike', 'type', $this->type]);

    return $dataProvider;
  }
}
