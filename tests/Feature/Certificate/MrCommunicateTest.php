<?php

namespace Tests\Feature\Certificate;

use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrManufacturer;
use Tests\TestCase;

class MrCommunicateTest extends TestCase
{
  public function testMrCommunicate()
  {
    /**
     * 'KindObject',//К чему привязан
     * 'ObjectID',//ID объекта
     * 'Kind',// Тип: телефон, email, факс...
     * 'Address',
     */

    $communicate = new MrCommunicate();
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
    $this->assertEquals($Kind, $communicate->getKind());
    $this->assertEquals($Address, $communicate->getAddress());


    //// Update
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
    $this->assertEquals($Kind, $communicate->getKind());
    $this->assertEquals($Address, $communicate->getAddress());


    // Delete
    $communicate->mr_delete();
    $communicate->flush();

    $this->assertNull(MrCommunicate::loadBy($communicate_id));
  }
}