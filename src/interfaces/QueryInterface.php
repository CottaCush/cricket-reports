<?php

namespace CottaCush\Cricket\Report\Interfaces;

/**
 * Interface QueryInterface
 * @package CottaCush\Cricket\Report\Interfaces
 */
interface QueryInterface
{
    public function getQuery();

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return PlaceholderInterface[]
     */
    public function getPlaceholders();

    public function getInputPlaceholders();

    public function getSessionPlaceholders();

    public function hasInputPlaceholders();

    public function getPlaceholderQueries();

    public function getDropdownPlaceholders();
}
