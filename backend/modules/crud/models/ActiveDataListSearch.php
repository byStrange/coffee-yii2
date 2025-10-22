<?php

namespace backend\modules\crud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ActiveDataList;

/**
 * ActiveDataListSearch represents the model behind the search form of `common\models\ActiveDataList`.
 */
class ActiveDataListSearch extends ActiveDataList
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'data_provider_id', 'limit', 'widget_id'], 'integer'],
      [['filter', 'created_at', 'updated_at'], 'safe'],
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
    $query = ActiveDataList::find();

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
      'data_provider_id' => $this->data_provider_id,
      'limit' => $this->limit,
      'widget_id' => $this->widget_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ]);

    $query->andFilterWhere(['ilike', 'filter', $this->filter]);

    return $dataProvider;
  }
}
