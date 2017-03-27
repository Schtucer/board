<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\ltAppAsset;

AppAsset::register($this);
ltAppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Админка | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta charset="utf-8">
    <link rel="icon" href="/images/favicon.ico">
    <link rel="shortcut icon" href="/images/favicon.ico">

</head>
<body class="page1">
    <?php $this->beginBody() ?>
<header>
  <div class="container_12">
    <div class="grid_12">
      <div class="h_phone">Need Help? Call Us +1 (800) 123 4567</div>
      <h1><a href="<?= Url::home() ?>"><img src="/images/logo.png" alt=""></a></h1>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="menu_block">
    <div class="container_12">
      <div class="grid_12">        
        <?php if(!\Yii::$app->user->isGuest): ?>
            <?php if(\Yii::$app->user->identity['username'] == 'admin' && \Yii::$app->user->identity['id'] == 1): ?>
                <div class="autor"> <a href="<?= Url::to(['/profile/view', 'id' => \Yii::$app->user->identity['id']]) ?>"><?= '(' . \Yii::$app->user->identity['username'] . ')'?></a><a href="<?= Url::to(['/site/logout']) ?>">Выход</a></div>
            <?php else: ?>
                <div class="autor"> <a href="<?= Url::to(['/profile/view', 'id' => \Yii::$app->user->identity['id']]) ?>"><?= '(' . \Yii::$app->user->identity['username'] . ')'?><a href="<?= Url::to(['/site/logout']) ?>">Выход</a></div>
            <?php endif ?>
        <?php else: ?>
        <div class="autor"><a href="<?= Url::to(['/site/login']) ?>">Вход</a></div>        
        <?php endif; ?>
        <nav class="">
          <ul class="sf-menu">
            <li class="current"><a href="<?= Url::home() ?>">Главная</a></li>
            <?php if(!\Yii::$app->user->isGuest): ?>
            <?php if(\Yii::$app->user->identity['username'] == 'admin' && \Yii::$app->user->identity['id'] == 1): ?>            
            <li><a href="<?= Url::to(['/profile/index']) ?>">Пользователи</a>
            <li><a href="<?= Url::to(['/admin/post/index']) ?>">Объявления ˇ</a>
              <ul>
                <li><a href="<?= Url::to('/admin/post/index') ?>">Просмотр всех</a></li>
                <li><a href="<?= Url::to('/admin/post/create') ?>">Создать новое</a></li>
              </ul>
            </li>
            <li><a href="<?= Url::to(['/admin/category/index']) ?>">Категории ˇ</a>
              <ul>
                <li><a href="<?= Url::to('/admin/category/index') ?>">Просмотр всех</a></li>
                <li><a href="<?= Url::to('/admin/category/create') ?>">Создать новую</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php endif; ?>
          </ul>
        </nav>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</header>
    
<div class="container">    
    <?= $content ?>
</div>
    
<footer>
  <div class="container_12">
    <div class="grid_2">
      <div class="copy"> <a href="index.html" class="footer_logo"><img src="/images/footer_logo.png"	alt=""></a> &copy; 2045 <a href="#">Privacy Policy</a> </div>
    </div>   
  </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>