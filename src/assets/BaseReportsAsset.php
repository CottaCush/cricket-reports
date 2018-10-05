<?php

namespace CottaCush\Cricket\Report\Assets;

use CottaCush\Yii2\Assets\AssetBundle;

/**
 * Class BaseAsset
 * Extend the CottaCush AssetBundle and set $basePath / $baseUrl properties
 * @author Olajide Oye <jide@cottacush.com>
 * @package app\assets
 */
class BaseReportsAsset extends AssetBundle
{
    /**
     * The main public assets directory.
     */
    const ASSETS_PATH = __DIR__ . '/../asset-files';
    /**
     * The public js asset directory
     */
    const ASSETS_JS_PATH = 'js';
    /**
     * The public css asset directory
     */
    const ASSETS_CSS_PATH = 'css';

    /**
     * Set the sourcePath as self::ASSETS_PATH by default.
     * @inheritdoc
     */
    public $sourcePath = self::ASSETS_PATH;
}
