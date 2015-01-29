<?php

namespace krok\imperavi\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class FileListModel extends \yii\base\Model
{
    /**
     * @var null
     */
    public $uploadDir = null;

    /**
     * @var null
     */
    private $_file = null;

    /**
     * @return string
     */
    public function toJson()
    {
        $toJson = [];
        foreach (FileHelper::findFiles($this->getPath()) as $this->_file) {
            $toJson = ArrayHelper::merge(
                $toJson,
                [
                    [
                        'title' => $this->normalizeFilename(),
                        'name' => FileHelper::getMimeType($this->_file),
                        'link' => $this->getUrl(),
                        'size' => $this->getSize(),
                    ],
                ]
            );
        }
        return Json::encode($toJson);
    }

    /**
     * @return bool|string
     */
    protected function getPath()
    {
        return Yii::getAlias($this->uploadDir);
    }

    /**
     * @return mixed
     */
    protected function getUrl()
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', str_replace(Yii::getAlias('@webroot'), '', $this->_file));
    }

    /**
     * @return string
     */
    protected function normalizeFilename()
    {
        return StringHelper::basename($this->_file);
    }

    /**
     * @return string
     */
    protected function getSize()
    {
        return Yii::$app->formatter->asSize(filesize($this->_file), 2);
    }
}
