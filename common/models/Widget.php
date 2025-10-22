<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "widget".
 *
 * @property int $id
 * @property string|null $style
 * @property int $widget_type_id
 * @property string|null $class
 * @property bool|null $hidden
 * @property string|null $background
 * @property int $order
 * @property int|null $parent_widget_id
 * @property int|null $section_id
 * @property string|null $margin
 * @property string|null $padding
 * @property bool|null $center
 * @property string|null $html_id
 * @property string|null $radius
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ActiveDataList $activeDataList
 * @property Button $button
 * @property ComponentWidget $componentWidget
 * @property Container[] $containers
 * @property Icon[] $icons
 * @property Image $image
 * @property Link[] $links
 * @property Widget $parentWidget
 * @property Text $text
 * @property View $view
 * @property WidgetType $widgetType
 * @property Widget[] $widgets
 */
class Widget extends \yii\db\ActiveRecord
{
  public $children = [];
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'widget';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['created_at', 'updated_at'], 'safe'],
      [['style'], 'string'],
      [['widget_type_id', 'order'], 'required'],
      [['order'], 'default', 'value' => 1],
      [['widget_type_id', 'class', 'parent_widget_id', 'section_id'], 'default', 'value' => null],
      [['widget_type_id', 'order', 'parent_widget_id', 'section_id'], 'integer'],
      [['hidden', 'center'], 'boolean'],
      [['background', 'margin', 'padding', 'class'], 'string', 'max' => 255],
      [['parent_widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => Widget::class, 'targetAttribute' => ['parent_widget_id' => 'id']],
      [['widget_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => WidgetType::class, 'targetAttribute' => ['widget_type_id' => 'id']],
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
      'style' => 'Style',
      'widget_type_id' => 'Widget Type ID',
      'class' => 'Class',
      'hidden' => 'Hidden',
      'background' => 'Background',
      'order' => 'Order',
      'parent_widget_id' => 'Parent Widget ID',
      'section_id' => 'Section ID',
      'margin' => 'Margin',
      'padding' => 'Padding',
      'center' => 'Center',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[ActiveDataList]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getActiveDataList()
  {
    return $this->hasOne(ActiveDataList::class, ['widget_id' => 'id']);
  }

  public function getInput()
  {
    return $this->hasOne(Input::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[Button]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getButton()
  {
    return $this->hasOne(Button::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[ComponentWidget]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComponentWidget()
  {
    return $this->hasOne(ComponentWidget::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[Containers]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getContainers()
  {
    return $this->hasMany(Container::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[Icons]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getIcon()
  {
    return $this->hasOne(Icon::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[Image]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getImage()
  {
    return $this->hasOne(Image::class, ['widget_id' => 'id']);
  }

  public function getComponent()
  {
    return $this->hasOne(Component::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[Links]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getLinks()
  {
    return $this->hasMany(Link::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[ParentWidget]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getParentWidget()
  {
    return $this->hasOne(Widget::class, ['id' => 'parent_widget_id']);
  }

  /**
   * Gets query for [[Text]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getText()
  {
    return $this->hasOne(Text::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[View]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getView()
  {
    return $this->hasOne(View::class, ['widget_id' => 'id']);
  }

  /**
   * Gets query for [[WidgetType]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getWidgetType()
  {
    return $this->hasOne(WidgetType::class, ['id' => 'widget_type_id']);
  }

  /**
   * Gets query for [[Widgets]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getWidgets()
  {
    return $this->hasMany(Widget::class, ['parent_widget_id' => 'id']);
  }

  public function schemaGenerate($self, $type, $class, $widgetType)
  {
    $schemaclass = new $class();
    $schema = $schemaclass->generateSchema();
    $widgetSchema = $self->generateSchema();
    $widgetSchema[$type] = $schema;
    $widgetSchema['widgetType'] = $widgetType;
    $widgetSchema['children'] = [];
    return $widgetSchema;
  }

  public function generateSchemaFor($type, $widgetType)
  {
    if (!$widgetType) {
      return ['error' => 'Request widget type not found'];
    }



    $widgetSchema = null;
    switch ($type) {
      case 'text':
        $widgetSchema = $this->schemaGenerate($this, $type, Text::class, $widgetType);
        break;
      case 'image':
        $widgetSchema = $this->schemaGenerate($this, $type, Image::class, $widgetType);
        break;
      case 'icon':
        $widgetSchema = $this->schemaGenerate($this, $type, Icon::class, $widgetType);
        break;
      case 'input':
        $widgetSchema = $this->schemaGenerate($this, $type, Input::class, $widgetType);
        break;
      case 'link':
        $widgetSchema = $this->schemaGenerate($this, $type, Link::class, $widgetType);
        break;
      case 'container':
        $widgetSchema = $this->schemaGenerate($this, $type, Container::class, $widgetType);
        break;
      case 'component_widget':
        $widgetSchema = $this->schemaGenerate($this, $type, ComponentWidget::class, $widgetType);
        break;
      case 'component':
        $widgetSchema = $this->schemaGenerate($this, $type, Component::class, $widgetType);
        break;
      case 'action_data_list':
        $widgetSchema = $this->schemaGenerate($this, $type, DataProvider::class, $widgetType);
        break;
      case 'button':
        $widgetSchema = $this->schemaGenerate($this, $type, Button::class, $widgetType);
        break;

      case 'view':
        $widgetSchema = $this->schemaGenerate($this, $type, View::class, $widgetType);
        break;
    }
    if (!$widgetSchema) {
      var_dump($type);
    }
    return $widgetSchema;
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
