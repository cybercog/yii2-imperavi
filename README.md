Yii2 Imperavi redactor
=================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist krok/yii2-imperavi "*"
```

or add

```
"krok/yii2-imperavi": "*"
```

to the require section of your `composer.json` file.

Configure
-----------------

Add to config file (config/web.php or common\config\main.php)

```
'bootstrap' => [
    'imperavi',
],
```

upload directory `@webroot/uploads`

```
'modules' => [
    'class' => 'krok\imperavi\Imperavi',
],
```

register modules for Cp modules ( @vendor\krok\cp\Cp.php )

```
public function registerModules()
{
    $this->modules = [
        'imperavi' => [
            'class' => 'krok\imperavi\Manage',
        ],
    ];
}
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```
<?=$form->field($model, 'body')->widget(\krok\imperavi\widgets\ImperaviWidget::className())?>
```

or not use ActiveField

```
<?=
    krok\imperavi\widgets\ImperaviWidget::widget([
        'model' => $model,
        'attribute' => 'body'
    ])
?>
```

or config advanced redactor reference [Docs](http://imperavi.com/redactor/docs/)

```
<?=
    $form->field($model, 'body')->widget(
        krok\imperavi\widgets\ImperaviWidget::className(),
        [
            'clientOptions' => [
                'buttonSource' => true,
                'fileUpload' => yii::$app->getUrlManager()->createUrl(['/cp/imperavi/manage/FileUpload']),
                'fileManagerJson' => yii::$app->getUrlManager()->createUrl(['/cp/imperavi/manage/FileList']),
                'imageUpload' => yii::$app->getUrlManager()->createUrl(['/cp/imperavi/manage/ImageUpload']),
                'imageManagerJson' => yii::$app->getUrlManager()->createUrl(['/cp/imperavi/manage/ImageList']),
                'definedLinks' => yii::$app->getUrlManager()->createUrl(['/cp/imperavi/manage/PageList']),
                'plugins' => [
                    'filemanager',
                    'imagemanager',
                    'definedlinks',
                    'fontfamily',
                    'fontcolor',
                    'fontsize',
                    'table',
                    'video',
                ],
            ],
        ]
    )
?>
```