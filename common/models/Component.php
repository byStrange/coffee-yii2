<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "component".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $widget_id
 *
 * @property ComponentWidget $componentWidget
 * @property Widget $widget
 */
class Component extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'component';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['name', 'widget_id'], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['name', 'description'], 'string', 'max' => 255],
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
      'name' => 'Name',
      'description' => 'Description',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
      'widget_id' => 'Widget ID',
    ];
  }

  /**
   * Gets query for [[ComponentWidget]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComponentWidget()
  {
    return $this->hasOne(ComponentWidget::class, ['component_id' => 'id']);
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
