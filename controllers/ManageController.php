<?php

namespace krok\imperavi\controllers;

use krok\cp\components\Controller;

class ManageController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'FileUpload' => 'krok\imperavi\actions\FileUploadAction',
            'FileList' => 'krok\imperavi\actions\FileListAction',
            'ImageUpload' => 'krok\imperavi\actions\ImageUploadAction',
            'ImageList' => 'krok\imperavi\actions\ImageListAction',
            'PageList' => 'krok\imperavi\actions\PageListAction',
        ];
    }
}
