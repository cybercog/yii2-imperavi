<?php

namespace krok\imperavi;

use krok\language\models\Language;

class Manage extends \yii\base\Module
{
    /**
     * @var string
     */
    public $defaultRoute = 'manage';

    /**
     * @var string
     */
    public $controllerNamespace = 'krok\imperavi\controllers';

    /**
     * @var string
     */
    public $uploadDir = '@webroot/uploads';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->registerUploadDir();
    }

    public function registerUploadDir()
    {
        $this->uploadDir .= DIRECTORY_SEPARATOR . Language::getCurrent();
    }
}
