<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Cricket\Interfaces\CricketQueryableInterface;
use CottaCush\Cricket\Report\Libs\Utils;
use CottaCush\Cricket\Report\Models\Report;
use CottaCush\Yii2\Helpers\Html;
use CottaCush\Yii2\Widgets\EmptyStateWidget;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * Class ReportTableWidget
 * @package CottaCush\Cricket\Report\Widgets
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class ReportTableWidget extends BaseReportsWidget
{
    /** @var CricketQueryableInterface */
    public $report;

    public $data = [];
    public $placeholderValues;
    public $tableClasses = 'table table-striped table-bordered';

    public $emptyResultMsg = 'The query returned an empty data set';
    public $count;
    public $page = null;

    public $hasPlaceholders = false;
    private $hasResults;
    public $editFilterModalId = 'editFiltersModal';
    public $downloadLink = '/reports/download';
    public $canDownload = true;
    public $database = null;

    public $excludeBootstrapAssets = false;

    public function init()
    {
        $this->hasResults = (bool)$this->count;

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
        $this->renderPagination();
    }

    private function renderTable()
    {

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
        $columnHeaders = array_keys(current($this->data));
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        foreach ($columnHeaders as $columnHeader) {
            echo Html::tag('th', strtoupper(str_replace('_', ' ', $columnHeader)));
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
            $this->getDataCountInfo()
        );

        echo $this->endDiv();
    }

    private function getDataCountInfo()
    {
        $limit = Report::PAGE_LIMIT;
        $msgTemplate = 'Showing %s &ndash; %s of %s items';
        $msg = sprintf($msgTemplate, 1, $this->count, $this->count);
        if ($this->count > $limit) {
            if ($this->page) {
                $start = ($this->page - 1) * $limit + 1;
                $end = ($this->page * $limit);
                $pageTotal = ($end <= $this->count) ? $end : $this->count;
                $msg = sprintf($msgTemplate, $start, $pageTotal, $this->count);
            }
        }
        return $msg;
    }

    private function renderPagination()
    {
        echo LinkPager::widget([
            'pagination' => new Pagination([
                'totalCount' => $this->count,
                'pageSize' => Report::PAGE_LIMIT
            ])
        ]);
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

        if ($this->hasResults && $this->canDownload) {
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

        if ($this->hasPlaceholders) {
            echo SQLReportFilterModalWidget::widget([
                'id' => $this->editFilterModalId, 'model' => $this->report, 'data' => $this->placeholderValues,
                'route' => Url::current(['page' => null]), 'database' => $this->database,
                'excludeBootstrapAssets' => $this->excludeBootstrapAssets
            ]);
        }
    }
}
