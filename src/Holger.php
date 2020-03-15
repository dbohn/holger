<?php

namespace Holger;

use Holger\Modules\AnsweringMachine;
use Holger\Modules\CallList;
use Holger\Modules\DECTInfo;
use Holger\Modules\DeviceInfo;
use Holger\Modules\Powerline;
use Holger\Modules\Hosts;
use Holger\Modules\Network;
use Holger\Modules\PackageCounter;
use Holger\Modules\Phonebook;
use Holger\Modules\Voip;
use Holger\Modules\WANIP;
use Holger\Modules\WANMonitor;
use Holger\Modules\WANStats;

/**
 * @property AnsweringMachine answeringMachine
 * @property Network network
 * @property WANIP ip
 * @property WANMonitor monitor
 * @property WANStats stats
 * @property CallList calls
 * @property DECTInfo dect
 * @property PackageCounter counter
 * @property DeviceInfo device
 * @property Phonebook phonebook
 * @property Hosts hosts
 * @property Voip voip
 * @property Powerline powerline
 */
class Holger
{
    protected $connection;

    protected $availableModules = [
        'answeringMachine' => AnsweringMachine::class,
        'network' => Network::class,
        'ip' => WANIP::class,
        'monitor' => WANMonitor::class,
        'stats' => WANStats::class,
        'calls' => CallList::class,
        'dect' => DECTInfo::class,
        'counter' => PackageCounter::class,
        'device' => DeviceInfo::class,
        'phonebook' => Phonebook::class,
        'hosts' => Hosts::class,
        'voip' => Voip::class,
        'powerline' => Powerline::class,
    ];

    protected $modules = [];

    public function __construct($host, $password, $username = null)
    {
        $this->connection = new TR064Connection($host, $password, $username);
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->modules)) {
            $module = $this->availableModules[$name];
            $this->modules[$name] = new $module($this->connection);
        }

        return $this->modules[$name];
    }
}
