<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="content">
  <div class="white wt2">
    <div class="container_12">
      <div class="grid_12">
        <h3>Поиск по запросу: <strong><u><em><?= Html::encode($q) ?></em></u></strong></h3><?php //debug($q) ?>
      </div>
      <hr align="left" size="5" width="67%" color="#3399ff">
      <div class="grid_8">
        
        <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>
        <div class="blog">
          <time><?= date("F j, Y", strtotime($post['create_time'])) ?></time>
          <div class="blog_title"><?= $post['title'] ?></div>
          <div class="clear"></div>
          <?php $mainImg = $post->getImage() ?>
          <div class="img_inner fleft"><?= Html::img($mainImg->getUrl('152x')) ?></div>
          <div class="extra_wrapper">
            <div class="text1">Author: <a href="<?= Url::to(['/profile/view', 'id' => $post['user_id']]) ?>"><?= $post['profile']['name'].' '.$post['profile']['surname'] ?></a></div>
            <p><?= $post['short_content'] ?></p><br>
            <a href="<?= Url::to(['blog/post', 'id' => $post['id']]) ?>" class="btn">Читать >></a> </div>
        </div>
        <?php endforeach; ?>
        <?php echo yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
        <?php else: ?>
            <h3>Ничего не найдено...</h3>
        <?php endif ?>
      </div>
      <div class="grid_3 prefix_1">
        <h5>Categories</h5>
        <ul class="list">
          <?php foreach($categories as $category): ?>          
          <li><a href="<?= Url::to(['blog/category', 'id' => $category['id']]) ?>"><?= $category['name'] ?></a></li>          
          <?php endforeach; ?>
        </ul>
        <div class="blog_search">
          <h5>Search</h5>
          <form id="form1" action="<?= yii\helpers\Url::to(['blog/search']) ?>">
            <span>Enter keywords</span>
            <input type="text" value="" placeholder="Поиск..." name="q">
            <a onClick="document.getElementById('form1').submit()" href="<?= yii\helpers\Url::to(['blog/search']) ?>"></a>
          </form>          
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>