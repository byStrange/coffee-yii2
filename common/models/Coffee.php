<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "coffee".
 *
 * @property int $id
 * @property int $price
 * @property int $text_source_id Translated title for Coffee
 * @property int $category_id
 * @property int|null $description_text_source_id Translated description
 * @property int $type Can be "normal" "premium"
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CoffeeCategory $category
 * @property TextSource $descriptionTextSource
 * @property TextSource $textSource
 */
class Coffee extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'coffee';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['price', 'text_source_id', 'category_id', 'type'], 'required'],
      [['price', 'text_source_id', 'category_id', 'description_text_source_id', 'type'], 'default', 'value' => null],
      [['price', 'text_source_id', 'category_id', 'description_text_source_id', 'type'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoffeeCategory::class, 'targetAttribute' => ['category_id' => 'id']],
      [['text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['text_source_id' => 'id']],
      [['description_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['description_text_source_id' => 'id']],
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
      'price' => 'Price',
      'text_source_id' => 'Translated title for Coffee',
      'category_id' => 'Category ID',
      'description_text_source_id' => 'Translated description',
      'type' => 'Can be \"normal\" \"premium\"',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Category]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(CoffeeCategory::class, ['id' => 'category_id']);
  }

  /**
   * Gets query for [[DescriptionTextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getDescriptionTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'description_text_source_id']);
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
