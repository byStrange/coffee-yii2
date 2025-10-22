<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "text_source".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $text
 *
 * @property Coffee[] $coffees
 * @property Coffee[] $coffees0
 * @property Input $input
 * @property TextTranslation[] $textTranslations
 * @property Text[] $texts
 */
class TextSource extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'text_source';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text'], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['text'], 'string'],
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
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
      'text' => 'Text',
    ];
  }

  /**
   * Gets query for [[Coffees]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoffees()
  {
    return $this->hasMany(Coffee::class, ['text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Coffees0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoffees0()
  {
    return $this->hasMany(Coffee::class, ['description_text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Input]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getInput()
  {
    return $this->hasOne(Input::class, ['placeholder_text_source_id' => 'id']);
  }

  /**
   * Gets query for [[TextTranslations]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTextTranslations()
  {
    return $this->hasMany(TextTranslation::class, ['text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Texts]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTexts()
  {
    return $this->hasMany(Text::class, ['text_source_id' => 'id']);
  }

  public function getTranslatedTextForLanguage($lang = null)
  {
    if ($lang == null) $lang = Yii::$app->language;
    $translation = $this->getTextTranslations()->andWhere(['language_code' => $lang])->one();
    if ($translation) return $translation->translation;

    return $this->text;
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
