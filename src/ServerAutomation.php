<?php

namespace JLaso\Ssh2;

/**
 * Class ServerAutomation
 * @package JLaso\Ssh2
 * @author Joseluis Laso <jlaso@joseluislaso.es>
 */

class ServerAutomation
{
    const AUTH_PASSWORD = 'password';
    const AUTH_SSH_KEY = 'ssh-key';

    protected $session = null;

    /**
     * @param $server
     * @param $port
     * @param array $options
     * @throws \Exception
     */
    function __construct($server, $port, $options = array())
    {
        $options = array_merge(
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
                    ssh2_auth_password($this->session, $options['user'], $options['password']);
                    break;

                case self::AUTH_SSH_KEY:
                    ssh2_auth_pubkey_file($this->session, $options['user'], $options['ssh-key'].'.pub', $options['ssh-key']);
                    break;

                default:
                    throw new \Exception(sprintf('"%s" not recognized as an auth mode for ssh2', $options['auth']));
            }
        }
    }

    /**
     * @param $command
     * @return string
     * @throws \Exception
     */
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