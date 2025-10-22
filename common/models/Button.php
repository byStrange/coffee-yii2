<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "button".
 *
 * @property int $id
 * @property int $widget_id
 * @property string $action_type Can be navigate or jsexpression
 * @property string $action_data
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widget $widget
 */
class Button extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'button';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['widget_id', 'action_type', 'action_data'], 'required'],
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['action_type', 'action_data'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['widget_id'], 'unique'],
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
      'widget_id' => 'Widget ID',
      'action_type' => 'Can be navigate or jsexpression',
      'action_data' => 'Action Data',
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
    // Get all attributes of the model
    $attributes = $this->attributes();

    $generated = [];

    foreach ($attributes as $key => $value) {
      $generated[$value] = "";
    }

    return $generated;
  }
}
