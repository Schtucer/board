<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_image".
 *
 * @property integer $id
 * @property string $file_path
 * @property integer $post_id
 * @property integer $is_main
 * @property string $model_name
 * @property string $url_alias
 * @property string $name
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_path', 'is_main', 'model_name', 'url_alias', 'name'], 'required'],
            [['post_id', 'is_main'], 'integer'],
            [['file_path', 'url_alias'], 'string', 'max' => 400],
            [['model_name'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_path' => 'File Path',
            'post_id' => 'Post ID',
            'is_main' => 'Is Main',
            'model_name' => 'Model Name',
            'url_alias' => 'Url Alias',
            'name' => 'Name',
        ];
    }
}
