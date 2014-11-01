<?php

namespace krok\imperavi\models;

class ImageUploadModel extends FileUploadModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['uploadDir', 'required'],
            ['file', 'file', 'extensions' => 'jpg,jpe,jpeg,png,gif,bmp'],
        ];
    }
}
