<?php

use CottaCush\Yii2\Helpers\Html;
use CottaCush\Yii2\Widgets\EmptyStateWidget;

$this->title = $title;

$this->params['breadcrumbs'] = [];

echo Html::beginTag('div', ['class' => 'reports-wrapper']);
echo '<h1>&nbsp;</h1>'.EmptyStateWidget::widget([
    'icon' => $icon,
    'description' => Html::tag('h3', $message)
]);
echo Html::endTag('div');
