<?php

namespace app\modules\admin;
use yii\filters\AccessControl;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],                    
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action))
        {
            return false;
        }

        if (\Yii::$app->user->identity['username'] == 'admin' && \Yii::$app->user->identity['id'] == 1)
        {
            return true;
        }
        else
        {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }
}
