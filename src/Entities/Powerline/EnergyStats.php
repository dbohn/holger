<?php

namespace Holger\Entities\Powerline;

use BadMethodCallException;

class EnergyStats
{

    public $connectState;

    /**
     * @var bool True if the switch is closed and the outlet is active
     */
    public $isActive;

    public $deviceId;

    /**
     * @var Measurement
     */
    public $voltages;

    /**
     * @var Measurement
     */
    public $energy;

    public function __construct($response)
    {
        $this->connectState = $response['DeviceConnectState'];

        if (array_key_exists('VoltageStat', $response)) {
            $this->voltages = new Measurement($response['VoltageStat'], 1000);
        }

        $this->isActive = $response['DeviceSwitchState'] === '1';

        $this->energy = new Measurement($response['EnergyStat'], $response['EnergyStat']['times_type'] === 900 ? 1 : 100);

        $this->deviceId = $response['DeviceID'];
    }

    public function avgCurrent()
    {
        if ($this->voltages === null) {
            throw new BadMethodCallException("You are not allowed to call this method on this measurement");
        }

        return round($this->energy->avg() / $this->voltages->avg(), 3);
    }
}
