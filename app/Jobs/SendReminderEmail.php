<?php

namespace App\Jobs;

use App\Http\Models\MrEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $message_text;
  private $email_to;
  private $subject;
  private $user;

  /**
   * Create a new job instance.
   *
   * @param $data
   */
  public function __construct($data)
  {
    $this->user = $data['user']->id();
    $this->subject = $data['subject'];
    $this->message_text = $data['message_text'];
    $this->email_to = $data['email_to'];
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Mail::send('layouts.mr_email', array('text' => $this->message_text), function ($message) {
      $message->to($this->email_to, '')->subject($this->subject);
    });

    $log = new MrEmailLog();
    $log->setUserID($this->user);
    $log->setTitle($this->subject);
    $log->setText($this->message_text);
    $log->setEmail($this->email_to);
    $log->save_mr();
  }
}
