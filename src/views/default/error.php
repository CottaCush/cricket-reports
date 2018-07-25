<?php

use CottaCush\Cricket\Report\Widgets\ReportErrorWidget;

$this->title = "Reports Error";

$this->params['breadcrumbs'] = [
    $report->name,
    'Error'
];

echo ReportErrorWidget::widget([
    'report' => $report,
    'details' => $details,
    'executedQuery' => $query
]);
