<?php


namespace JLaso\Ssh2;

class ServerAutomation
{
    const AUTH_PASSWORD = 'password';
    const AUTH_SSH_KEY = 'ssh-key';

    protected $session = null;
    
    function __construct($server, $port, $options = array())
    {
        $options = array_combine(
            array(
                'auth' => '',
                'user' => '',
                'password' => '',
                'ssh-key' => '',
            ),
            $options
        );
        $this->session = ssh2_connect($server, $port);
        if($this->session){
            switch($options['auth']){
                case self::AUTH_PASSWORD:
                    break;

                case self::AUTH_SSH_KEY:
                    break;

                default:
                    throw new \Exception(sprintf('"%s" not recognized as an auth mode for ssh2', $options['auth']);
            }
        }
    }
    
    function exec($command)
    {
        if(!$this->session){
            throw new \Exception('SSH session not started');
        }
        if (!($stream = ssh2_exec($this->session, $command))) {
            throw new \Exception('SSH command failed');
        }
        stream_set_blocking($stream, true);
        $result = "";
        while ($buf = fread($stream, 4096)) {
            $result .= $buf;
        }
        fclose($stream);
        
        return $result;
    }

}