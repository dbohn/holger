<?php

require_once '../vendor/autoload.php';

$credentials = [
    'username' => '',
    'password' => '',
    'host' => '192.168.178.1'
];

if (file_exists('../config.php')) {
    $loadedCredentials = include '../config.php';

    $credentials = array_merge($credentials, $loadedCredentials['powerline']);
}

$holger = new Holger\Holger($credentials['host'], $credentials['password'], $credentials['username']);

$stats = $holger->powerline->powerDraw10Minutes();

echo "Average power consumption last 10 minutes: " . $stats->energy->avg() . " W\n";
echo "Average voltage level last 10 minutes: " . $stats->voltages->avg() . " V\n";
echo "Average current last 10 minutes: " . $stats->avgCurrent() . " A\n";

$stats = $holger->powerline->powerDrawLastHour();

echo "Average power consumption last hour: " . $stats->energy->avg() . " W\n";
echo "Average voltage level last hour: " . $stats->voltages->avg() . " V\n";
echo "Average current last hour: " . $stats->avgCurrent() . " A\n";

$stats = $holger->powerline->energyConsumptionLast24Hours();

echo "Power consumption today: " . $stats->energy->sum() . " Wh\n";
