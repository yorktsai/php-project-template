<?php
namespace York\Kernel\Thrift;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;

class ThriftHttpServer
{
    public static function process($processor)
    {
        // send header
        header('Content-Type', 'application/x-thrift');

        // process
        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new TBinaryProtocol($transport, true, true);

        $transport->open();
        $processor->process($protocol, $protocol);
        $transport->close();
    }
}
