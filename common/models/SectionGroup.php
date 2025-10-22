<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "section_group".
 *
 * @property int $id
 * @property int $label
 * @property int $order
 * @property bool $hidden
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Section[] $sections
 */
class SectionGroup extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'section_group';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['label', 'order'], 'required'],
      [['label', 'order'], 'default', 'value' => null],
      [['label', 'order'], 'integer'],
      [['hidden'], 'boolean'],
      [['created_at', 'updated_at'], 'safe'],
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
      'order' => 'Order',
      'hidden' => 'Hidden',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Sections]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getSections()
  {
    return $this->hasMany(Section::class, ['section_group_id' => 'id']);
  }
}
