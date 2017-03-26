<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
?>
<div class="content">
  <div class="white wt2">
      <div class="container_12"></br></br></br>                
      <div class="grid_8">        
        <div class="blog">
          <time><?= date("F j, Y", strtotime($post['create_time'])) ?></time>
          <div class="blog_title"><?= $post['title'] ?></div>
          <div class="clear"></div>
          <?php $mainImg = $post->getImage() ?>
          <div class="img_inner fleft"><?= Html::img($mainImg->getUrl()) ?></div>
          <div class="extra_wrapper">
            <div class="text1">Author: <a href="<?= Url::to(['/profile/view', 'id' => $post['user_id']]) ?>"><?= $post['profile']['name'].' '.$post['profile']['surname'] ?></a></div>
            <p><?= $post['content'] ?></p><br>
            <a href="<?= Url::to(['blog/']) ?>" class="btn"><< Назад</a> </div>
        </div>
          
        <?php 
            Pjax::begin([]); 
                $lastId = \Yii::$app->db->getLastInsertID(); 
            Pjax::end();
        ?>
          
        <?php Pjax::begin([]); ?>
          <div align="center"><h5>Комментарии (<?php if(isset($_POST['comment-button'])) {
                echo (count($comments)+1);
            }else{
                echo count($comments);
            }
          ?>):</h5></div>    
    
    <?php foreach($comments as $a): ?>
            <?php if($a['parent_id'] == 0 && $a['level'] == 0): ?>
                <div class="grid_8">
                <img src="/images/no-image.jpg" alt="" class="img_inner fleft i1">
                    <div class="extra_wrapper">
                        <h1><b><?= $a['author'] ?></b> <i>говорит:</i></h1>
                        <div class="col1"><u><?= $a['created_at'] ?></u></div></br>
                        <?= $a['content'] ?></div>
                <?php $form = ActiveForm::begin([
                    'options' => ['data' => ['pjax' => true]],
                ]); ?>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11" align="left">
                        <?= Html::submitButton('Ответить', ['class' => 'btn btn-xs', 'name' => "answer-button-{$a['id']}"]); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                    <div class="clear cl4"></div>                    
                </div>
                <?php if (isset($_POST["answer-button-{$a['id']}"])): ?>        
                
                <div align="center"><h5>Ответить пользователю <?= $a['author'] ?>:</h5></div>        
                      <?php
                      $form = ActiveForm::begin([
                          'id' => 'comment-form',
                          'layout' => 'horizontal',
                          'options' => ['data' => ['pjax' => true]],
                          'fieldConfig' => [
                              'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                              'labelOptions' => ['class' => 'col-lg-3 control-label'],
                          ],
                      ]);
                      ?>
                
                      <?php $comment->parent_id = $a['id'] ?>
                      <?php $comment->level = 1 ?>

                      <?= $form->field($comment, 'author')->textInput() ?>

                      <?= $form->field($comment, 'content')->textarea(['rows' => 4]) ?>

                      <div class="form-group">
                          <div class="col-lg-offset-1 col-lg-11" align="center">
                              <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning', 'name' => 'comment-button']) ?>
                              <a href="<?= Url::to(['blog/post', 'id' => $post['id']]) ?>" class="btn">Отменить</a>
                          </div>
                      </div>

                      <?= $form->field($comment, 'parent_id')->hiddenInput()->label(false) ?>

                      <?= $form->field($comment, 'level')->hiddenInput()->label(false) ?>

                      <?php if (Yii::$app->session->hasFlash('error')): ?>
                          <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <?php echo Yii::$app->session->getFlash('error') ?>
                          </div>
                      <?php endif; ?>

                      <?php ActiveForm::end(); ?>
                  <?php endif; ?>        
        
            <?php foreach($comments as $b): ?>
                <?php if($b['parent_id'] == $a['id'] && $b['level'] == 1): ?>
                    <div class="grid_8"><div class="grid_8"><div class="grid_8">
                    <div class="grid_8"><div class="grid_8"><div class="grid_8">
                    <img src="/images/no-image.jpg" alt="" class="img_inner fleft i1">
                        <div class="extra_wrapper">
                            <h1><b><?= $b['author'] ?></b> <i>отвечает:</i></h1>
                            <div class="col1"><u><?= $b['created_at'] ?></u></div></br>
                            <?= $b['content'] ?></div>
                    <?php $form = ActiveForm::begin([
                        'options' => ['data' => ['pjax' => true]],
                    ]); ?>
                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11" align="left">
                            <?= Html::submitButton('Ответить', ['class' => 'btn btn-xs', 'name' => "answer-button-{$b['id']}"]); ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                        <div class="clear cl4"></div>                        
                    </div></div></div></div></div></div>
        
                        <?php if (isset($_POST["answer-button-{$b['id']}"])): ?>        

                            <div align="center"><h5>Ответить пользователю <?= $b['author'] ?>:</h5></div>        
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'comment-form',
                                'layout' => 'horizontal',
                                'options' => ['data' => ['pjax' => true]],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                    'labelOptions' => ['class' => 'col-lg-3 control-label'],
                                ],
                            ]);
                            ?>

                            <?php $comment->parent_id = $b['id'] ?>
                            <?php $comment->level = 2 ?>

                            <?= $form->field($comment, 'author')->textInput() ?>

                            <?= $form->field($comment, 'content')->textarea(['rows' => 4]) ?>

                            <div class="form-group">
                                <div class="col-lg-offset-1 col-lg-11" align="center">
                                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning', 'name' => 'comment-button']) ?>
                                    <a href="<?= Url::to(['blog/post', 'id' => $post['id']]) ?>" class="btn">Отменить</a>
                                </div>
                            </div>

                            <?= $form->field($comment, 'parent_id')->hiddenInput()->label(false) ?>

                            <?= $form->field($comment, 'level')->hiddenInput()->label(false) ?>

                            <?php if (Yii::$app->session->hasFlash('error')): ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo Yii::$app->session->getFlash('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
        
                <?php foreach ($comments as $c): ?>
                    <?php if($c['parent_id'] == $b['id'] && $c['level'] == 2): ?>
                        <div class="grid_8"><div class="grid_8"><div class="grid_8"><div class="grid_8"><div class="grid_8">
                        <div class="grid_8"><div class="grid_8"><div class="grid_8"><div class="grid_8"><div class="grid_8">
                        <div class="grid_8">
                        <img src="/images/no-image.jpg" alt="" class="img_inner fleft i1">
                            <div class="extra_wrapper">
                                <h1><b><?= $c['author'] ?></b> <i>отвечает:</i></h1>
                                <div class="col1"><u><?= $c['created_at'] ?></u></div></br>
                                <?= $c['content'] ?></div>
                            <div class="clear cl4"></div>                            
                        </div></div></div></div></div></div></div></div></div></div></div>                        
                            
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif;?>
        <?php endforeach; ?>        
        
        <?php if(!isset($_POST["answer-button-{$a['id']}"]) || !isset($_POST["answer-button-{$b['id']}"])): ?>
        <div align="center"><h5>Оставить комментарий:</h5></div>
        <?php 
            $form = ActiveForm::begin([
                'id' => 'comment-form',
                'layout' => 'horizontal',
                'options' => ['data' => ['pjax' => true]],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-3 control-label'],
                ],
            ]);
        ?>
        
        <?php $comment->parent_id = 0 ?>
        <?php $comment->level = 0 ?>
        
            <?= $form->field($comment, 'author')->textInput() ?>
    
            <?= $form->field($comment, 'content')->textarea(['rows' => 4]) ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11" align="center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning', 'name' => 'comment-button']) ?>
                </div>
            </div>
        
            <?= $form->field($comment, 'parent_id')->hiddenInput()->label(false) ?>
        
            <?= $form->field($comment, 'level')->hiddenInput()->label(false) ?>
        
            <?php if(Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('error') ?>
            </div>
            <?php endif; ?>

        <?php ActiveForm::end(); ?>
        <?php endif; ?>    
            <?php //debug($_POST) ?>
        <?php Pjax::end(); ?>
        
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