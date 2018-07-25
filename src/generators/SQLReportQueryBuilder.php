<?php

namespace CottaCush\Cricket\Report\Generators;

use CottaCush\Cricket\Report\Interfaces\Queryable;

/**
 * Class SQLReportQueryBuilder
 * @package CottaCush\Cricket\Report\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportQueryBuilder
{
    public $report;
    public $data;

    public function __construct(Queryable $report, array $data)
    {
        $this->report = $report;
        $this->data = $data;
    }

    public function buildQuery()
    {
        //TODO: Validate the query using the placeholders with the data sent
        $query = $this->report->getQuery();

        foreach ($this->data as $key => $value) {
            $query = str_replace($key, "'$value'", $query);
        }

        return $query;
    }
}
