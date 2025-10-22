<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "text_translation".
 *
 * @property int $id
 * @property int $text_source_id
 * @property string $language_code
 * @property string $translation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TextSource $textSource
 */
class TextTranslation extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'text_translation';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text_source_id', 'language_code', 'translation'], 'required'],
      [['text_source_id'], 'default', 'value' => null],
      [['text_source_id'], 'integer'],
      [['translation'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['language_code'], 'string', 'max' => 255],
      [['text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['text_source_id' => 'id']],
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
      'text_source_id' => 'Text Source ID',
      'language_code' => 'Language Code',
      'translation' => 'Translation',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[TextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'text_source_id']);
  }
}
