<?php


namespace Tests\Feature\References;


use App\Models\References\MrMeasure;
use Tests\TestCase;

class MrMeasureTest extends TestCase
{
  public function testMrMeasure()
  {
    /**
     * Code
     * TextCode
     * Name
     */

    $measure = new MrMeasure();
    $this->assertNotNull($measure);

    //'Code'
    $Code = $this->randomString(3);
    $measure->setCode($Code);
    //'TextCode'
    $TextCode = $this->randomString(20);
    $measure->setTextCode($TextCode);
    //'Name'
    $Name = $this->randomString(50);
    $measure->setName($Name);

    $measure_id = $measure->save_mr();
    $measure->flush();


    //// Asserts
    $measure = MrMeasure::loadBy($measure_id);
    $this->assertNotNull($measure);
    $this->assertEquals($Code, $measure->getCode());
    $this->assertEquals($TextCode, $measure->getTextCode());
    $this->assertEquals($Name, $measure->getName());


    //// Update
    //'Code'
    $Code = $this->randomString(3);
    $measure->setCode($Code);
    //'TextCode'
    $TextCode = $this->randomString(20);
    $measure->setTextCode($TextCode);
    //'Name'
    $Name = $this->randomString(50);
    $measure->setName($Name);

    $measure_id = $measure->save_mr();
    $measure->flush();


    //// Asserts
    $measure = MrMeasure::loadBy($measure_id);
    $this->assertNotNull($measure);
    $this->assertEquals($Code, $measure->getCode());
    $this->assertEquals($TextCode, $measure->getTextCode());
    $this->assertEquals($Name, $measure->getName());


    // Delete
    $measure->mr_delete();
    $measure->flush();

    $this->assertNull(MrMeasure::loadBy($measure_id));
  }
}