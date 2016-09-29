<?php

namespace app\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;

class RegistrationForm extends BaseRegistrationForm
{
  public function rules()
  {
    $rules = parent::rules();
    $rules[
      'usernameLength'] = ['username', 'string', 'min' => 6, 'max' => 255];

    return $rules;
  }

  /** Registers a new user account.
    * @return bool
    */
   // public function register()
   // {
   //     if ($this->validate()) {
   //         $user = $this->module->manager->createUser([
   //             'scenario' => 'register',
   //             'email'    => $this->email,
   //             'username' => $this->username,
   //             'password' => $this->password,
   //             'role'=>10, // User::ROLE_USER;
   //         ]);

   //         return $user->register();
   //     }

   //     return false;
   // }
}
