<?php


namespace App\Http\Controllers\Helpers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MrEmailHelper extends Controller
{
  public static function SendNewUser($email_to, ?string $subject, string $message_text): bool
  {
    $regex = '/\S+@\S+\.\S+/';

    if(!preg_match($regex, $email_to))
    {
      return false;
    }

    Mail::send('layouts.mr_email', array('text' => $message_text), function ($message) use ($email_to, $subject) {
      $message->to($email_to, '')->subject($subject);
    });

    return true;
  }


}