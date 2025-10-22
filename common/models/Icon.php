<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "icon".
 *
 * @property int $id
 * @property int $widget_id
 * @property string $size Size in pixels, or rems or in percentage
 * @property int $icon_source_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property IconSource $iconSource
 * @property Widget $widget
 */
class Icon extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'icon';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['widget_id', 'icon_source_id'], 'required'],
      [['widget_id', 'icon_source_id'], 'default', 'value' => null],
      [['widget_id', 'icon_source_id'], 'integer'],
      [['widget_id'], 'unique'],
      [['created_at', 'updated_at'], 'safe'],
      [['size'], 'string', 'max' => 255],
      [['icon_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => IconSource::class, 'targetAttribute' => ['icon_source_id' => 'id']],
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
      'size' => 'Size in pixels, or rems or in percentage',
      'icon_source_id' => 'Icon Source ID',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }



  /**
   * Gets query for [[IconSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getIconSource()
  {
    return $this->hasOne(IconSource::class, ['id' => 'icon_source_id']);
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
