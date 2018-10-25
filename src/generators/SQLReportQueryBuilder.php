<?php

namespace CottaCush\Cricket\Report\Generators;

use CottaCush\Cricket\Interfaces\QueryInterface;

/**
 * Class SQLReportQueryBuilder
 * @package CottaCush\Cricket\Report\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportQueryBuilder
{
    public $query;
    public $data;

    public function __construct(QueryInterface $query, array $data)
    {
        $this->query = $query;
        $this->data = $data;
    }

    public function buildQuery()
    {
        //TODO: Validate the query using the placeholders with the data sent
        $query = $this->query->getQuery();

        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                $value = "'" . implode("', '", $value) . "'";
            }
            $query = str_replace($key, $value, $query);
        }
        return $query;
    }
}
