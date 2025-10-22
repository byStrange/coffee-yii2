<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $widget_id
 * @property string $src
 * @property string|null $alt
 * @property string|null $width Can be valid CSS size, defaults to image width itself
 * @property string|null $height Can be valid CSS size, defaults to image height itself
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widget $widget
 */
class Image extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'image';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['widget_id', 'src'], 'required'],
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['src', 'alt', 'width', 'height'], 'string', 'max' => 255],
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
      'src' => 'Src',
      'alt' => 'Alt',
      'width' => 'Can be valid CSS size, defaults to image width itself',
      'height' => 'Can be valid CSS size, defaults to image height itself',
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
