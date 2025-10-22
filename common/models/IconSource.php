<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "icon_source".
 *
 * @property int $id
 * @property string $type Can be svg, image, boxicon
 * @property string $data Can be path to icon, or the svg data directly or the boxicon icon name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Icon[] $icons
 */
class IconSource extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'icon_source';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['type', 'data'], 'required'],
      [['data'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['type'], 'string', 'max' => 255],
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
      'type' => 'Can be svg, image, boxicon',
      'data' => 'Can be path to icon, or the svg data directly or the boxicon icon name',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Icons]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getIcons()
  {
    return $this->hasMany(Icon::class, ['icon_source_id' => 'id']);
  }
}
