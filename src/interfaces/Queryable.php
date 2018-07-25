<?php

namespace CottaCush\Cricket\Report\Interfaces;

/**
 * Interface Queryable
 * @package CottaCush\Cricket\Report\Interfaces
 */
interface Queryable
{
    public function getQuery();
    public function getPlaceholders();
}
