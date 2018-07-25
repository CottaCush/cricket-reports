<?php

namespace CottaCush\Cricket\Report\Assets;

/**
 * Class SQLReportFilterFormReportsAsset
 * @package app\modules\reports\assets
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class SQLReportFilterFormReportsAsset extends BaseReportsAsset
{
    public $js = [
        'widgets/report-filter-form.js'
    ];

    public $depends = [
        'app\modules\reports\assets\DatePickerAsset',
    ];
}
