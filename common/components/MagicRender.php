<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\Html;

class MagicRender extends Component
{
  static $components = [];


  public static function renderAttributes($widget)
  {
    $attributes = [];

    if ($widget->class) {
      $attributes['class'] = $widget->class;
    }

    if ($widget->style) {
      $attributes['style'] = $widget->style;
    }

    if ($widget->center) {
      $attributes['class'] .= ' widget__style-center';
    }

    if ($widget->background) $attributes['style'] .= "background: $widget->background;";

    if ($widget->margin) $attributes['style'] .= "margin: $widget->margin;";

    if ($widget->padding) $attributes['style'] .= "padding: $widget->padding;";

    if ($widget->hidden) $attributes['style'] .= "display: none;";


    $toString = function () use (&$attributes) {
      $attributesString = '';
      foreach ($attributes as $key => $value) {
        $attributesString .= "$key=\"$value\" ";
        /*echo $attributesString;*/
      }
      return rtrim($attributesString);
    };

    $addExtra = function ($key, $value, $seperator = " ") use (&$attributes, $toString) {
      if (isset($attributes[$key])) $attributes[$key] .= $seperator . $value;
      else $attributes[$key] = $value;
      return $toString();
    };

    $asArray = function () use ($attributes) {
      return $attributes;
    };

    return [
      'addExtra' => $addExtra,
      'toString' => $toString,
      'asArray' => $asArray,
    ];
  }


  public static function buildWidgetTree(&$widgets)
  {

    function build($widgets, $parentId = null)
    {
      $tree = [];

      foreach ($widgets as $widget) {
        // Recursively find children for this widget
        if ($widget['parent_widget_id'] === $parentId) {
          $children = build($widgets, $widget['id']);
          if ($children) {
            usort($children, function ($a, $b) {
              return $a->order <=> $b->order;
            });
            $widget['children'] = $children;
          }

          // Add this widget to the tree
          if ($widget->widgetType->type == 'component') {
            MagicRender::$components[] = $widget;
          } else $tree[] = $widget;
        }
      }

      usort($tree, function ($a, $b) {
        return $a->order <=> $b->order;
      });

      return $tree;
    }

    $widgetTree = build($widgets);
    foreach ($widgetTree as $key => $value) {
      # code...
      /*self::printAsError(count($value->children), false);*/
    }
    return $widgetTree;
  }

  public static function printAsError($text, $die = true)
  {
    echo "<pre>";
    echo var_dump($text);
    echo "</pre>";
    if ($die) die;
  }


  public static function renderWidget($widget)
  {
    $widgetType = htmlspecialchars($widget->widgetType->type); // Get the type of the widget

    $attributeManager = self::renderAttributes($widget);

    $renderInside =  function () use ($widget) {
      if (isset($widget->children) && count($widget->children) > 0) {
        self::displayWidgetTree($widget->children); // Recursively render children without <ul>/<li>
      }
    };

    switch ($widgetType) {
      case 'view':
        $attributeManager['addExtra']('class', 'widget-view');
        $attr = $attributeManager['toString']();
        echo "<div $attr>";

        // If there are children, render them inside the view
        $renderInside();

        echo "</div>";
        break;

      case 'button':
        $attributeManager['addExtra']('class', 'widget-button');
        $attr = $attributeManager['toString']();
        echo "<button $attr>";

        $renderInside();

        echo "</button>";
        break;

      case 'image':
        $attributeManager['addExtra']('alt', $widget->image->alt);
        $attributeManager['addExtra']('class', ' widget-image');

        if ($widget->image->width) $attributeManager['addExtra']('width', $widget->image->width);
        if ($widget->image->height) $attributeManager['addExtra']('height', $widget->image->height);

        $attributeManager['addExtra']('src', $widget->image->src);
        $attr = $attributeManager['toString']();

        echo "<img $attr />";
        break;

      case 'icon':
        $attributeManager['addExtra']('class', 'widget-icon');
        $iconType = $widget->icon->iconSource->type;
        $iconSize = $widget->icon->size;
        $icon = $widget->icon->iconSource->data;
        switch ($iconType) {
          case 'svg':
            break;
          case 'boxicon':
            $attributeManager['addExtra']('class', $icon);
            $attributeManager['addExtra']('style', "font-size: $iconSize;");
            $attr = $attributeManager['toString']();
            $icon = "<i $attr></i>";
            break;
          case 'image':
            // $widget->size example 
            //   '400x300';
            $sizes = explode('x', $widget->icon->size);
            $width = $sizes[0];
            $height = $sizes[1];
            $attributeManager['addExtra']('width', $width);
            $attributeManager['addExtra']('height', $height);
            $attributeManager['addExtra']('src', $icon);
            $attr = $attributeManager['toString']();

            $icon = "<img $attr>";
            break;
        }
        echo $icon;
        break;

      case 'text':
        $attributeManager['addExtra']('class', 'widget-text');

        $textTag = $widget->text->type;
        $fontSize = $widget->text->size;
        $fontFamily = $widget->text->font_family;
        $textAlign = $widget->text->align;
        $letterSpacing = $widget->text->letter_spacing;
        $color = $widget->text->color;
        $styles = $widget->text->styles ? explode(',', $widget->text->styles) : [];


        if ($fontSize) $attributeManager['addExtra']('style', "font-size: $fontSize;");
        if ($fontFamily) $attributeManager['addExtra']('style', "font-family: $fontFamily;");
        if ($textAlign) $attributeManager['addExtra']('style', "text-align: $textAlign;");
        if ($letterSpacing) $attributeManager['addExtra']('style', "letter-spacing: $letterSpacing;");
        if ($color) $attributeManager['addExtra']('style', "color: $color;");

        if (in_array('underline', $styles)) $attributeManager['addExtra']('style', "text-decoration: underline;");
        if (in_array('bold', $styles)) $attributeManager['addExtra']('style', "font-weight: bold;");
        if (in_array('italic', $styles)) $attributeManager['addExtra']('style', "font-style: italic;");


        $attr = $attributeManager['toString']();
        echo "<$textTag $attr>";


        echo htmlspecialchars($widget->text->textSource->getTranslatedTextForLanguage());


        echo "</$textTag>";
        break;

      case 'link':
        $attributeManager['addExtra']('class', 'widget-link');
        $attributeManager['addExtra']('href', $widget->link->url);
        $attributeManager['addExtra']('target', $widget->link->open_in_new_tab ? '_blank' : '_self');

        $attr = $attributeManager['toString']();
        echo "<a $attr>";
        $renderInside();
        echo "</a>";
        break;

      case 'input':
        $attributeManager['addExtra']('class', 'widget-input');
        $attributeManager['addExtra']('name', $widget->input->name);
        $attributeManager['addExtra']('placeholder', $widget->input->placeholderTextSource->getTranslatedTextForLanguage());

        $attr = $attributeManager['toString']();

        echo "<input $attr />";

        break;


      case 'component_widget':
        $attributeManager['addExtra']('class', 'widget-component');
        $attr = $attributeManager['toString']();
        echo "<div $attr>";

        // Fetch the associated component widget from MagicRender::$components
        foreach (MagicRender::$components as $component) {
          if ($component->id === $widget->componentWidget->component->widget->id) {
            // Recursively render the component widget found in MagicRender::$components
            self::renderWidget($component);
            break;
          }
        }

        echo "</div>";
        break;

      case 'component':
        $attributeManager['addExtra']('class', 'component');
        $attributeManager['addExtra']('data-component-name', $widget->component->name);
        $attr = $attributeManager['toString']();

        echo "<div $attr>";
        $renderInside();
        echo "</div>";
        break;



      default:
        // Default rendering if the widget type is unrecognized
        echo  "<div class='somethingunusual'>";
        $renderInside();
        echo "</div>";
        break;
    }
  }

  // Recursive function to display the widget tree
  public static function displayWidgetTree($widgetTree)
  {
    foreach ($widgetTree as $widget) {
      // Call the custom renderWidget method to display each widget
      self::renderWidget($widget);
    }
  }
}
