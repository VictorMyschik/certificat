<?php


namespace Tests\Feature;


use App\Models\Certificate\MrManufacturer;
use App\Models\Certificate\MrCommunicate;
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
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $communicate->setObjectID($ObjectID);
    //'Kind'
    $Kind = array_rand(MrCommunicate::getAddressKinds());
    $communicate->setKind($Kind);
    //'Address'
    $Address = $this->randomString(255);
    $communicate->setAddress($Address);

    $communicate_id = $communicate->save_mr();
    $communicate->flush();


    //// Asserts
    $communicate = MrCommunicate::loadBy($communicate_id);
    $this->assertNotNull($communicate);
    $this->assertEquals($KindObject, $communicate->getKindObject());
    $this->assertEquals($ObjectID, $communicate->getObject()->id());
    $this->assertEquals($Kind, $communicate->getKind());
    $this->assertEquals($Address, $communicate->getAddress());

    //// Update
    //'KindObject'
    $KindObject = MrCommunicate::KIND_OBJECT_MANUFACTURER;
    $communicate->setKindObject($KindObject);
    //'ObjectID'
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $communicate->setObjectID($ObjectID);
    //'Kind'
    $Kind = array_rand(MrCommunicate::getAddressKinds());
    $communicate->setKind($Kind);
    //'Address'
    $Address = $this->randomString(255);
    $communicate->setAddress($Address);

    $communicate_id = $communicate->save_mr();
    $communicate->flush();


    //// Asserts
    $communicate = MrCommunicate::loadBy($communicate_id);
    $this->assertNotNull($communicate);
    $this->assertEquals($KindObject, $communicate->getKindObject());
    $this->assertEquals($ObjectID, $communicate->getObject()->id());
    $this->assertEquals($Kind, $communicate->getKind());
    $this->assertEquals($Address, $communicate->getAddress());

    // Delete
    $communicate->mr_delete();
    $communicate->flush();

    $this->assertNull(MrCommunicate::loadBy($communicate_id));
  }
}