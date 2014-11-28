<?php

namespace krok\imperavi\actions;

use krok\language\models\Language;
use krok\page\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;

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
                        'name' => Yii::t('imperavi', 'Link to the page'),
                        'url' => '#',
                    ],
                ],
                ArrayHelper::getColumn(
                    Page::find()->where(['language' => Language::getCurrent()])->asArray()->all(),
                    function ($row) {
                        return [
                            'name' => $row['title'],
                            'url' => Yii::$app->getUrlManager()->createUrl($row['name']),
                        ];
                    }
                )
            )
        );
    }
}
