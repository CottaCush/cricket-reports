<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Cricket\Report\Interfaces\Queryable;
use CottaCush\Cricket\Report\Libs\Utils;
use CottaCush\Yii2\Helpers\Html;
use CottaCush\Yii2\Widgets\EmptyStateWidget;
use yii\helpers\ArrayHelper;
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

    public $emptyResultMsg = 'The query returned an empty data set';
    private $noOfRecords;

    private $columnHeaders;

    public $hasPlaceholders = false;
    private $hasResults;
    public $editFilterModalId = 'editFiltersModal';
    public $downloadLink = '/reports/download';

    public function init()
    {
        $this->noOfRecords = count($this->data);
        $this->hasResults = (bool)$this->noOfRecords;

        parent::init();
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        $this->renderHeader();

        if (!$this->hasResults) {
            echo EmptyStateWidget::widget([
                'icon' => 'dropbox',
                'title' => $this->emptyResultMsg
            ]);
            return;
        }

        $this->renderTable();
    }

    private function renderTable()
    {
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


    private function renderHeader()
    {
        echo $this->beginDiv('row form-group');

        $this->renderResultCount();
        $this->renderButtons();

        echo $this->endDiv();
    }

    private function renderResultCount()
    {
        echo $this->beginDiv('col-sm-6 col-xs-12');

        echo Html::tag(
            'b',
            $this->noOfRecords . ' record' . ($this->noOfRecords == 1 ? '' : 's') . ' returned'
        );

        echo $this->endDiv();
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     */
    public function renderButtons()
    {
        echo $this->beginDiv('col-sm-6 col-xs-12 text-right');

        if ($this->hasPlaceholders) {
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
        }

        if ($this->hasResults) {
            $id = ArrayHelper::getValue($this->report, 'id');
            $id = Utils::encodeId($id);

            echo Html::a(
                Html::baseIcon('fa fa-download') . ' Download CSV',
                Url::toRoute([$this->downloadLink, 'id' => $id]),
                [
                    'class' => 'btn btn-sm content-header-btn btn-primary',
                    'data' => []
                ]
            );
        }

        echo $this->endDiv();

        try {
            echo SQLReportFilterModalWidget::widget([
                'id' => $this->editFilterModalId, 'model' => $this->report, 'data' => $this->placeholderValues,
                'route' => Url::current()
            ]);
        } catch (\Exception $e) {
        }
    }
}
