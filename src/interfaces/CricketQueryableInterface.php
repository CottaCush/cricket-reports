<?php

namespace CottaCush\Cricket\Report\Interfaces;

/**
 * Interface CricketQueryableInterface
 * @package CottaCush\Cricket\Report\Interfaces
 */
interface CricketQueryableInterface
{
    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return QueryInterface
     */
    public function getQuery();
}
