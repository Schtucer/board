<?php

namespace app\controllers;

class ProductController extends AppController {
    
    public function actionIndex() {
        return $this->render('index');
    }
}