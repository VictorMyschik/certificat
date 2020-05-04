<?php

namespace Tests\Feature\References;

use App\Models\References\MrCertificateKind;
use Tests\TestCase;

class MrCertificateKindTest extends TestCase
{
  public function testCertificateKind()
  {
    /**
     * 'Code',
     * 'ShortName',
     * 'Name',
     * 'Description',
     */

    $cert = new MrCertificateKind();

    //'Code',
    $Code = $this->randomString(2);
    $cert->setCode($Code);
    //'ShortName',
    $ShortName = $this->randomString(250);
    $cert->setShortName($ShortName);
    //'Name',
    $Name = $this->randomString(400);
    $cert->setName($Name);
    //'Description',
    $Description = $this->randomString(350);
    $cert->setDescription($Description);

    $cert_id = $cert->save_mr();
    $cert->flush();


    /// Asserts
    $cert = MrCertificateKind::loadBy($cert_id);
    $this->assertNotNull($cert);
    $this->assertEquals($Code, $cert->getCode());
    $this->assertEquals($ShortName, $cert->getShortName());
    $this->assertEquals($Name, $cert->getName());
    $this->assertEquals($Description, $cert->getDescription());


    /// Update
    //'Code',
    $Code = $this->randomString(2);
    $cert->setCode($Code);
    //'ShortName',
    $ShortName = $this->randomString(250);
    $cert->setShortName($ShortName);
    //'Name',
    $Name = $this->randomString(400);
    $cert->setName($Name);
    //'Description',
    $Description = $this->randomString(350);
    $cert->setDescription($Description);

    $cert_id = $cert->save_mr();
    $cert->flush();


    /// Asserts
    $cert = MrCertificateKind::loadBy($cert_id);
    $this->assertNotNull($cert);
    $this->assertEquals($Code, $cert->getCode());
    $this->assertEquals($ShortName, $cert->getShortName());
    $this->assertEquals($Name, $cert->getName());
    $this->assertEquals($Description, $cert->getDescription());


    /// Null
    $cert->setDescription(null);

    $cert_id = $cert->save_mr();
    $cert->flush();

    /// Asserts
    $cert = MrCertificateKind::loadBy($cert_id);
    $this->assertNotNull($cert);
    $this->assertNull($cert->getDescription());

    // Delete
    $cert->mr_delete();
    $cert->flush();

    $this->assertNull(MrCertificateKind::loadBy($cert_id));
  }
}