<?php
namespace York\Kernel\Thrift;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;

abstract class ThriftSocketClient
{
    abstract public function createClient($protocol);
    abstract public function getServerConfig();

    protected $transport;

    public function openTransport()
    {
        $serverConfig = $this->getServerConfig();

        $socket = new TSocket($serverConfig['host'], $serverConfig['port']);
        $socket->setSendTimeout(20000);
        $socket->setRecvTimeout(20000);
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
