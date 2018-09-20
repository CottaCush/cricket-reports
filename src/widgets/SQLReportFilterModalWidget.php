<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Cricket\Report\Interfaces\QueryInterface;
use CottaCush\Yii2\Widgets\BaseModalWidget;

/**
 * Class SQLReportFilterModalWidget
 * @package CottaCush\Cricket\Report\Widgets
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportFilterModalWidget extends BaseModalWidget
{
    public $title = 'Edit Filters';
    public $footerSubmit = 'Apply Filters';
    public $formMethod = 'post';
    public $formOptions = ['data-toggle' => 'validator'];

    /** @var QueryInterface */
    public $model;
    public $data;
    public $database;

    public $excludeBootstrapAssets = false;

    public function renderContents()
    {
        echo SQLReportFilterWidget::widget([
            'report' => $this->model, 'data' => $this->data, 'isModal' => true, 'database' => $this->database,
            'excludeBootstrapAssets' => $this->excludeBootstrapAssets
        ]);
        parent::renderContents();
    }
}
