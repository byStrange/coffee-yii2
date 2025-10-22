<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "data_provider".
 *
 * @property int $id
 * @property string $table_name
 * @property string $columns
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ActiveDataList[] $activeDataLists
 */
class DataProvider extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'data_provider';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['table_name', 'columns',], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['table_name', 'columns'], 'string', 'max' => 255],
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
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'table_name' => 'Table Name',
      'columns' => 'Columns',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[ActiveDataLists]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getActiveDataLists()
  {
    return $this->hasMany(ActiveDataList::class, ['data_provider_id' => 'id']);
  }
  public function generateSchema()
  {
    $attributes = $this->attributes();
    $generated = [];

    foreach ($attributes as $key => $value) {
      $generated[$value] = "";
    }

    return $generated;
  }
}
