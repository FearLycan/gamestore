<?php

namespace app\models\forms;

use app\components\Translator;
use app\models\User;
use Yii;


class RegistrationForm extends User
{
    public $password_first;
    public $password_second;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['name', 'unique'],
            [['name'], 'required'],
            ['email', 'unique'],
            [['email'], 'required'],
            ['email', 'email'],
            [['password_first'], 'required'],
            [['password_second'], 'required'],
            [['password_first', 'password_second'], 'string', 'length' => [4, 30]],
            ['password_second', 'confirmPassword'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Nazwa',
            'email' => 'Adres e-mail',
            'password_first' => 'Hasło',
            'password_second' => 'Powtórz hasło',
        ];
    }


    public function confirmPassword($attribute)
    {
        if ($this->password_first != $this->password_second) {
            $this->addError($attribute, Translator::translate('The entered passwords are different'));
        }
    }
}
