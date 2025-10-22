<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\User;
use yii\console\ExitCode;

class CreateSuperUserController extends Controller
{
  public function actionIndex()
  {
    $username = $this->prompt("Username:");
    $email = $this->prompt("Email:");
    $password = $this->prompt("Password:");

    $user = new User();
    $user->username = $username;
    $user->email = $email;
    $user->setPassword($password); // Assuming you have a method to hash the password 
    $user->generateAuthKey();
    $user->status = User::STATUS_ACTIVE;

    if ($user->save()) {
      echo "Superuser created successfully.\n";
      return ExitCode::OK;
    } else {
      echo "Failed to create superuser.\n";
      var_dump($user->errors);
      return ExitCode::UNSPECIFIED_ERROR;
    }
  }
}
