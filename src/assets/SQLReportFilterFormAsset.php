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
        'widgets/report-filter-form.js'
    ];

    public $depends = [
        'CottaCush\Cricket\Report\Assets\DatePickerAsset',
    ];
}
