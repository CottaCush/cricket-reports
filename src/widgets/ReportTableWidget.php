<?php

namespace CottaCush\Cricket\Report\Widgets;

use app\widgets\EmptyStateWidget;
use CottaCush\Cricket\Report\Interfaces\Queryable;
use CottaCush\Yii2\Helpers\Html;
use yii\helpers\Url;

/**
 * Class ReportTableWidget
 * @package CottaCush\Cricket\Report\Widgets
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class ReportTableWidget extends BaseReportsWidget
{
    /** @var Queryable */
    public $report;

    public $data = [];
    public $placeholderValues;
    public $tableClasses = 'table table-striped table-bordered';

    private $columnHeaders;
    public $emptyResultMsg = 'The query returned an empty data set';
    public $hasPlaceholders = false;

    private $hasResults;
    public $editFilterModalId = 'editFiltersModal';

    public function init()
    {
        $this->hasResults = (bool)count($this->data);
        parent::init();
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        $this->renderButtons();

        if (!$this->hasResults) {
            echo EmptyStateWidget::widget([
                'icon' => 'dropbox',
                'title' => $this->emptyResultMsg
            ]);
            return;
        }

        $this->columnHeaders = array_keys(current($this->data));

        echo $this->beginDiv('grid-view');

        echo $this->beginDiv('table-responsive');

        echo Html::beginTag('table', ['class' => $this->tableClasses]);
        $this->renderTableHeader();
        $this->renderTableBody();
        echo Html::endTag('table');

        echo $this->endDiv(); //.table-responsive
        echo $this->endDiv(); //.grid-view
    }

    private function renderTableHeader()
    {
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        foreach ($this->columnHeaders as $columnHeader) {
            echo Html::tag('th', str_replace('_', ' ', $columnHeader));
        }
        echo Html::endTag('tr');
        echo Html::endTag('thead');
    }

    private function renderTableBody()
    {
        echo Html::beginTag('tbody');
        foreach ($this->data as $row) {
            echo Html::beginTag('tr');
            foreach ($row as $cell) {
                echo Html::tag('td', $cell);
            }
            echo Html::endTag('tr');
        }
        echo Html::endTag('tbody');
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @throws \Exception
     */
    public function renderButtons()
    {
        echo $this->beginDiv('row form-group');
        echo $this->beginDiv('col-sm-6 col-xs-12 col-sm-offset-6 text-right');
        echo Html::a(
            Html::baseIcon('fa fa-edit') . ' Edit Filters',
            null,
            [
                'class' => 'btn btn-sm content-header-btn btn-primary',
                'data' => [
                    'toggle' => 'modal', 'target' => '#' . $this->editFilterModalId,
                ]
            ]
        );
        echo '&nbsp;';
        if ($this->hasResults) {
            echo Html::a(
                Html::baseIcon('fa fa-download') . ' Download CSV',
                Url::toRoute('download'),
                [
                    'class' => 'btn btn-sm content-header-btn btn-primary',
                    'data' => []
                ]
            );
        }
        echo $this->endDiv();
        echo $this->endDiv();

        echo SQLReportFilterModalWidget::widget([
            'id' => $this->editFilterModalId, 'model' => $this->report, 'data' => $this->placeholderValues,
            'route' => Url::current()
        ]);
    }
}
