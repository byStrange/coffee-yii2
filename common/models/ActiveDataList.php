<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "active_data_list".
 *
 * @property int $id
 * @property int $data_provider_id
 * @property string|null $filter
 * @property int|null $limit
 * @property int $widget_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DataProvider $dataProvider
 * @property Widget $widget
 */
class ActiveDataList extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'active_data_list';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['data_provider_id', 'widget_id'], 'required'],
      [['data_provider_id', 'limit', 'widget_id'], 'default', 'value' => null],
      [['data_provider_id', 'limit', 'widget_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['filter'], 'string', 'max' => 255],
      [['widget_id'], 'unique'],
      [['data_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataProvider::class, 'targetAttribute' => ['data_provider_id' => 'id']],
      [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => Widget::class, 'targetAttribute' => ['widget_id' => 'id']],
    ];
  }

  public function behaviors()
  {
    return [
      'timestamp' => [
        'class' => TimestampBehavior::class,
        'createdAtAttribute' => 'created_at',
        'updatedAtAttribute' => 'updated_at',
        'value' => new \yii\db\Expression('NOW()'),

      ]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'data_provider_id' => 'Data Provider ID',
      'filter' => 'Filter',
      'limit' => 'Limit',
      'widget_id' => 'Widget ID',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[DataProvider]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getDataProvider()
  {
    return $this->hasOne(DataProvider::class, ['id' => 'data_provider_id']);
  }

  /**
   * Gets query for [[Widget]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getWidget()
  {
    return $this->hasOne(Widget::class, ['id' => 'widget_id']);
  }
}
