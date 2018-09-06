<?php

use CottaCush\Cricket\Report\Widgets\ReportTableWidget;
use CottaCush\Cricket\Report\Widgets\SQLReportFilterWidget;
use CottaCush\Yii2\Helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = ArrayHelper::getValue($report, 'name');

$this->params['breadcrumbs'] = [
    $report->name,
];

$excludeBootstrapAssets = isset($excludeBootstrapAssets);

$title = $this->title . ' ' .
    Html::tag(
        'span',
        null,
        [
            'class' => 'fa fa-question-circle', 'data-toggle' => 'tooltip', 'data-placement' => 'right',
            'title' => ArrayHelper::getValue($report, 'description')
        ]
    );

echo Html::beginTag('div', ['class' => 'reports-wrapper']);
if ($hasPlaceholders && !$hasPlaceholdersReplaced) {
    echo SQLReportFilterWidget::widget([
        'report' => $report,'excludeBootstrapAssets' => $excludeBootstrapAssets
    ]);
} else {
    echo ReportTableWidget::widget([
        'data' => $data, 'report' => $report, 'hasPlaceholders' => $hasPlaceholders, 'placeholderValues' => $values,
        'excludeBootstrapAssets' => $excludeBootstrapAssets
    ]);
}
echo Html::endTag('div');
