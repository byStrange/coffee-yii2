<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "component_widget".
 *
 * @property int $id
 * @property int $component_id
 * @property int $widget_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Component $component
 * @property Widget $widget
 */
class ComponentWidget extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'component_widget';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['component_id', 'widget_id'], 'required'],
      [['component_id', 'widget_id'], 'default', 'value' => null],
      [['component_id', 'widget_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['widget_id'], 'unique'],
      [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['component_id' => 'id']],
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
      'component_id' => 'Component ID',
      'widget_id' => 'Widget ID',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Component]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComponent()
  {
    return $this->hasOne(Component::class, ['id' => 'component_id']);
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
