<?php

namespace backend\controllers;

use common\components\MagicRender;
use common\models\LoginForm;
use common\models\User;
use common\models\Widget;
use common\models\WidgetType;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
  public $enableCsrfVerification = false;
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'actions' => ['login', 'error', 'what', 'serve', 'schema', 'schemas'],
            'allow' => true,
          ],
          [
            'actions' => ['logout', 'index'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => \yii\web\ErrorAction::class,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionSchema($type)
  {
    $this->response->format = Response::FORMAT_JSON;
    $schema = new Widget();
    $widgetType = WidgetType::find()
      ->with(['labelTextSource', 'labelTextSource.texts', 'iconSource'])
      ->where(['type' => $type])
      ->asArray()
      ->one();
    $schema = $schema->generateSchemaFor($type, $widgetType);

    return  $schema;
  }

  public function actionSchemas()
  {
    $this->response->format = Response::FORMAT_JSON;
    $widget = new Widget();
    $widgetTypes = WidgetType::find()
      ->with(['labelTextSource', 'labelTextSource.texts', 'iconSource'])
      ->asArray()
      ->all();

    $schemas = [];
    foreach ($widgetTypes as $widgetType) {
      $schemas[] = $widget->generateSchemaFor($widgetType['type'], $widgetType);
    }

    return $schemas;
  }

  public function actionServe()
  {
    $this->response->format = Response::FORMAT_JSON;
    $widgets = Widget::find()
      ->joinWith(['widgetType'])
      ->with([
        'widgetType',
        'view',
        'text',
        'text.textSource',
        'links',
        'image',
        'icon',
        'icon.iconSource',
        'containers',
        'component',
        'componentWidget',
        /*'input',*/
        /*'input.placeholderTextSource',*/
        'componentWidget.component',
        'button',
        'activeDataList'
      ])
      ->orderBy([
        new \yii\db\Expression("CASE WHEN widget_type.type = 'component' THEN 0 ELSE 1 END"),
        'widget.id' => SORT_ASC
      ])
      ->asArray()
      ->all();
    return $widgets;
  }

  public function actionWhat()
  {
    $widgets = Widget::find()
      ->with(
        [
          'widgetType',
          'view',
          'text',
          'text.textSource',
          'links',
          'image',
          'icon',
          'icon.iconSource',
          'containers',
          'component',
          'componentWidget',
          'input',
          'input.placeholderTextSource',
          'button',
          'activeDataList'
        ]
      )
      ->all();
    $tree = MagicRender::buildWidgetTree($widgets);
    return $this->render('blank', ['tree' => $tree]);
  }

  /**
   * Login action.
   *
   * @return string|Response
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $this->layout = 'blank';

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = '';

    return $this->render('login', [
      'model' => $model,
    ]);
  }

  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }
}
