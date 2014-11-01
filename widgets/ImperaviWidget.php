<?php

namespace krok\imperavi\widgets;

use yii;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use krok\language\models\Language;

class ImperaviWidget extends \yii\widgets\InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var null
     */
    public $selector = null;

    /**
     * @var null
     */
    private $_assetBundle = null;

    public function init()
    {
        parent::init();

        if ($this->selector === null) {
            $this->selector = $this->options['id'];
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerAsset();
        $this->registerPlugins();
        $this->registerLanguage();
        $this->registerClientScript();

        if ($this->hasModel()) {
            return Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            return Html::textArea($this->name, $this->value, $this->options);
        }
    }

    public function registerAsset()
    {
        $this->_assetBundle = ImperaviWidgetAsset::register($this->getView());
        list($this->_assetBundle->basePath, $this->_assetBundle->baseUrl) = $this->getAssetsUrl();
    }

    public function registerPlugins()
    {
        $plugins = ArrayHelper::getValue($this->clientOptions, 'plugins', []);
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $js = 'plugins/' . $plugin . '/' . $plugin . '.js';
                if (file_exists($this->_assetBundle->basePath . DIRECTORY_SEPARATOR . $js)) {
                    $this->_assetBundle->js[] = $js;
                }
                $css = 'plugins/' . $plugin . '/' . $plugin . '.css';
                if (file_exists($this->_assetBundle->basePath . DIRECTORY_SEPARATOR . $css)) {
                    $this->_assetBundle->css[] = $css;
                }
            }
        }
    }

    public function registerLanguage()
    {
        $language = ArrayHelper::getValue($this->clientOptions, 'lang');

        if ($language === null) {
            $language = Language::getCurrentCode();
            $this->clientOptions = ArrayHelper::merge(
                $this->clientOptions,
                [
                    'lang' => $language,
                ]
            );
        }

        $js = 'lang/' . $language . '.js';

        if (file_exists($this->_assetBundle->basePath . DIRECTORY_SEPARATOR . $js)) {
            $this->_assetBundle->js[] = $js;
        } else {
            ArrayHelper::remove($this->clientOptions, 'lang');
        }
    }

    public function registerClientScript()
    {
        $this->getView()->registerJs(
            'jQuery("#' . $this->selector . '").redactor(' . Json::encode($this->clientOptions) . ');'
        );
    }

    /**
     * @return string
     */
    public function getAssetsPath()
    {
        return __DIR__ . '/assets';
    }

    /**
     * @return array
     */
    public function getAssetsUrl()
    {
        return yii::$app->getAssetManager()->publish($this->getAssetsPath());
    }
}
