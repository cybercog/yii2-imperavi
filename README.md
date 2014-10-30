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
'modules' => [
    'redactor' => 'yii\imperavi\Imperavi',
],
```

or if you want to change the upload directory.
to path/to/uploadfolder
default value `@webroot/uploads`

```
'modules' => [
    'redactor' => [
        'class'=>'yii\imperavi\Imperavi',
        'uploadDir'=>'@webroot/path/to/uploadfolder'
    ],
],
```


Usage
-----

Once the extension is installed, simply use it in your code by  :

```
<?=$form->field($model, 'body')->widget(\yii\imperavi\widgets\ImperaviWidget::className())?>
```

or not use ActiveField

```
<?=
    \yii\imperavi\widgets\ImperaviWidget::widget([
        'model' => $model,
        'attribute'=>'body'
    ])
?>
```

or config advanced redactor reference [Docs](http://imperavi.com/redactor/docs/)

```
<?=
    $form->field($model, 'body')->widget(\yii\imperavi\widgets\ImperaviWidget::className(),[
            'clientOptions' => [
                'plugins' => [
                    'fontfamily',
                    'fontsize',
                    'fontcolor',
                    'fullscreen',
                    'table',
                    'video',
                    /**
                     * exception
                     */
                    //'limiter', /* http://imperavi.com/redactor/plugins/limiter/ */
                    //'counter', /* http://imperavi.com/redactor/plugins/counter/ */
                ],
            ],
    ])
?>
```