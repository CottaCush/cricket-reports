<?php

namespace CottaCush\Cricket\Report\Generators;

use CottaCush\Cricket\Report\Models\PlaceholderType;
use CottaCush\Cricket\Report\Interfaces\Replaceable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class SQLReportFilterFactory
 * @package CottaCush\Cricket\Report\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportFilterFactory
{
    public $placeholder;

    public function __construct(Replaceable $placeholder = null)
    {
        $this->placeholder = $placeholder;
    }

    public function createWidget($value = null)
    {
        $name = ArrayHelper::getValue($this->placeholder, 'name');
        $type = ArrayHelper::getValue($this->placeholder, 'placeholder_type');
        $description = ArrayHelper::getValue($this->placeholder, 'description');

        switch ($type) {
            case PlaceholderType::TYPE_BOOLEAN:
                return Html::tag('label', $description, ['class' => 'control-label']) .
                    Html::radioList($name, $value, PlaceholderType::BOOLEAN_VALUES_MAP);
                break;

            case PlaceholderType::TYPE_DATE:
                return Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput($name, $value, ['class' => 'form-control date-picker']);
                break;

            default:
                return Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput($name, $value, ['class' => 'form-control']);
                break;
        }
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param Replaceable $placeholder
     */
    public function setPlaceholder(Replaceable $placeholder)
    {
        $this->placeholder = $placeholder;
    }
}
