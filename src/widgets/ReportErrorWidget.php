<?php

namespace CottaCush\Cricket\Report\Widgets;

use CottaCush\Yii2\Assets\FontAwesomeAsset;
use CottaCush\Yii2\Helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class ReportErrorWidget
 * @package CottaCush\Cricket\Report\Widgets
 * @author Olawale Lawal <wale@cottacush.com>
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class ReportErrorWidget extends BaseReportsWidget
{
    public $icon = 'frown-o';
    public $title = 'The report you requested could not be generated. See the executed query below:';
    public $details;
    public $report;
    public $executedQuery;
    public $canEditQuery = false;
    public $showTechnicalDetails = false;

    public function init()
    {
        FontAwesomeAsset::register($this->view);
        parent::init();
    }

    public function run()
    {
        echo Html::beginTag('section', ['class' => 'report-error']);

        echo Html::faIcon($this->icon, ['class' => 'report-error__icon']);
        echo Html::tag('h2', $this->title, ['class' => 'report-error__title']);

        $this->renderTechnicalDetails();
        $this->renderQueryEditorLink();

        echo Html::endTag('section');
    }

    private function renderTechnicalDetails()
    {
        if (!$this->showTechnicalDetails) {
            return;
        }

        echo $this->beginDiv('report-error__technical-details');
        echo Html::tag(
            'p',
            $this->executedQuery,
            ['class' => 'report-error__technical-details-query']
        );
        echo Html::tag('p', 'Technical Details', ['class' => 'report-error__technical-details-title']);
        echo Html::tag('p', $this->details, ['class' => 'report-error__technical-details-error']);
        echo $this->endDiv();
    }

    private function renderQueryEditorLink()
    {
        if ($this->canEditQuery) {
            return;
        }

        echo Html::a(
            'Edit Reports',
            Url::toRoute(['/report/edit/', 'id' => ArrayHelper::getValue($this->report, 'id')]),
            ['class' => 'btn btn-primary']
        );
    }
}
