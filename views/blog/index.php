<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="content">
  <div class="white wt2">
    <div class="container_12">
      <div class="grid_12">
        <h3>Blog</h3><?php //debug($category) ?>
      </div>        
      <div class="grid_8">       
        <?php foreach($posts as $post): ?>
        <div class="blog">
          <time><?= date("F j, Y", strtotime($post['create_time'])) ?></time>
          <div class="blog_title"><?= $post['title'] ?></div>
          <div class="clear"></div>
          <div class="img_inner fleft"><?= Html::img("@web/images/blog/{$post['img']}") ?></div>
          <div class="extra_wrapper">
            <div class="text1">Author: <a href="#">admin</a></div>
            <p><?= $post['short_content'] ?></p><br>
            <a href="<?= Url::to(['blog/post', 'id' => $post['id']]) ?>" class="btn">More >></a> </div>
        </div>
        <?php endforeach; ?>
        <?php echo yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
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