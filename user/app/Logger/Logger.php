<?php
/**
 * Created by PhpStorm.
 * User: michaelhu
 * Date: 2019/1/15
 * Time: 4:07 PM
 */


namespace App\Logger;

trait Logger
{
    //
    protected $m_remoteIP = null;

    protected $m_requestMethod = null;
    protected $m_uri = null;
    protected $m_fullURL = null;

    private $m_remoteDriver = "daily";


    /**
     * SCLogger constructor.
     */
    public function __construct()
    {

        $this->m_requestMethod = \Request::method();
        $this->m_uri = \Request::header('method');
        $this->m_fullURL = \Request::fullUrl();
        $this->m_remoteIP = $_SERVER['REMOTE_ADDR'] ?? null;


    }

    public function logLocal($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getLogData($arrayData);

        \Log::$action($message, $data);

    }

    public function logRemote($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getLogData($arrayData);

        \Log::channel($this->m_remoteDriver)->$action($message, $data);

    }

    public function logAll($action = 'info', $message, $arrayData = null)
    {

        $data = $this->getLogData($arrayData);
        \Log::$action($message, $data);
        \Log::channel($this->m_remoteDriver)->$action($message, $data);

    }

    private function getLogData($arrayData)
    {

        $data = [
            'ip' => $this->m_remoteIP,
            'method' => $this->m_requestMethod,
            'uri' => $this->m_uri,
            'data' => $arrayData,
        ];

        return $data;

    }

}
