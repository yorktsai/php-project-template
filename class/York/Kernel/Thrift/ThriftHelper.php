<?php
namespace York\Kernel\Thrift;

use York\Thrift\Commons\TRuntimeException;

use Thrift\Exception\TException;

class ThriftHelper
{
    public static function throwTRuntimeException(\Exception $e, $code)
    {
        if ($e instanceof TException) {
            throw $e;
        }

        $exception = new TRuntimeException();
        $exception->code = $code;
        $exception->message = $e->getMessage();
        throw $exception;
    }
}
