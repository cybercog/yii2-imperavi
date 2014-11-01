<?php

namespace krok\imperavi\actions;

use krok\language\models\Language;
use krok\page\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii;

class PageListAction extends \yii\base\Action
{
    /**
     * @return string
     */
    public function run()
    {
        return Json::encode(
            ArrayHelper::merge(
                [
                    [
                        'name' => yii::t('imperavi', 'Link to the page'),
                        'url' => '#',
                    ],
                ],
                ArrayHelper::getColumn(
                    Page::find()->where(['language' => Language::getCurrent()])->asArray()->all(),
                    function ($row) {
                        return [
                            'name' => $row['title'],
                            'url' => yii::$app->getUrlManager()->createUrl(['/index/' . $row['name']]),
                        ];
                    }
                )
            )
        );
    }
}
