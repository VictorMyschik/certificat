<?php

namespace Tests\Feature\References;

use App\Models\References\MrTechnicalReglament;
use Tests\TestCase;

class MrTechnicalReglamentTest extends TestCase
{
  function testReglament()
  {
    /**
     * 'Code'
     * 'Name'
     * 'Link'
     */

    $reglament = new MrTechnicalReglament();
    //'Code'
    $Code = $this->randomString(20);
    $reglament->setCode($Code);
    //'Name'
    $Name = $this->randomString();
    $reglament->setName($Name);
    //'Link'
    $Link = $this->randomString(300);
    $reglament->setLink($Link);

    $reglament_id = $reglament->save_mr();
    $reglament->flush();


    /// Asserts
    $reglament = MrTechnicalReglament::loadBy($reglament_id);
    $this->assertNotNull($reglament);
    $this->assertEquals($Code, $reglament->getCode());
    $this->assertEquals($Name, $reglament->getName());
    $this->assertEquals($Link, $reglament->getLink());


    /// Update
    //'Code'
    $Code = $this->randomString(20);
    $reglament->setCode($Code);
    //'Name'
    $Name = $this->randomString();
    $reglament->setName($Name);
    //'Link'
    $Link = $this->randomString(300);
    $reglament->setLink($Link);

    $reglament_id = $reglament->save_mr();
    $reglament->flush();


    /// Asserts
    $reglament = MrTechnicalReglament::loadBy($reglament_id);
    $this->assertNotNull($reglament);
    $this->assertEquals($Code, $reglament->getCode());
    $this->assertEquals($Name, $reglament->getName());
    $this->assertEquals($Link, $reglament->getLink());


    // Delete
    $reglament->mr_delete();
    $reglament->flush();

    $this->assertNull(MrTechnicalReglament::loadBy($reglament_id));
  }
}