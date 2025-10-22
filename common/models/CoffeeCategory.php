<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "coffee_category".
 *
 * @property int $id
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Coffee[] $coffees
 */
class CoffeeCategory extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'coffee_category';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['label'], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['label'], 'string', 'max' => 255],
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
      'label' => 'Label',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Coffees]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoffees()
  {
    return $this->hasMany(Coffee::class, ['category_id' => 'id']);
  }
}
