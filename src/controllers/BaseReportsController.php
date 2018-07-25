<?php

namespace CottaCush\Cricket\Report\Controllers;

use CottaCush\Yii2\Helpers\Html;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseReportsController extends Controller
{
    const FLASH_SUCCESS_KEY = 'success';
    const FLASH_ERROR_KEY = 'error';

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return \yii\console\Request|\yii\web\Request
     */
    public function getRequest()
    {
        return Yii::$app->request;
    }

    protected function getSession()
    {
        return Yii::$app->session;
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param $key
     * @param $messages
     * @param null $redirectUrl
     * @return Response
     */
    public function returnNotification($key, $messages, $redirectUrl = null)
    {
        $this->flash($key, $messages);

        if (is_null($redirectUrl)) {
            $redirectUrl = $this->getRequest()->getReferrer();
        }

        return $this->redirect($redirectUrl);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param $key
     * @param $messages
     */
    protected function flash($key, $messages)
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                Yii::$app->session->addFlash($key, $message);
            }
        } else {
            Yii::$app->session->setFlash($key, $messages);
        }
    }

    /**
     * Checks if the current request is a POST and handles redirection
     * @author Olawale Lawal <wale@cottacush.com>
     * @param null $redirectUrl
     * @return bool|mixed
     */
    public function isPost($redirectUrl = null)
    {
        if ($this->getRequest()->isPost) {
            return true;
        }
        if (is_null($redirectUrl)) {
            return false;
        }
        return $this->redirect($redirectUrl)->send();
    }


    /**
     * show flash messages
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param bool $sticky
     * @return string
     */
    public function showFlashMessages($sticky = false)
    {
        $timeout = $sticky ? 0 : 5000;
        $flashMessages = [];
        $allMessages = $this->getSession()->getAllFlashes();
        foreach ($allMessages as $key => $message) {
            $flashMessages[] = [
                'message' => $message,
                'type' => $key,
                'timeout' => $timeout
            ];
        }
        $this->getSession()->removeAllFlashes();
        return Html::script('var notifications =' . json_encode($flashMessages));
    }
}
