<?php
namespace York\Kernel\Thrift;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;

abstract class ThriftHttpClient
{
    abstract public function createClient($protocol);
    abstract public function getServerConfig();

    protected $transport;

    public function openTransport()
    {
        $serverConfig = $this->getServerConfig();

        $socket = new THttpClient($serverConfig['host'], $serverConfig['port'], $serverConfig['path']);
        $this->transport = new TBufferedTransport($socket, 1024, 1024);
        $protocol = new TBinaryProtocol($this->transport);
        $client = $this->createClient($protocol);

        $this->transport->open();

        return $client;
    }

    public function closeTransport()
    {
        try {
            $this->transport->close();
        } catch (\Exception $e) {
            ;
        }
    }
}
