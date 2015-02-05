<?php

define('LOGS_DIR', __DIR__.'/logs');

if(!file_exists(LOGS_DIR))
{
    mkdir(LOGS_DIR);
}

$date = date("Y_m_d_h_i_s");

$servers = parse_ini_file('servers.ini', true);
//var_dump($servers); die;

$commands = parse_ini_file('commands.ini', true);
//var_dump($commands); die;

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

    $session = ssh2_connect($server['ip'], $server['port']);

    if($server['auth'] == "password"){
        ssh2_auth_password($session, $server['user'], $server['password']);
    }

    foreach($commands as $cmdName=>$command){
        $result = _exec($session, $command['command']);
        print("$cmdName \n $result \n\n");
        $log .= "$cmdName \n $result \n\n";
    }

    file_put_contents(LOGS_DIR . sprintf("/%s_%s.log", $date, $serverName), $log);

}


