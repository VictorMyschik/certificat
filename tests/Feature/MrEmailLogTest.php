<?php


namespace Tests\Feature;


use App\Models\MrEmailLog;
use App\Models\MrUser;
use Tests\TestCase;

class MrEmailLogTest extends TestCase
{
  public function testMrEmailLog()
  {
    /**
     * UserID
     * Email
     * Title
     * Text
     * WriteDate
     */

    $log = new MrEmailLog();
    //UserID
    $UserID = self::randomIDfromClass(MrUser::class);
    $log->setUserID($UserID);
    //Email
    $Email = $this->randomString();
    $log->setEmail($Email);
    //Title
    $Title = $this->randomString();
    $log->setTitle($Title);
    //Text
    $Text = $this->randomString();
    $log->setText($Text);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrEmailLog::loadBy($log_id);
    $this->assertNotNull($log);
    $this->assertEquals($UserID, $log->getUser()->id());
    $this->assertEquals($Email, $log->getEmail());
    $this->assertEquals($Title, $log->getTitle());
    $this->assertEquals($Text, $log->getText());
    $this->assertNotNull($log->getWriteDate());


    //// Update
    //UserID
    $UserID = self::randomIDfromClass(MrUser::class);
    $log->setUserID($UserID);
    //Email
    $Email = $this->randomString();
    $log->setEmail($Email);
    //Title
    $Title = $this->randomString();
    $log->setTitle($Title);
    //Text
    $Text = $this->randomString();
    $log->setText($Text);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrEmailLog::loadBy($log_id);
    $this->assertNotNull($log);
    $this->assertEquals($UserID, $log->getUser()->id());
    $this->assertEquals($Email, $log->getEmail());
    $this->assertEquals($Title, $log->getTitle());
    $this->assertEquals($Text, $log->getText());
    $this->assertNotNull($log->getWriteDate());


    //// Null
    $log->setText(null);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrEmailLog::loadBy($log_id);
    $this->assertNotNull($log);
    $this->assertNull($log->getText());

    // Delete
    $log->mr_delete();
    $log->flush();

    $this->assertNull(MrEmailLog::loadBy($log_id));

  }
}