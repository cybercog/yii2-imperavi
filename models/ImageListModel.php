<?php

namespace krok\imperavi\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

class ImageListModel extends \yii\base\Model
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
        foreach (FileHelper::findFiles(
                     $this->getPath(),
                     ['only' => ['*.jpg', '*.jpe', '*.jpeg', '*.png', '*.gif', '*.bmp']]
                 ) as $this->_file) {
            $toJson = ArrayHelper::merge(
                $toJson,
                [
                    [
                        'thumb' => $this->getUrl(),
                        'image' => $this->getUrl(),
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
}
