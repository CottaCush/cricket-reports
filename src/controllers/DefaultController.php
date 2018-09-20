<?php

namespace CottaCush\Cricket\Report\Controllers;

use CottaCush\Cricket\Report\Constants\ErrorCodes;
use CottaCush\Cricket\Report\Constants\Messages;
use CottaCush\Cricket\Report\Exceptions\SQLReportGenerationException;
use CottaCush\Cricket\Report\Generators\SQLQueryBuilderParser;
use CottaCush\Cricket\Report\Libs\Utils;
use CottaCush\Cricket\Report\Models\Report;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii2tech\csvgrid\CsvGrid;

class DefaultController extends BaseReportsController
{
    const SQL_QUERY_KEY = '_sql_query_';

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @return string
     */
    public function actionIndex()
    {
        $permissionValues = ArrayHelper::getValue($this->module, 'params.permissionValues', []);

        if (is_array($permissionValues)) {
            $permissionValues = array_filter($permissionValues, 'strlen');
        }

        $column = [];

        if (is_scalar($permissionValues)) {
            $permissionValues = [$permissionValues];
        }

        if (!empty($permissionValues)) {
            foreach ($permissionValues as $value) {
                $column[] = "FIND_IN_SET('" . $value . "', `permission_values`)";
            }

            $column = implode(' OR ', $column);
            $column = new Expression($column);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Report::getReports($column),
            'sort' => [
                'defaultOrder' => ['name' => SORT_DESC],
                'attributes' => ['name', 'description']
            ],
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);

        try {
            return $this->render('index', ['reports' => $dataProvider]);
        } catch (Exception $exception) {
            return $this->renderException($exception);
        }
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param null $id
     * @return string|\yii\web\Response
     */
    public function actionView($id = null)
    {
        $reportId = Utils::decodeId($id);

        /** @var Report $report */
        $report = Report::findOne($reportId);

        if (!$report) {
            return $this->returnNotification(
                self::FLASH_ERROR_KEY,
                Messages::getNotFoundMessage(Messages::ENTITY_REPORT)
            );
        }

        $data = [];
        $placeholderValues = $this->getRequest()->post();

        try {
            $parser = new SQLQueryBuilderParser();
            $parser->parse($report, $data, $placeholderValues);
        } catch (SQLReportGenerationException $ex) {
            return $this->render('error', ['report' => $report, 'details' => $ex->getMessage()]);
        }

        $this->getSession()->set(self::SQL_QUERY_KEY . $id, $parser->query);

        return $this->render('view', [
            'report' => $report, 'data' => $data, 'hasPlaceholders' => $parser->hasInputPlaceholders(), 'encodedId' => $id,
            'hasPlaceholdersReplaced' => $parser->arePlaceholdersReplaced(), 'values' => $placeholderValues,
        ]);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDownload($id)
    {
        $query = $this->getSession()->get(self::SQL_QUERY_KEY . $id, null);

        if (!$query) {
            return $this->returnNotification(
                self::FLASH_ERROR_KEY,
                'Please specify and process the report'
            );
        }

        try {
            $exporter = new CsvGrid([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => Yii::$app->db->createCommand($query)->queryAll()
                ]),
            ]);
            return $exporter->export()->send('reports.csv');
        } catch (\yii\db\Exception $e) {
            return $this->renderException($e);
        }
    }


    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param Exception $exception
     * @return string
     */
    private function renderException(Exception $exception)
    {
        $message = $exception->getMessage();
        $title = 'Reports';
        $icon = 'exclamation-triangle';

        if ($exception->getCode() == ErrorCodes::MYSQL_NO_DATABASE) {
            $message = 'Database not found';
            $title = null;
        } elseif ($exception->getCode() == ErrorCodes::MYSQL_NO_TABLE) {
            $message = 'You have no published reports';
            $icon = 'file-text';
        }

        return $this->render('exception', ['message' => $message, 'title' => $title, 'icon' => $icon]);
    }
}
