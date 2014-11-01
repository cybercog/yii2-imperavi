<?php

namespace krok\imperavi\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

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
        return basename($this->_file);
    }

    /**
     * @return string
     */
    protected function getSize()
    {
        $size = filesize($this->_file);
        $range = ['B', 'K', 'M', 'G', 'T', 'P'];
        $factor = floor((strlen($size) - 1) / 3);
        $suffix = isset($range[$factor]) ? $range[$factor] : '?';
        return sprintf("%.1f", $size / pow(1024, $factor)) . ' ' . $suffix;
    }
}
