<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "view".
 *
 * @property int $id
 * @property int|null $widget_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widget $widget
 */
class View extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'view';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['widget_id'], 'required'],
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
