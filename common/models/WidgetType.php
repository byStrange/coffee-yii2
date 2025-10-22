<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "widget_type".
 *
 * @property int $id
 * @property string $type
 * @property int|null $label_text_source_id
 * @property int|null $icon_source_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property IconSource $iconSource
 * @property TextSource $labelTextSource
 * @property Widget[] $widgets
 */
class WidgetType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['label_text_source_id', 'icon_source_id'], 'default', 'value' => null],
            [['label_text_source_id', 'icon_source_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['label_text_source_id'], 'unique'],
            [['icon_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => IconSource::class, 'targetAttribute' => ['icon_source_id' => 'id']],
            [['label_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['label_text_source_id' => 'id']],
        ];
    }

    public function behaviors() {
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
            'type' => 'Type',
            'label_text_source_id' => 'Label Text Source ID',
            'icon_source_id' => 'Icon Source ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[IconSource]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIconSource()
    {
        return $this->hasOne(IconSource::class, ['id' => 'icon_source_id']);
    }

    /**
     * Gets query for [[LabelTextSource]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLabelTextSource()
    {
        return $this->hasOne(TextSource::class, ['id' => 'label_text_source_id']);
    }

    /**
     * Gets query for [[Widgets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWidgets()
    {
        return $this->hasMany(Widget::class, ['widget_type_id' => 'id']);
    }
}
