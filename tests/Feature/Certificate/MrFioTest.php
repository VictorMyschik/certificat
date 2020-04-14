<?php


namespace Tests\Feature\Certificate;


use App\Models\Certificate\MrFio;
use Tests\TestCase;

class MrFioTest extends TestCase
{
  public function testMrFio()
  {
    /**
     * 'FirstName',//Имя max 120
     * 'MiddleName',//Отчество max 120
     * 'LastName', //Фамилия max 120
     * 'PositionName' //Должность max 120
     */

    $fio = new MrFio();
    $this->assertNotNull($fio);
    //'FirstName',//Имя max 120
    $FirstName = $this->randomString(120);
    $fio->setFirstName($FirstName);
    //'MiddleName',//Отчество max 120
    $MiddleName = $this->randomString(120);
    $fio->setMiddleName($MiddleName);
    //'LastName', //Фамилия max 120
    $LastName = $this->randomString(120);
    $fio->setLastName($LastName);
    //'PositionName' //Должность max 120
    $PositionName = $this->randomString(120);
    $fio->setPositionName($PositionName);

    $fio_id = $fio->save_mr();
    $fio->flush();


    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertEquals($FirstName, $fio->getFirstName());
    $this->assertEquals($MiddleName, $fio->getMiddleName());
    $this->assertEquals($LastName, $fio->getLastName());
    $this->assertEquals($PositionName, $fio->getPositionName());


    //// Update
    //'FirstName',//Имя max 120
    $FirstName = $this->randomString(120);
    $fio->setFirstName($FirstName);
    //'MiddleName',//Отчество max 120
    $MiddleName = $this->randomString(120);
    $fio->setMiddleName($MiddleName);
    //'LastName', //Фамилия max 120
    $LastName = $this->randomString(120);
    $fio->setLastName($LastName);
    //'PositionName' //Должность max 120
    $PositionName = $this->randomString(120);
    $fio->setPositionName($PositionName);

    $fio_id = $fio->save_mr();
    $fio->flush();


    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertEquals($FirstName, $fio->getFirstName());
    $this->assertEquals($MiddleName, $fio->getMiddleName());
    $this->assertEquals($LastName, $fio->getLastName());
    $this->assertEquals($PositionName, $fio->getPositionName());


    //// NUll
    $fio->setFirstName(null);
    $fio->setMiddleName(null);
    $fio->setLastName(null);
    $fio->setPositionName(null);

    $fio_id = $fio->save_mr();
    $fio->flush();


    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertNull($fio->getFirstName());
    $this->assertNull($fio->getMiddleName());
    $this->assertNull($fio->getLastName());
    $this->assertNull($fio->getPositionName());

    $fio->mr_delete();
    $fio->flush();

    $this->assertNull(MrFio::loadBy($fio_id));
  }

}