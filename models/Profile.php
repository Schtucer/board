<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $city
 * @property string $region
 * @property integer $phone
 * @property string $image
 */
class Profile extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_profile';
    }
    
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    
    public function getPost() {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'city', 'region', 'phone'], 'required'],
            [['user_id', 'total_votes', 'total_value'], 'integer'],
            [['used_ips'], 'string'],
            [['phone'], 'string', 'max' => 14],
            [['name', 'surname', 'region'], 'string', 'max' => 50],
            [['city'], 'string', 'max' => 100],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'city' => 'Город',
            'region' => 'Область',
            'phone' => 'Телефон',
            'image' => 'Фото',
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
}
