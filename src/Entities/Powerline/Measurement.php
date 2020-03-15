<?php

namespace Holger\Entities\Powerline;

class Measurement
{
    public $count;
    public $layer;
    public $values;
    public $deviceId;
    public $timesType;

    /**
     * Measurement constructor.
     *
     * @param array $measurement
     * @param int   $divider All values are divided by this value.
     *                       This can be used to convert all values to their base dimension.
     *                       Strangely, Power Values seem to be transmitted in cW, whereas voltage in mV
     */
    public function __construct(array $measurement, $divider = 1)
    {
        $this->deviceId = $measurement['ID'];
        $this->count = $measurement['anzahl'];
        $this->layer = $measurement['ebene'];

        // I've got no clue, what this is used for!
        $this->timesType = $measurement['times_type'];

        $this->values = array_map(function ($value) use ($divider) {
            return $value / $divider;
        }, $measurement['values']);
    }

    public function avg()
    {
        return round(array_sum($this->values) / count($this->values), 2);
    }

    public function sum()
    {
        return array_sum($this->values);
    }
}
