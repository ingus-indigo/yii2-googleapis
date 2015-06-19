<?php
namespace omni\googleapis\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
    * @var omni\googleapis\Module
    */
    public $module;

    public function actionCallback()
    {
        $google = yii::$app->getModule('googleapis');

        $google->checkAccessToken($google->SCOPE['youtube']);
        return $this->render('callback');
    }

}
