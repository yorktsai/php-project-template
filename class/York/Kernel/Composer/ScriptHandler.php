<?php
namespace York\Kernel\Composer;

class ScriptHandler
{
    public static function buildBootstrap($event)
    {
        $currentDir = getcwd();

        $kernelRoot = dirname(__FILE__).'/../../../../';
        chdir($kernelRoot);

        // init
        passthru('bin/init.sh');

        // chdir back
        chdir($currentDir);
    }
}
