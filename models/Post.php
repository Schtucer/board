<?php

namespace app\models;

use Yii;

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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_post';
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
            [['category_id', 'title', 'short_content','content', 'create_time', 'tags', 'img'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['short_content', 'content'], 'string'],
            [['create_time'], 'safe'],
            [['title', 'tags', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'short_content' => 'Short Content',
            'content' => 'Content',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'tags' => 'Tags',
            'img' => 'Img',
        ];
    }
}
