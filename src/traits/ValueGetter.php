<?php

namespace CottaCush\Cricket\Report\Traits;

use yii\helpers\ArrayHelper;

trait ValueGetter
{
    public function getSessionVariable($description)
    {
        $temp = explode('.', $description);
        $session = \Yii::$app->session;

        if (count($temp) == 1) {
            return $session->get($description, null);
        }

        $session = \Yii::$app->session->get($temp[0]);
        unset($temp[0]);

        $description = implode('.', $temp);
        if (unserialize($session)) {
            $session = unserialize($session);
        }
        return ArrayHelper::getValue($session, $description);
    }
}
