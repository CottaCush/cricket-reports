<?php

namespace CottaCush\Cricket\Report;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Connection;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'CottaCush\Cricket\Report\Controllers';
    public $layout = 'main';

    /** @var Connection */
    public $db = null;

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (isset($this->db)) {
            Yii::$app->set('db', $this->db);
        }
    }
}
