<?php

namespace CottaCush\Cricket\Report\Assets;

/**
 * Class ReportsAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Report\Assets
 */
class ReportsAsset extends BaseReportsAsset
{
    public $css = [
        'css/styles.css'
    ];

    public $depends = [
        'CottaCush\Cricket\Assets\CricketAsset'
    ];
}
