<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\GeoIp2\tests\Integration;

use Piwik\Plugins\GeoIp2\LocationProvider\GeoIp2;

/**
 * @group GeoIp2
 */
class LocationProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testGeoIP2City()
    {
        $locationProvider = new GeoIp2\Php(['loc' => ['GeoIP2-City.mmdb'], 'isp' => []]);
        $result = $locationProvider->getLocation(['ip' => '194.57.91.215']);

        $this->assertEquals([
            'continent_name' => 'Europe',
            'continent_code' => 'EU',
            'country_code' => 'FR',
            'country_name' => 'France',
            'city_name' => 'Besançon',
            'lat' => 47.249,
            'long' => 6.018,
            'postal_code' => '25000',
            'region_code' => 'BFC',
            'region_name' => 'Bourgogne-Franche-Comte',
        ], $result);
    }

    public function testGeoIP2Country()
    {
        $locationProvider = new GeoIp2\Php(['loc' => ['GeoIP2-Country.mmdb'], 'isp' => []]);
        $result = $locationProvider->getLocation(['ip' => '194.57.91.215']);

        $this->assertEquals([
            'continent_name' => 'Europe',
            'continent_code' => 'EU',
            'country_code' => 'FR',
            'country_name' => 'France',
        ], $result);
    }

    public function testGeoIP2ASN()
    {
        $locationProvider = new GeoIp2\Php(['loc' => [], 'isp' => ['GeoLite2-ASN.mmdb']]);
        $result = $locationProvider->getLocation(['ip' => '194.57.91.215']);

        $this->assertEquals([
            'isp' => 'Matomo Internet',
            'org' => 'Matomo Internet',
        ], $result);
    }

    public function testGeoIP2ISP()
    {
        $locationProvider = new GeoIp2\Php(['loc' => [], 'isp' => ['GeoIP2-ISP.mmdb']]);
        $result = $locationProvider->getLocation(['ip' => '194.57.91.215']);

        $this->assertEquals([
            'isp' => 'Matomo Internet',
            'org' => 'Innocraft'
        ], $result);
    }

    public function testGeoIP2CityAndISP()
    {
        $locationProvider = new GeoIp2\Php(['loc' => ['GeoIP2-City.mmdb'], 'isp' => ['GeoIP2-ISP.mmdb']]);
        $result = $locationProvider->getLocation(['ip' => '194.57.91.215']);

        $this->assertEquals([
            'continent_name' => 'Europe',
            'continent_code' => 'EU',
            'country_code' => 'FR',
            'country_name' => 'France',
            'city_name' => 'Besançon',
            'lat' => 47.249,
            'long' => 6.018,
            'postal_code' => '25000',
            'region_code' => 'BFC',
            'region_name' => 'Bourgogne-Franche-Comte',
            'isp' => 'Matomo Internet',
            'org' => 'Innocraft'
        ], $result);
    }
}