<?php

namespace Holger\Modules;

use Holger\Entities\Powerline\EnergyStats;
use Holger\HasEndpoint;

/**
 * Read energy consumption stats from your powerline adapter.
 * Because of no obvious reason, these measurements are not accessible
 * via the standard home automation API and cannot be fetched via the
 * main router.
 *
 * @package Holger\Modules
 */
class Powerline
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/x_homeauto',
        'uri' => 'urn:X_AVM-DE_Homeauto-com:serviceId:X_AVM-DE_Homeauto1',
        'scpdurl' => '/x_homeautoSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * Fetch info like manufacturer, model name, serial number,
     * firmware version....
     *
     * @return array
     */
    public function info()
    {
        return $this->prepareRequest()->GetInfo();
    }

    /**
     * Query the current energy stats of the powerline plug
     * @param int    $sensorId
     * @param string $command Possible values: EnergyStats_10 (current power consumption), EnergyStats_hour (current power consumption of last hour), EnergyStats_24h (consumption in a day)
     *
     * @return mixed
     */
    public function query($sensorId = 1000, $command = "EnergyStats_10")
    {
        $sid = $this->getSid();

        $ch = curl_init();

        $url = $this->conn->makeUri('/net/home_auto_query.lua', null, null, 80);

        $url .= '?' . $sid . "&no_sidrenew=1&command={$command}&id={$sensorId}&useajax=1&xhr=1";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $phoneList = curl_exec($ch);
        curl_close($ch);

        return new EnergyStats(json_decode($phoneList, true));
    }

    public function powerDraw10Minutes($deviceId = 1000)
    {
        return $this->query($deviceId, "EnergyStats_10");
    }

    public function powerDrawLastHour($deviceId = 1000)
    {
        return $this->query($deviceId, "EnergyStats_hour");
    }

    public function energyConsumptionLast24Hours($deviceId = 1000)
    {
        return $this->query($deviceId, "EnergyStats_24h");
    }
}
