<?php

use CottaCush\Cricket\Report\Widgets\ReportErrorWidget;
use yii\helpers\Html;

$this->title = "Reports Error";

$this->params['breadcrumbs'] = [
    $report->name,
    'Error'
];

echo Html::beginTag('div', ['class' => 'reports-wrapper']);
echo ReportErrorWidget::widget([
    'report' => $report,
    'details' => $details,
    'executedQuery' => $query
]);
echo Html::endTag('div');
