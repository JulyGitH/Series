<?php

namespace App\Notification;

use App\Entity\User;

class Sender
{

    public function sendNewUserToAdmin(User $user){

        file_put_contents('notif.txt', $user->getUsername());

    }

}