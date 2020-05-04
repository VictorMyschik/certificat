<?php

namespace Tests\Feature\References;

use App\Models\References\MrCountry;
use Tests\TestCase;

class MrCountryTest extends TestCase
{
  public function testCountry()
  {
    /**
     * 'Name',
     * 'ISO3166alpha2',
     * 'ISO3166alpha3',
     * 'ISO3166numeric',
     * 'Continent',
     */

    $country = new MrCountry();
    //'Name',
    $Name = $this->randomString(50);
    $country->setName($Name);
    //'ISO3166alpha2',
    $ISO3166alpha2 = $this->randomString(3);
    $country->setISO3166alpha2($ISO3166alpha2);
    //'ISO3166alpha3',
    $ISO3166alpha3 = $this->randomString(4);
    $country->setISO3166alpha3($ISO3166alpha3);
    //'ISO3166numeric',
    $ISO3166numeric = $this->randomString(3);
    $country->setISO3166numeric($ISO3166numeric);
    //'Continent',
    $Continent = array_rand(MrCountry::getContinentList());
    $country->setContinent($Continent);

    $country_id = $country->save_mr();
    $country->flush();


    /// Asserts
    $country = MrCountry::loadBy($country_id);
    $this->assertNotNull($country);
    $this->assertEquals($Name, $country->getName());
    $this->assertEquals($ISO3166alpha2, $country->getISO3166alpha2());
    $this->assertEquals($ISO3166alpha3, $country->getISO3166alpha3());
    $this->assertEquals($ISO3166numeric, $country->getISO3166numeric());
    $this->assertEquals($Continent, $country->getContinent());


    /// Update
    //'Name',
    $Name = $this->randomString(50);
    $country->setName($Name);
    //'ISO3166alpha2',
    $ISO3166alpha2 = $this->randomString(3);
    $country->setISO3166alpha2($ISO3166alpha2);
    //'ISO3166alpha3',
    $ISO3166alpha3 = $this->randomString(4);
    $country->setISO3166alpha3($ISO3166alpha3);
    //'ISO3166numeric',
    $ISO3166numeric = $this->randomString(3);
    $country->setISO3166numeric($ISO3166numeric);
    //'Continent',
    $Continent = array_rand(MrCountry::getContinentList());
    $country->setContinent($Continent);

    $country_id = $country->save_mr();
    $country->flush();


    /// Asserts
    $country = MrCountry::loadBy($country_id);
    $this->assertNotNull($country);
    $this->assertEquals($Name, $country->getName());
    $this->assertEquals($ISO3166alpha2, $country->getISO3166alpha2());
    $this->assertEquals($ISO3166alpha3, $country->getISO3166alpha3());
    $this->assertEquals($ISO3166numeric, $country->getISO3166numeric());
    $this->assertEquals($Continent, $country->getContinent());

    // Delete
    $country->mr_delete();
    $country->flush();

    $this->assertNull(MrCountry::loadBy($country_id));
  }
}