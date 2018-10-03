<?php

namespace CottaCush\Cricket\Report\Assets;

/**
 * Class SQLReportFilterFormAsset
 * @package CottaCush\Cricket\Report\Assets
 * @author Olawale Lawal <wale@cottacush.com>
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 */
class SQLReportFilterFormAsset extends BaseReportsAsset
{
    public $js = [
        self::ASSETS_JS_PATH . '/widgets/report-filter-form.js',
    ];

    public $depends = [
        'CottaCush\Cricket\Report\Assets\ReportsAsset',
        'CottaCush\Cricket\Assets\DatePickerAsset',
        'CottaCush\Cricket\Assets\BootstrapValidatorAsset',
    ];
}
