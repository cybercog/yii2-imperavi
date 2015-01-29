<?php

namespace krok\imperavi\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;
use yii\helpers\Json;

class FileUploadModel extends \yii\base\Model
{
    /**
     * @var UploadedFile
     */
    public $file = null;

    /**
     * @var null
     */
    public $uploadDir = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['uploadDir', 'required'],
            ['file', 'file'],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            return $this->file->saveAs($this->getPath(), true);
        }
        return false;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return Json::encode(['filelink' => $this->getUrl(), 'filename' => $this->normalizeFilename()]);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $path = Yii::getAlias($this->uploadDir);
        FileHelper::createDirectory($path);
        return $path . DIRECTORY_SEPARATOR . $this->normalizeFilename();
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', str_replace(Yii::getAlias('@webroot'), '', $this->getPath()));
    }

    /**
     * @return string
     */
    protected function normalizeFilename()
    {
        return StringHelper::basename($this->_file);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName('file');
            return true;
        }
        return false;
    }
}
