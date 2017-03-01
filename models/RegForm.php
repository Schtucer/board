<?php

namespace app\models;
use yii\base\Model;

class RegForm extends Model 
{
    public $username;
    public $password;
    public $email;
    //public $status;
    
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'password', 'email'], 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 5, 'max' => 255],
            ['username', 'unique',
                'targetClass' => User::className(),
                'message' => 'Этот логин уже занят'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::className(),
                'message' => 'Этот email уже занят'],
//            ['status', 'default', 'value', User::STATUS_ACTIVE, 'on' => 'default'],
//            ['status', 'in', 'range' => 
//                [
//                    User::STATUS_NOT_ACTIVE,
//                    User::STATUS_ACTIVE,
//                ]
//            ]
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
        ];
    }
    
    public function reg() {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        //$user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
