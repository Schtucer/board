<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = $model->name .' '. $model->surname;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h2><?= Html::encode($this->title) ?></h2></br>

    <?php if($model->user_id == \Yii::$app->user->identity->id): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить свой профиль навсегда?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif ?>
    
    <?php $img = $model->getImage() ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            'name',
            'surname',
            'city',
            'region',
            'phone',
            [
                'attribute' => 'image',
                'value' => "<img src='{$img->getUrl()}'>",
                'format' => 'html',
            ],            
        ],
    ]) ?>   
    
    
<script type="text/javascript">
$(document).ready(function() {
	var starsAll = <?= $model->total_value ?>;//Всего звезд
	var voteAll = <?= $model->total_votes ?>;//Всего голосов
	var idArticle = <?= $model->id ?>;//id статьи
	var starWidth = 17;//ширина одной звезды
	var rating = (starsAll/voteAll); //Старый рейтинг
	rating = Math.round(rating*100)/100;
	if(isNaN(rating)){
		rating = 0;
	}
	var ratingResCss = rating*starWidth; //старый рейтинг в пикселях

	$("#ratDone").css("width", ratingResCss);	
	$("#ratStat").html("Рейтинг: <strong>"+rating+"</strong> Голосов: <strong>"+voteAll+"</strong>");
	
	<?php
	$used_ips = $model->used_ips; // вытаскиваем все поле used_ips оно будет содеражать все ip адреса проголосовавших разделенные |
	$ipsArray = explode("|",$used_ips);
	$ip = $_SERVER['REMOTE_ADDR'];
	if(!in_array($ip,$ipsArray)){ //Чтобы предотвратить повторное голосование после обновления, мы просто скрываем функции отвечаюшие за это
	?>
	var coords;
	var stars;	//кол-во звезд при наведении
	var ratingNew;	//Новое количество звезд

	$("#rating").mousemove(function(e){
		var offset = $("#rating").offset();
		coords = e.clientX - offset.left; //текушая координата
		stars = Math.ceil(coords/starWidth); 
		starsCss = stars*starWidth;
		$("#ratHover").css("width", starsCss).attr("title", stars+" из 5");
	});
	$("#rating").mouseout(function(){
		$("#ratHover").css("width", 0);
	});
	$("#rating").click(function(){
		starsNew = stars + starsAll; //новое количество звезд
		voteAll += 1;		
		var ratingNew = starsNew/voteAll;
		ratingNew = Math.round(ratingNew*100)/100;
		var razn = Math.round((rating - ratingNew)*200);//вычислям разницу между новым и старым рейтингом для анимации
		razn = Math.abs(razn);
				
		var total = Math.round(ratingNew*starWidth);
		$.ajax({
			type: "GET",
			url: "/profile/rating",
			data: {"id": idArticle, "rating": stars},
			cache: false,						
			success: function(response){
				if(response == 1){
					var newRat = response+"px";
					$("#ratHover").css("display", "none");
					$("#ratDone").animate({width: total},razn);
					$("#ratBlocks").show();
					$("#ratStat").html("Рейтинг: <strong>"+ratingNew+"</strong> Голосов: <strong>"+voteAll+"</strong>");
				}else{
					$("#ratStat").text(response);
				}							
			}
		});
		return false;
	});
        <?php	
	}
	?>
});
</script>
    
<div id="ratingBar">
    <div id="rating">
        <div id="ratZero"></div>
        <div id="ratDone"></div>
        <div id="ratHover"></div>
    </div>
    <div id="ratBlocks"></div>
    <div id="ratStat"></div>
</div>
    
</div>