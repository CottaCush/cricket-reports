<?php

namespace CottaCush\Cricket\Report\Interfaces;

use yii\db\ActiveQueryInterface;

/**
 * Interface PlaceholderInterface
 * @package CottaCush\Cricket\Report\Interfaces
 */
interface PlaceholderInterface
{
    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string
     */
    public function getName();

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string
     */
    public function getType();

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string
     */
    public function getDescription();

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return QueryInterface
     */
    public function getDropdownQuery();
}
