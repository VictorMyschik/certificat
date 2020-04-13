<?php


namespace Tests\Feature;


use App\Models\MrBaseLog;
use App\Models\MrLogIdent;
use Tests\TestCase;

class MrBaseLogTest extends TestCase
{
  public function testMrBaseLog()
  {
    /**
     * LogIdentID
     * RowId
     * TableName
     * Field
     * Value
     * WriteDate
     */

    $log = new MrBaseLog();
    // LogIdentID
    $LogIdentID = self::randomIDfromClass(MrLogIdent::class);
    $log->setLogIdentID($LogIdentID);
    // RowId
    $RowId = random_int(1, 10000);
    $log->setRowId($RowId);
    // TableName
    $TableName = $this->randomString();
    $log->setTableName($TableName);
    // Field
    $Field = $this->randomString();
    $log->setField($Field);
    // Value
    $Value = $this->randomString();
    $log->setValue($Value);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrBaseLog::loadBy($log_id);
    $this->assertNotNull($log);

    $this->assertEquals($LogIdentID, $log->getLogIdent()->id());
    $this->assertEquals($RowId, $log->getRowId());
    $this->assertEquals($TableName, $log->getTName());
    $this->assertEquals($Field, $log->getField());
    $this->assertEquals($Value, $log->getValue());
    $this->assertNotNull($log->getWriteDate());

    //// Update
    // LogIdentID
    $LogIdentID = self::randomIDfromClass(MrLogIdent::class);
    $log->setLogIdentID($LogIdentID);
    // RowId
    $RowId = random_int(1, 10000);
    $log->setRowId($RowId);
    // TableName
    $TableName = $this->randomString();
    $log->setTableName($TableName);
    // Field
    $Field = $this->randomString();
    $log->setField($Field);
    // Value
    $Value = $this->randomString();
    $log->setValue($Value);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrBaseLog::loadBy($log_id);
    $this->assertNotNull($log);

    $this->assertEquals($LogIdentID, $log->getLogIdent()->id());
    $this->assertEquals($RowId, $log->getRowId());
    $this->assertEquals($TableName, $log->getTName());
    $this->assertEquals($Field, $log->getField());
    $this->assertEquals($Value, $log->getValue());
    $this->assertNotNull($log->getWriteDate());


    //// Null
    $log->setValue(null);

    $log_id = $log->save_mr();
    $log->flush();

    //// Asserts
    $log = MrBaseLog::loadBy($log_id);
    $this->assertNotNull($log);

    $this->assertNull($log->getValue());

    $log->mr_delete();
    $log->flush();

    $this->assertNull(MrBaseLog::loadBy($log_id));
  }
}