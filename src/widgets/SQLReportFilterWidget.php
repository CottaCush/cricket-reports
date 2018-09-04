<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Cricket\Report\Assets\SQLReportFilterFormAsset;
use CottaCush\Cricket\Report\Generators\SQLReportFilterFactory;
use CottaCush\Cricket\Report\Interfaces\Queryable;
use CottaCush\Cricket\Report\Interfaces\Replaceable;
use CottaCush\Yii2\Helpers\Html;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class SQLReportFilterWidget
 * @package app\widgets
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class SQLReportFilterWidget extends BaseReportsWidget
{
    public $data;

    /** @var Queryable */
    public $report;

    public $title = 'Apply Filters';
    public $btnText = 'Generate Reports';
    public $btnClass = 'btn btn-md btn-primary';
    public $formRoute;
    public $isModal = false;
    public $database = null;

    public function run()
    {
        SQLReportFilterFormAsset::register($this->view);

        $this->renderHeader();
        $this->renderPlaceholderFields();
        $this->renderFooter();
    }

    public function renderContents()
    {
        echo Html::beginTag('div', ['class' => 'sql-filter-form']);
        $this->renderPlaceholderFields();
        echo Html::endTag('div');
    }

    private function renderHeader()
    {
        if ($this->isModal) {
            return;
        }

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        echo Html::tag('h3', $this->title);
        echo Html::tag('br');
        echo Html::beginForm($this->formRoute, 'post', ['class' => 'sql-filter-form']);
    }

    private function renderPlaceholderFields()
    {
        $placeholders = $this->report->getPlaceholders();

        if ($placeholders instanceof ActiveQuery) {
            $placeholders = $placeholders->all();
        }

        if (!count($placeholders)) {
            return;
        }

        $factory = new SQLReportFilterFactory(null, $this->database);
        /** @var Replaceable $placeholder */
        echo $this->beginDiv('row');
        foreach ($placeholders as $placeholder) {
            $factory->setPlaceholder($placeholder);

            echo $factory->createWidget(ArrayHelper::getValue($this->data, $placeholder->getName()));
        }
        echo $this->endDiv();
    }

    private function renderFooter()
    {
        if ($this->isModal) {
            return;
        }

        echo Html::submitButton($this->btnText, ['class' => $this->btnClass]);
        echo Html::endForm();
        echo $this->endDiv();
    }
}
