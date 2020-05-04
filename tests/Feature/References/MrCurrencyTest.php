<?php

namespace Tests\Feature\References;

use App\Helpers\MrDateTime;
use App\Models\References\MrCurrency;
use Tests\TestCase;

class MrCurrencyTest extends TestCase
{
  function testCurrency()
  {
    /**
     * 'Code',
     * 'TextCode',
     * 'DateFrom',
     * 'DateTo',
     * 'Name',
     * 'Rounding',
     * 'Description'
     */

    $currency = new MrCurrency();
    //'Code',
    $Code = $this->randomString(3);
    $currency->setCode($Code);
    //'TextCode',
    $TextCode = $this->randomString(3);
    $currency->setTextCode($TextCode);
    //'DateFrom',
    $DateFrom = MrDateTime::now();
    $currency->setDateFrom($DateFrom);
    //'DateTo',
    $DateTo = MrDateTime::now();
    $currency->setDateTo($DateTo);
    //'Name',
    $Name = $this->randomString(200);
    $currency->setName($Name);
    //'Rounding',
    $Rounding = random_int(1, 5);
    $currency->setRounding($Rounding);
    //'Description'
    $Description = $this->randomString();
    $currency->setDescription($Description);

    $currency_id = $currency->save_mr();
    $currency->flush();


    /// Asserts
    $currency = MrCurrency::loadBy($currency_id);
    $this->assertNotNull($currency);
    $this->assertEquals($Code, $currency->getCode());
    $this->assertEquals($TextCode, $currency->getTextCode());
    $this->assertEquals($DateFrom->getShortDate(), $currency->getDateFrom()->getShortDate());
    $this->assertEquals($DateTo->getShortDate(), $currency->getDateTo()->getShortDate());
    $this->assertEquals($Name, $currency->getName());
    $this->assertEquals($Rounding, $currency->getRounding());
    $this->assertEquals($Description, $currency->getDescription());


    /// Update
    //'Code',
    $Code = $this->randomString(3);
    $currency->setCode($Code);
    //'TextCode',
    $TextCode = $this->randomString(3);
    $currency->setTextCode($TextCode);
    //'DateFrom',
    $DateFrom = MrDateTime::now();
    $currency->setDateFrom($DateFrom);
    //'DateTo',
    $DateTo = MrDateTime::now();
    $currency->setDateTo($DateTo);
    //'Name',
    $Name = $this->randomString(200);
    $currency->setName($Name);
    //'Rounding',
    $Rounding = random_int(1, 5);
    $currency->setRounding($Rounding);
    //'Description'
    $Description = $this->randomString();
    $currency->setDescription($Description);

    $currency_id = $currency->save_mr();
    $currency->flush();


    /// Asserts
    $currency = MrCurrency::loadBy($currency_id);
    $this->assertNotNull($currency);
    $this->assertEquals($Code, $currency->getCode());
    $this->assertEquals($TextCode, $currency->getTextCode());
    $this->assertEquals($DateFrom->getShortDate(), $currency->getDateFrom()->getShortDate());
    $this->assertEquals($DateTo->getShortDate(), $currency->getDateTo()->getShortDate());
    $this->assertEquals($Name, $currency->getName());
    $this->assertEquals($Rounding, $currency->getRounding());
    $this->assertEquals($Description, $currency->getDescription());

    /// NUll
    $currency->setDateFrom(null);
    $currency->setDateTo(null);
    $currency->setDescription(null);

    $currency_id = $currency->save_mr();
    $currency->flush();


    /// Asserts
    $currency = MrCurrency::loadBy($currency_id);
    $this->assertNotNull($currency);
    $this->assertNull($currency->getDateFrom());
    $this->assertNull($currency->getDateTo());
    $this->assertNull($currency->getDescription());


    //Delete
    $currency->mr_delete();
    $currency->flush();

    $this->assertNull(MrCurrency::loadBy($currency_id));
  }
}