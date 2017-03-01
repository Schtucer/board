<?php

namespace app\controllers;
use app\models\Post;
use app\models\Category;
use app\models\Comment;
use yii\data\Pagination;
use yii\web\HttpException;
use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class BlogController extends AppController {      
    
    public function actionIndex() {
        $query = Post::find()->asArray();
        if(empty($query)) {
            throw new HttpException(404, 'Не найдено ни одной статьи!');
        }        
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 2,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $posts = $query->offset($pages->offset)->limit($pages->limit)->all();
        $categories = Yii::$app->cache->get('categories');
        if($categories) {
            return $this->render('index', compact('pages', 'categories', 'posts'));            
        } else {
            $categories = Category::find()->asArray()->all();
        }
        if(empty($categories)) {
            throw new HttpException(404, 'Не найдено ни одной категории!');
        }
        Yii::$app->cache->set('categories', $categories, 10);
        $this->setMeta('Garden Truck');
        
        return $this->render('index', compact('pages', 'categories', 'posts'));
    }
    
    public function actionPost() {
        $id = Yii::$app->request->get($id);        
        $post = Post::findOne($id);
        if(empty($post)) {
            throw new HttpException(404, 'Такой статьи не существует!');
        }
        $categories = Yii::$app->cache->get('categories');
        
        $comment = new Comment();
        if($comment->load(Yii::$app->request->post())) {
            if($comment->validate()){
                $comment = $comment->saveComment();  
            }
        }
        $comments = Comment::find()->asArray()->where(['post_id' => $id])->all();
        if((isset($_POST['comment-button'])) || (isset($_POST['cancel-button']))) {
            $comments = Comment::find()->asArray()->where(['post_id' => $id])->all();
            $comment->author = '';
            $comment->content = '';
        }
        
        if($post && $categories) {
            return $this->render('post', compact('categories', 'post', 'comment', 'comments'));
        } else {
            $categories = Category::find()->asArray()->all();
        }
        if(empty($categories)) {
            throw new HttpException(404, 'Не найдено ни одной категории!');
        }        
        Yii::$app->cache->set('categories', $categories, 10);
        //$this->setMeta('Garden Truck | ' . $post->name, $post->keywords, $post->description);
        return $this->render('post', compact('categories', 'post', 'comment', 'comments'));
    }
    
    public function actionCategory() {
        $id = Yii::$app->request->get($id);
        $category = Category::find()->asArray()->where(['id' => $id])->limit(1)->one();
        if(empty($category)) {
            throw new HttpException(404, 'Такой категории не существует!');
        }
        $categories = Yii::$app->cache->get('categories');
        $query = Post::find()->where(['category_id' => $id])->asArray();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 2, 
            'forcePageParam' => false, 'pageSizeParam' => false]);
        $posts = $query->offset($pages->offset)->limit($pages->limit)->all();
        if(empty($posts)) {
            throw new HttpException(404, 'В этой категории пока нет статей!');
        }
        if($category && $categories) {
            return $this->render('index', compact('pages', 'posts','categories'));            
        } else {
            $categories = Category::find()->asArray()->all();
        }        
        if(empty($categories)) {
            throw new HttpException(404, 'Не найдено ни одной категории!');
        }
        Yii::$app->cache->set('categories', $categories, 10);
        //$this->setMeta('Garden Truck | ' . $category->name, $category->keywords, $category->description);
        return $this->render('index', compact('pages', 'posts','categories'));
    }

    public function actionSearch() {        
        $q = trim(Yii::$app->request->get('q'));
        $categories = Yii::$app->cache->get('categories');
        if (!$categories) {            
            $categories = Category::find()->asArray()->all();
            Yii::$app->cache->set('categories', $categories, 10);
        }
        if(!$q)
            return $this->render('search', compact('categories'));
        $query = Post::find()->where(['like', 'title', $q]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 2,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $posts = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('search', compact('categories', 'posts', 'pages', 'q'));
    }

}