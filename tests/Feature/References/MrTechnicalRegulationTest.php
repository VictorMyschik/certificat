<?php

namespace Tests\Feature\References;

use App\Models\References\MrTechnicalRegulation;
use Tests\TestCase;

class MrTechnicalRegulationTest extends TestCase
{
  function testRegulation()
  {
    /**
     * 'Code'
     * 'Name'
     */
    $regulation = new MrTechnicalRegulation();
    //'Code'
    $Code = rand(1, 99);
    $regulation->setCode($Code);
    //'Name'
    $Name = $this->randomString(120);
    $regulation->setName($Name);

    $reglament_id = $regulation->save_mr();
    $regulation->flush();


    /// Asserts
    $regulation = MrTechnicalRegulation::loadBy($reglament_id);
    $this->assertNotNull($regulation);
    $this->assertEquals($Code, $regulation->getCode());
    $this->assertEquals($Name, $regulation->getName());


    /// Update
    //'Code'
    $Code = rand(1, 99);
    $regulation->setCode($Code);
    //'Name'
    $Name = $this->randomString(120);
    $regulation->setName($Name);

    $reglament_id = $regulation->save_mr();
    $regulation->flush();


    /// Asserts
    $regulation = MrTechnicalRegulation::loadBy($reglament_id);
    $this->assertNotNull($regulation);
    $this->assertEquals($Code, $regulation->getCode());
    $this->assertEquals($Name, $regulation->getName());


    // Delete
    $regulation->mr_delete();
    $regulation->flush();

    $this->assertNull(MrTechnicalRegulation::loadBy($reglament_id));
  }
}