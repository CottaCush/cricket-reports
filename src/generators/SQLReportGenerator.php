<?php

namespace CottaCush\Cricket\Report\Generators;

use CottaCush\Cricket\Report\Exceptions\SQLReportGenerationException;
use CottaCush\Cricket\Report\Interfaces\ReportGeneratorInterface;
use Exception;
use Yii;
use yii\db\Connection;

/**
 * Class SQLReportGenerator
 * @package CottaCush\Cricket\Report\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportGenerator implements ReportGeneratorInterface
{
    private $query;
    private $db;

    private $isFreshConnection = false;

    const QUERY_ALL = 'queryAll';
    const QUERY_ONE = 'queryOne';
    const QUERY_COLUMN = 'queryColumn';

    public function __construct($query, Connection $db = null)
    {
        $this->query = $query;
        $this->db = $db;

        if (is_null($db)) {
            $this->db = Yii::$app->db;
        }
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param string $function
     * @return array
     * @throws SQLReportGenerationException
     */
    public function generateReport($function = self::QUERY_ALL)
    {
        try {
            $this->openConnection();
            $result = $this->db->createCommand($this->query)->{$function}();
            $this->closeConnection();
        } catch (Exception $e) {
            throw new SQLReportGenerationException($e->getMessage());
        }
        return $result;
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @throws \yii\db\Exception
     */
    private function openConnection()
    {
        if (is_null($this->db) || !$this->db->isActive) {
            $this->isFreshConnection = true;
            $this->db->open();
        }
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     */
    private function closeConnection()
    {
        if (!$this->isFreshConnection) {
            $this->db->close();
        }
    }
}
