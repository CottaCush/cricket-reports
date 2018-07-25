<?php
namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Yii2\Helpers\Html;
use CottaCush\Yii2\Widgets\BaseWidget as Yii2BaseWidget;

/**
 * Class BaseReportsWidget
 * @package CottaCush\Cricket\Report\Widgets
 * @author Olawale Lawal <wale@cottacush.com>
 */
class BaseReportsWidget extends Yii2BaseWidget
{
    /**
     * @param array|string $classNames
     * @param array $options
     * @return string
     */
    protected function beginDiv($classNames = [], $options = [])
    {
        Html::addCssClass($options, $classNames);
        return Html::beginTag('div', $options) . "\n";
    }

    /**
     * @return string
     */
    protected function endDiv()
    {
        return Html::endTag('div') . "\n";
    }
}
