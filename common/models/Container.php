<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "container".
 *
 * @property int $id
 * @property int $widget_id
 * @property string $gap_size_x Can be valid CSS size
 * @property string $gap_size_y Can be be valid CSS size
 * @property string $direction Can be column, row, column-reverse, row-reverse
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widget $widget
 */
class Container extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'container';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['widget_id', 'gap_size_x', 'gap_size_y'], 'required'],
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['widget_id'], 'unique'],
      [['created_at', 'updated_at'], 'safe'],
      [['gap_size_x', 'gap_size_y', 'direction'], 'string', 'max' => 255],
      [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => Widget::class, 'targetAttribute' => ['widget_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'widget_id' => 'Widget ID',
      'gap_size_x' => 'Can be valid CSS size',
      'gap_size_y' => 'Can be be valid CSS size',
      'direction' => 'Can be column, row, column-reverse, row-reverse',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
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
