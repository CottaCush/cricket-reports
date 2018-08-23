<?php

namespace CottaCush\Cricket\Report\Generators;

use CottaCush\Cricket\Report\Exceptions\SQLReportGenerationException;
use CottaCush\Cricket\Report\Interfaces\Queryable;
use CottaCush\Cricket\Report\Interfaces\Replaceable;
use CottaCush\Cricket\Report\Models\PlaceholderType;
use CottaCush\Cricket\Report\Traits\ValueGetter;
use kartik\select2\Select2;
use yii\db\ActiveQuery;
use yii\db\Connection;
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
    use ValueGetter;

    public $placeholder;
    public $database;

    public function __construct(Replaceable $placeholder = null, Connection $database = null)
    {
        $this->database = $database;
        $this->placeholder = $placeholder;
    }

    public function createWidget($value = null)
    {
        $name = ArrayHelper::getValue($this->placeholder, 'name');
        $type = ArrayHelper::getValue($this->placeholder, 'placeholder_type');
        $description = ArrayHelper::getValue($this->placeholder, 'description');

        switch ($type) {
            case PlaceholderType::TYPE_BOOLEAN:
                return Html::beginTag('div', ['class' => 'form-group col-sm-6']) .
                    Html::tag('label', $description, ['class' => 'control-label']) .
                    Html::radioList($name, $value, PlaceholderType::BOOLEAN_VALUES_MAP) .
                    Html::endTag('div');
                break;

            case PlaceholderType::TYPE_DATE:
                return Html::beginTag('div', ['class' => 'form-group col-sm-6']) .
                    Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput($name, $value, ['class' => 'form-control date-picker']) .
                    Html::endTag('div');
                break;

            case PlaceholderType::TYPE_SESSION:
                return Html::hiddenInput($name, $this->getSessionVariable($description));
                break;

            case PlaceholderType::TYPE_DROPDOWN:
                try {
                    return $this->generateDropdown($value);
                } catch (SQLReportGenerationException $e) {
                }
                break;

            default:
                return Html::beginTag('div', ['class' => 'form-group col-sm-6']) .
                    Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput($name, $value, ['class' => 'form-control']) .
                    Html::endTag('div');
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

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string
     * @throws \CottaCush\Cricket\Report\Exceptions\SQLReportGenerationException
     */
    private function generateDropdown($value = null)
    {
        /** @var Queryable $report */
        $report = $this->placeholder->getDropdownReport()->one();
        $html = '';

        if (!$report) {
            return $html;
        }

        $placeholders = $report->getPlaceholders();

        if ($placeholders instanceof ActiveQuery) {
            $placeholders = $placeholders->asArray()->all();
        }

        $data = [];
        foreach ($placeholders as $placeholder) {
            $data[$placeholder['name']] = $this->getSessionVariable($placeholder['description']);
        }

        $queryBuilder = new SQLReportQueryBuilder($report, $data);
        $generator = new SQLReportGenerator($queryBuilder->buildQuery(), $this->database);
        $data = $generator->generateReport();

        if (count($data)) {
            $data = ArrayHelper::map($data, 'key', 'value');
        }

        $html .= Html::beginTag('div', ['class' => 'form-group col-sm-6']) .
            Html::label($report->name, $this->placeholder->getName(), ['class' => 'control-label']) .
            Select2::widget([
                'name' => $this->placeholder->getName(),
                'value' => $value,
                'data' => $data,
                'options' => ['multiple' => true, 'placeholder' => 'Select ' . $report->name]
            ]) .
            Html::endTag('div');
        return $html;
    }
}
