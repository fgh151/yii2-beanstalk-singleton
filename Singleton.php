<?php
namespace fgh151\beanstalk;

use yii\base\Module;

/**
 * Class Singleton
 * @package fgh151\beanstalk
 */
trait Singleton
{
    private $LockFile;
    public function __construct($id, Module $module, $config = [])
    {
        if(stripos($_SERVER['argv'][1], 'halt')) {
            \Yii::$app->beanstalk
                ->putInTube('halt', []);
            die;
        }
        $this->LockFile = $_SERVER['PWD'].'/queue.lock';
        if (file_exists($this->LockFile)) {
            $pid = file_get_contents($this->LockFile);
            if (file_exists( '/proc/'.$pid )) {
                die;
            }
        }

        $fd = fopen($this->LockFile, 'w');
        fwrite($fd, getmypid());
        fclose($fd);
        parent::__construct($id, $module, $config);
    }

    public function __destruct()
    {
        if (file_exists($this->LockFile)) {
            unlink($this->LockFile);
        }
        parent::__destruct();
    }

    /**
     * Проверка статуса запущен / не запущен
     */
    public function actionStatus()
    {
        if (file_exists($this->LockFile)) {
            $pid = file_get_contents($this->LockFile);
            if (file_exists( '/proc/'.$pid )) {
                echo 'Active, pid: '.$pid."\n";
            } else {
                echo 'Not Active'."\n";
            }
        } else {
            echo 'Not Active'."\n";
        }
        $this->end();
    }

    /**
     * Остановка выполнения
     */
    public function actionHalt()
    {
        $this->terminate();
    }
}