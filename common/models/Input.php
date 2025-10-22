<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "input".
 *
 * @property int $id
 * @property int $placeholder_text_source_id
 * @property int $widget_id
 * @property string|null $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TextSource $placeholderTextSource
 */
class Input extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'input';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['placeholder_text_source_id', 'widget_id'], 'required'],
      [['placeholder_text_source_id', 'widget_id'], 'default', 'value' => null],
      [['placeholder_text_source_id', 'widget_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['name'], 'string', 'max' => 255],
      [['placeholder_text_source_id'], 'unique'],
      [['widget_id'], 'unique'],
      [['placeholder_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['placeholder_text_source_id' => 'id']],
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
      'placeholder_text_source_id' => 'Placeholder Text Source ID',
      'widget_id' => 'Widget ID',
      'name' => 'Name',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[PlaceholderTextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getPlaceholderTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'placeholder_text_source_id']);
  }
  public function generateSchema()
  {
    $attributes = $this->attributes();
    $generated = [];
    $textSource = new TextSource();

    foreach ($attributes as $key => $value) {
      $generated[$value] = "";
    }

    $generated['placeholderTextSource'] = $textSource->generateSchema();

    return $generated;
  }
}
