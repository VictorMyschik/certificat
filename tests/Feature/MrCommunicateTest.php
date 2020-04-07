<?php


namespace Tests\Feature;


use App\Models\MrCommunicate;
use Tests\TestCase;

class MrCommunicateTest extends TestCase
{
  public function testMrCommunicate()
  {
    /*
     'KindObject',//К чему привязан
     'ObjectID',//ID объекта
     'Kind',// Тип: телефон, email, факс...
     'Address',
    */

    $communicate = new MrCommunicate();
    //'KindObject'
    $KindObject = MrCommunicate::KIND_OBJECT_MANUFACTURER;
    $communicate->setKindObject($KindObject);
    //'ObjectID'
    $ObjectID = rand(1, 100000);
    $communicate->setObjectID($ObjectID);
    //'Kind'
    $Kind = array_rand(MrCommunicate::getKinds());
    $communicate->setKind($Kind);
    //'Address'
    $Address = $this->randomString(255);
    $communicate->setAddress($Address);

    $communicate_id = $communicate->save_mr();
    $communicate->flush();


    //// Asserts
    $communicate = MrCommunicate::loadBy($communicate_id);
    $this->assertEquals($KindObject, $communicate->getKindObject());
    $this->assertEquals($ObjectID, $communicate->getObject());
    $this->assertEquals($Kind, $communicate->getKind());
    $this->assertEquals($Address, $communicate->getAddress());


  }
}