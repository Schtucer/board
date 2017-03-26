<?php

namespace app\controllers;

use Yii;
use app\models\Profile;
use app\models\Rating;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!(Yii::$app->user->identity['username'] == 'admin' && Yii::$app->user->identity['id'] == '1'))
            throw new HttpException(404, 'У Вас нет прав администратора!');
        
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image) {
                $model->upload();
            }
            unset($model->image);
            Yii::$app->session->setFlash('success', "Профиль успешно создан");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image) {
                $model->upload();
            }
            unset($model->image);
            Yii::$app->session->setFlash('success', "Профиль успешно обновлен");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionRating($id){
        $model = Profile::findOne($id);
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->get();
        }
        if($data['rating']){
            $rating = $data['rating']; 
            //$rating = addslashes($rating);
            //$rating = htmlspecialchars($rating);
            //$rating = stripslashes($rating);
            //$rating = mysql_real_escape_string($rating);
            //debug($data['rating']);
            
            if($rating > 5 || $rating < 0){
                exit("Ошибка!!!");
            }

            $total_votes = $model->total_votes;
            $total_value = $model->total_value;
            $used_ips = $model->used_ips;

            $ipsArray = explode("|", $used_ips);
            $ip = $_SERVER['REMOTE_ADDR'];
            
            if(in_array($ip, $ipsArray)){
                exit("Вы уже голосовали!");
            }

            $total_votes++;
            $total_value = $total_value + $rating;
            $used_ips = $used_ips."|".$ip;

            $model->total_votes = $total_votes;
            $model->total_value = $total_value;
            $model->used_ips = $used_ips;
            $model->save();
            //return $this->refresh();
            
        }else{
            echo "Ошибка";
        }
    }
}
