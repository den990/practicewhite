<?php
namespace frontend\models\User;

use common\models\User;
use common\models\AccessToken;
use Yii;
use yii\base\Model;

class RegistrationUserForm extends Model
{
    public $email;
    public $username;
    public $password;


    public function rules()
    {
        return [
            [['username','password'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function init()
    {
        $this->load(Yii::$app->request->post(), '');
    }

    public function registration()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = 10;
        $modelAccessToken = new AccessToken();
        $modelAccessToken->accessToken =Yii::$app->security->generateRandomString();
        // TODO обработка ошибки при сохранении
        if ($user->save()) {
            $modelAccessToken->idUser = $user->getId();
            if ($modelAccessToken->save()) {
                return ['message' => 'Пользователь зарегестрирован',
                    'access_token' => $modelAccessToken->accessToken];
            }
            else
            {
                return ['message' => 'AccessToken error save'];
            }
        }
        else
        {
            return ['message' => 'Произошла ошибка при сохранении пользователя'];
        }
    }
}