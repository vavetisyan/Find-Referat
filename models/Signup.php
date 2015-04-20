<?php
namespace frontend\models;

use app\models\Users;
use yii\base\Model;
use Yii;

/**
 * Sign up
 */
class Signup extends Model
{
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;

    public function __construct($array = NULL){
        if(!empty($array)) {
            $this->username = $array['username'];
            $this->password = $array['password'];
            $this->first_name = $array['first_name'];
            $this->last_name = $array['last_name'];
            $this->email = $array['email'];
        }
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new Users();
        $user->setUsername($this->username);
        $user->setPassword($this->password);
        $user->setRev($this->password);
        $user->setFirstName($this->first_name);
        $user->setLastName($this->last_name);
        $user->setEmail($this->email);
        $user->generateAuthKey();

        if($user->validate()){
            $user->save();
            return $user;
        }

        return null;
    }
}
