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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta charset="utf-8">
    <link rel="icon" href="/images/favicon.ico">
    <link rel="shortcut icon" href="/images/favicon.ico">

    <?php //$this->registerJsFile('js/slider.js', ['position' => \yii\web\View::POS_HEAD]) ?>
    <?php //$this->registerJsFile('js/carousel1.js', ['position' => \yii\web\View::POS_HEAD]) ?>

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
        <div class="socials"><a href="#"></a><a href="#"></a></div>
        <?php if(!\Yii::$app->user->isGuest): ?>
            <?php if(\Yii::$app->user->identity['username'] == 'admin'): ?>
                <div class="autor"> <a href="<?= Url::to(['/admin/post/index']) ?>"><?= '(' . \Yii::$app->user->identity['username'] . ')'?></a><a href="<?= Url::to(['/site/logout']) ?>">Выход</a> Social </div>
            <?php else: ?>
                <div class="autor"> <?= '(' . \Yii::$app->user->identity['username'] . ') | '?><a href="<?= Url::to(['/site/logout']) ?>">Выход</a> Social </div>
            <?php endif ?>
        <?php else: ?>
        <div class="autor"><a href="<?= Url::to(['/site/login']) ?>">Вход</a> Social </div>      
        <div class="autor"><a href="<?= Url::to(['/site/registration']) ?>">Регистрация</a></div>      
        <?php endif; ?>
        <nav class="">
          <ul class="sf-menu">
            <li class="current"><a href="<?= Url::home() ?>">Главная</a></li>
            <li class="with_ul"><a href="<?= Url::to(['about/']) ?>">О нас</a></li>
            <li><a href="<?= Url::to(['service/']) ?>">Услуги</a>
              <ul>
                <li><a href="#"> Services List</a>
                  <ul>
                    <li><a href="#">Seeds</a></li>
                    <li><a href="#">Traits</a></li>
                    <li><a href="#">Safety Control</a></li>
                  </ul>
                </li>
                <li><a href="#">Overview</a></li>
                <li><a href="#">FAQS</a></li>
              </ul>
            </li>
            <li><a href="<?= Url::to(['product/']) ?>">Продукты</a></li>
            <li><a href="<?= Url::to(['blog/']) ?>">Блог</a></li>
            <li><a href="<?= Url::to(['contact/']) ?>">Контакты</a></li>
          </ul>
        </nav>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</header>    
<?= $content ?>
<footer>
  <div class="container_12">
    <div class="grid_2">
      <div class="copy"> <a href="index.html" class="footer_logo"><img src="/images/footer_logo.png"	alt=""></a> &copy; 2045 <a href="#">Privacy Policy</a> </div>
    </div>
    <div class="grid_2">
      <ul>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Delivery</a></li>
        <li><a href="#">Legal Notice</a></li>
        <li><a href="#">Terms and Conditions</a></li>
        <li><a href="#">About Us</a></li>
      </ul>
    </div>
    <div class="grid_2">
      <ul>
        <li><a href="#">New Products</a></li>
        <li><a href="#">Top Sellers</a></li>
        <li><a href="#">Specials</a></li>
        <li><a href="#">Manufacturers</a></li>
        <li><a href="#">Suppliers</a></li>
      </ul>
    </div>
    <div class="grid_2">
      <ul>
        <li><a href="#">Science &amp; Safety</a></li>
        <li><a href="#">Product </a></li>
        <li><a href="#">Our Brands</a></li>
        <li><a href="#">Agricultural </a></li>
        <li><a href="#">Traits &amp; Technologies</a></li>
      </ul>
    </div>
    <div class="grid_3 prefix_1">
      <h4>Newsletter</h4>
      <form id="newsletter" action="#">
        <div class="success">Your subscribe request has been sent!</div>
        <label class="email"> <span>Enter e-mail address</span>
          <input type="email" value="" >
          <a href="#" class="btn" data-type="submit">Subscribe</a> <span class="error">*This is not a valid email address.</span> </label>
      </form>
    </div>
    <div class="clear"></div>
  </div>
  <div class="f_bot">
    <div class="container_12">
      <div class="grid_12">Design by: <a href="http://www.templatemonster.com/">TemplateMonster.com</a></div>
    </div>
  </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>