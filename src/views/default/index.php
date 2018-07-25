<?php

use CottaCush\Cricket\Report\Models\Report;
use app\widgets\EmptyStateWidget;
use CottaCush\Yii2\Widgets\ActionButtons;
use CottaCush\Yii2\Widgets\GridViewWidget;
use yii\helpers\Url;

$this->title = ' Reports';
$this->params['breadcrumbs'] = [
    ['label' => 'Reports', 'url' => '/reports/default'],
    $this->title
];

if ($reports->getCount() == 0) :
    echo EmptyStateWidget::widget([
        'icon' => 'file-text',
        'description' => 'No reports have been created yet'
    ]);
else :
    echo GridViewWidget::widget([
        'dataProvider' => $reports,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'S/N'
            ],
            'name:text:Name',
            'description:text:Description',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'ACTION',
                'template' => '{actions}',
                'buttons' => [
                    'actions' => function ($url, Report $model, $key) {
                        $actions = [
                            [
                                'label' => 'View',
                                'url' => Url::toRoute(['view', 'id' => $model->getEncodedId()])
                            ]
                        ];
                        return ActionButtons::widget(['actions' => $actions]);
                    }
                ]
            ]
        ]
    ]);
endif;
