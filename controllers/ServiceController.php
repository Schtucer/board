<?php

namespace app\controllers;

class ServiceController extends AppController {
    
    public function actionIndex() {
        return $this->render('index');
    }
}