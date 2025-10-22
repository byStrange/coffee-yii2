<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $url
 * @property int $widget_id
 * @property bool $open_in_new_tab
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widget $widget
 */
class Link extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'link';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['url', 'widget_id', 'created_at', 'updated_at'], 'required'],
      [['widget_id'], 'default', 'value' => null],
      [['widget_id'], 'integer'],
      [['open_in_new_tab'], 'boolean'],
      [['created_at', 'updated_at'], 'safe'],
      [['url'], 'string', 'max' => 255],
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
      'url' => 'Url',
      'widget_id' => 'Widget ID',
      'open_in_new_tab' => 'Open In New Tab',
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
