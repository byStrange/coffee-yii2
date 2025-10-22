<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "text".
 *
 * @property int $id
 * @property int $text_source_id
 * @property int $widget_id
 * @property string|null $styles Can be "bold" "italic" "underline"
 * @property string $size Size in pixels, or rems or in percentage
 * @property string|null $font_family
 * @property string|null $align Defines the text align (left, center, right)
 * @property string|null $letter_spacing
 * @property string|null $color
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Section[] $sections
 * @property TextSource $textSource
 * @property Widget $widget
 */
class Text extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'text';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text_source_id', 'widget_id'], 'required'],
      [['text_source_id', 'widget_id'], 'default', 'value' => null],
      [['text_source_id', 'widget_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['styles', 'size', 'font_family', 'align', 'letter_spacing', 'color'], 'string', 'max' => 255],
      [['widget_id'], 'unique'],
      [['text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['text_source_id' => 'id']],
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
      'text_source_id' => 'Text Source ID',
      'widget_id' => 'Widget ID',
      'styles' => 'Can be \"bold\" \"italic\" \"underline\"',
      'size' => 'Size in pixels, or rems or in percentage',
      'font_family' => 'Font Family',
      'align' => 'Defines the text align (left, center, right)',
      'letter_spacing' => 'Letter Spacing',
      'color' => 'Color',
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
    return $this->hasMany(Section::class, ['text_id' => 'id']);
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
    $textSource = new TextSource();

    $generated = [];

    foreach ($attributes as $key => $value) {
      $generated[$value] = "";
    }

    $generated['textSource'] = $textSource->generateSchema();

    return $generated;
  }
}
