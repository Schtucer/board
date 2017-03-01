<?php

namespace app\models;
/**
 * This is the model class for table "tbl_comment".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $level
 * @property integer $post_id
 * @property string $created_at
 * @property string $author
 * @property string $content
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_comment';
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'username_id']);
    }
    
    public function getPost() {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'content'], 'required'],
            [['parent_id', 'level', 'post_id', 'username_id'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string'],
            [['author'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [            
            'author' => 'Имя*',
            'content' => 'Комментарий*',
        ];
    }
    
    public function saveComment() {
        $comment = new Comment();
        $comment->author = $this->author;
        $comment->content = $this->content;
        $comment->post_id = $_GET['id'];
        $comment->parent_id = $this->parent_id;
        $comment->level = $this->level;
        return $comment->save() ? $comment : null;
    }    

}
