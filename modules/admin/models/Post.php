<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "tbl_post".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $short_content
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
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'short_content', 'content', 'tags',], 'required'],
            [['category_id', 'status'], 'integer'],
            [['short_content', 'content'], 'string'],
            [['create_time'], 'safe'],
            [['title', 'tags', 'img'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'ID категории',
            'title' => 'Заглавие',
            'short_content' => 'Превью',
            'content' => 'Контент',
            'status' => 'Статус',
            'create_time' => 'Дата создания',
            'tags' => 'Тэги',
            'image' => 'Изображение',
            'gallery' => 'Галлерея'
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
