<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Cricket\Report\Interfaces\Queryable;
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

    /** @var Queryable */
    public $model;
    public $data;

    public function renderContents()
    {
        echo SQLReportFilterWidget::widget(['report' => $this->model, 'data' => $this->data, 'isModal' => true]);
        parent::renderContents();
    }
}
