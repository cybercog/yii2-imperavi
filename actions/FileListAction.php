<?php

namespace krok\imperavi\actions;

use krok\imperavi\models\FileListModel;

class FileListAction extends \yii\base\Action
{
    /**
     * @return string
     */
    function run()
    {
        return (new FileListModel(['uploadDir' => $this->controller->module->uploadDir]))->toJson();
    }
}
