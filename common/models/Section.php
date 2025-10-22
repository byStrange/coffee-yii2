<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property int|null $text_id Serves as a title
 * @property int $section_group_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SectionGroup $sectionGroup
 * @property Text $text
 */
class Section extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'section';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text_id', 'section_group_id'], 'default', 'value' => null],
      [['text_id', 'section_group_id'], 'integer'],
      [['section_group_id'], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['section_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SectionGroup::class, 'targetAttribute' => ['section_group_id' => 'id']],
      [['text_id'], 'exist', 'skipOnError' => true, 'targetClass' => Text::class, 'targetAttribute' => ['text_id' => 'id']],
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
      'text_id' => 'Serves as a title',
      'section_group_id' => 'Section Group ID',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[SectionGroup]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getSectionGroup()
  {
    return $this->hasOne(SectionGroup::class, ['id' => 'section_group_id']);
  }

  /**
   * Gets query for [[Text]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getText()
  {
    return $this->hasOne(Text::class, ['id' => 'text_id']);
  }
}
