<?php


namespace Tests\Feature\Certificate;


use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use Tests\TestCase;

class MrFioTest extends TestCase
{
  public function testMrFio()
  {
    /**
     * 'KindObject',//К чему привязан
     * 'ObjectID',//ID объекта
     * 'FirstName',//Имя max 120
     * 'MiddleName',//Отчество max 120
     * 'LastName', //Фамилия max 120
     */

    $fio = new MrFio();
    $this->assertNotNull($fio);
    //'KindObject',//К чему привязан
    $KindObject = MrFio::KIND_OBJECT_MANUFACTURER;
    $fio->setObjectKind($KindObject);
    //'ObjectID',
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $fio->setObjectID($ObjectID);
    //'FirstName',//Имя max 120
    $FirstName = $this->randomString(120);
    $fio->setFirstName($FirstName);
    //'MiddleName',//Отчество max 120
    $MiddleName = $this->randomString(120);
    $fio->setMiddleName($MiddleName);
    //'LastName', //Фамилия max 120
    $LastName = $this->randomString(120);
    $fio->setLastName($LastName);

    $fio_id = $fio->save_mr();
    $fio->flush();


    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertEquals($FirstName, $fio->getFirstName());
    $this->assertEquals($MiddleName, $fio->getMiddleName());
    $this->assertEquals($LastName, $fio->getLastName());


    //// Update
    //'KindObject',//К чему привязан
    $KindObject = MrFio::KIND_OBJECT_MANUFACTURER;
    $fio->setObjectKind($KindObject);
    //'ObjectID',
    $ObjectID = self::randomIDfromClass(MrManufacturer::class);
    $fio->setObjectID($ObjectID);
    //'FirstName',//Имя max 120
    $FirstName = $this->randomString(120);
    $fio->setFirstName($FirstName);
    //'MiddleName',//Отчество max 120
    $MiddleName = $this->randomString(120);
    $fio->setMiddleName($MiddleName);
    //'LastName', //Фамилия max 120
    $LastName = $this->randomString(120);
    $fio->setLastName($LastName);

    $fio_id = $fio->save_mr();
    $fio->flush();

    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertEquals($FirstName, $fio->getFirstName());
    $this->assertEquals($MiddleName, $fio->getMiddleName());
    $this->assertEquals($LastName, $fio->getLastName());

    //// NUll
    $fio->setFirstName(null);
    $fio->setMiddleName(null);
    $fio->setLastName(null);

    $fio_id = $fio->save_mr();
    $fio->flush();


    //// Asserts
    $fio = MrFio::loadBy($fio_id);
    $this->assertNotNull($fio);
    $this->assertNull($fio->getFirstName());
    $this->assertNull($fio->getMiddleName());
    $this->assertNull($fio->getLastName());

    $fio->mr_delete();
    $fio->flush();

    $this->assertNull(MrFio::loadBy($fio_id));
  }

}