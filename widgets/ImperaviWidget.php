<?php

namespace krok\imperavi\widgets;

use Yii;
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
     * @var ImperaviWidgetAsset
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
        $this->registerCsrf();
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

    public function registerCsrf()
    {
        $this->clientOptions['uploadImageFields'][Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        $this->clientOptions['uploadFileFields'][Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
    }

    public function registerPlugins()
    {
        $plugins = ArrayHelper::getValue($this->clientOptions, 'plugins', []);
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $js = 'plugins' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $plugin . '.js';
                if (file_exists($this->_assetBundle->basePath . DIRECTORY_SEPARATOR . $js)) {
                    $this->_assetBundle->js[] = $js;
                }
                $css = 'plugins' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $plugin . '.css';
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

        $js = 'lang' . DIRECTORY_SEPARATOR . $language . '.js';

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
        return __DIR__ . DIRECTORY_SEPARATOR . 'assets';
    }

    /**
     * @return array
     */
    public function getAssetsUrl()
    {
        return Yii::$app->getAssetManager()->publish($this->getAssetsPath());
    }
}
