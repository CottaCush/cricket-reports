<?php

use CottaCush\Yii2\Helpers\Html;
use CottaCush\Yii2\Widgets\EmptyStateWidget;

$this->title = $title;

$this->params['breadcrumbs'] = [];

echo '<h1>&nbsp;</h1>'.EmptyStateWidget::widget([
    'icon' => $icon,
    'description' => Html::tag('h3', $message)
]);
