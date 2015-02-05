<?php

define('LOGS_DIR', __DIR__.'/logs');

require_once "vendor/autoload.php";

use JLaso\Ssh2\ServerAutomation;

if(!file_exists(LOGS_DIR))
{
    mkdir(LOGS_DIR);
}

$date = date("Y_m_d_h_i_s");

$servers = parse_ini_file('servers.ini', true);
$commands = parse_ini_file('commands.ini', true);

function _exec($session, $cmd) {
    if (!($stream = ssh2_exec($session, $cmd))) {
        throw new Exception('SSH command failed');
    }
    stream_set_blocking($stream, true);
    $data = "";
    while ($buf = fread($stream, 4096)) {
        $data .= $buf;
    }
    fclose($stream);
    return $data;
}

foreach($servers as $serverName => $server){

    print "processing server $serverName \n";
    $log = '';

    $automation = new ServerAutomation($server['ip'], $server['port'], $server);

    foreach($commands as $cmdName=>$command){
        $result = $automation->exec($command['command']);
        print("$cmdName \n $result \n\n");
        $log .= "$cmdName \n $result \n\n";
    }

    file_put_contents(LOGS_DIR . sprintf("/%s_%s.log", $date, $serverName), $log);

}


