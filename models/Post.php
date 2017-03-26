<?php

namespace app\models;

/**
 * This is the model class for table "tbl_post".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $create_time
 * @property string $tags
 * @property string $img
 */
class Post extends \yii\db\ActiveRecord
{
    public $image;
    public $gallery;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_post';
    }
    
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['id' => 'user_id']);
    }
    
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function getComment() {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'short_content', 'content', 'tags'], 'required'],
            [['category_id', 'user_id', 'status'], 'integer'],
            [['short_content', 'content'], 'string'],
            [['create_time'], 'safe'],
            [['title', 'tags'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Выбор категории',
            'user_id' => 'ID пользователя',
            'title' => 'Заглавие',
            'short_content' => 'Превью',
            'content' => 'Контент',
            'status' => 'Статус',
            'create_time' => 'Дата создания',
            'tags' => 'Тэги',
            'image' => 'Изображение',
        ];
    }
    
    public function upload() {
        if($this->validate()) {
            $path = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }
    
    public function uploadGallery() {
        if($this->validate()) {
            foreach($this->gallery as $file) {
                $path = 'upload/store/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                @unlink($path);
            }
            return true;
        } else {
            return false;
        }
    }
}
