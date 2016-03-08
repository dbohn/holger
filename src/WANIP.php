<?php


namespace Holger;


use Holger\Exceptions\IPv6UnavailableException;

class WANIP
{
    protected $endpoint = [
        'controlUri' => '/igdupnp/control/WANIPConn1',
        'uri' => 'urn:schemas-upnp-org:service:WANIPConnection:1',
        'scpdurl' => '/wanipconnSCPD.xml',
    ];

    use HasEndpoint;


    /**
     * Get connection state and uptime
     * @return mixed
     */
    public function status()
    {
        return $this->prepareRequest()->GetStatusInfo();
    }

    /**
     * Fetch the external IPv4 address
     * @return string The IPv4 address in the usual 4 octet style
     */
    public function externalIP()
    {
        return $this->prepareRequest()->GetExternalIPAddress();
    }

    /**
     * Fetch the external IPv6 address
     * This operation may fail, if your internet connection does not provide
     * a IPv6 address!
     * @return mixed
     * @throws IPv6UnavailableException
     */
    public function externalIPv6()
    {
        try {
            return $this->prepareRequest()->X_AVM_DE_GetExternalIPv6Address()['NewExternalIPv6Address'];
        } catch (\SoapFault $e) {
            throw new IPv6UnavailableException();
        }
    }

    /**
     * Retrieve the IPv6 address space prefix
     * @return array
     * @throws IPv6UnavailableException
     */
    public function getIPv6Prefix()
    {
        try {
            $response = $this->prepareRequest()->X_AVM_DE_GetIPv6Prefix();

            return [
                'prefix' => $response['NewIPv6Prefix'],
                'length' => $response['NewPrefixLength'],
            ];
        } catch (\SoapFault $e) {
            throw new IPv6UnavailableException();
        }
    }
}