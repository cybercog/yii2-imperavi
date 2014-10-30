<?php

namespace krok\imperavi\widgets;

class ImperaviWidgetAsset extends \yii\web\AssetBundle
{
    /**
     * @var array
     */
    public $js = [
        'redactor.min.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'redactor.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
