<?php

namespace CottaCush\Cricket\Report\Controllers;

use CottaCush\Cricket\Report\Constants\Messages;
use CottaCush\Cricket\Report\Exceptions\SQLReportGenerationException;
use CottaCush\Cricket\Report\Generators\SQLReportGenerator;
use CottaCush\Cricket\Report\Generators\SQLReportQueryBuilder;
use CottaCush\Cricket\Report\Libs\Utils;
use CottaCush\Cricket\Report\Models\Report;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii2tech\csvgrid\CsvGrid;

class DefaultController extends BaseReportsController
{
    const SQL_QUERY_KEY = 'SQL_QUERY';

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Report::getReports(),
            'sort' => [
                'defaultOrder' => ['name' => SORT_DESC],
                'attributes' => ['name', 'description']
            ],
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);


        return $this->render('index', ['reports' => $dataProvider]);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param null $id
     * @return string|\yii\web\Response
     */
    public function actionView($id = null)
    {
        $id = Utils::decodeId($id);

        /** @var Report $report */
        $report = Report::findOne($id);

        if (!$report) {
            return $this->returnNotification(
                self::FLASH_ERROR_KEY,
                Messages::getNotFoundMessage(Messages::ENTITY_REPORT)
            );
        }
        $hasPlaceholders = $report->getPlaceholders()->exists();
        $hasPlaceholdersReplaced = false;
        $data = [];
        $values = $this->getRequest()->post();
        $query = $report->query;

        if ($this->isPost()) {
            try {
                $queryBuilder = new SQLReportQueryBuilder($report, $values);
                $query = $queryBuilder->buildQuery();

                $generator = new SQLReportGenerator($query);
                $data = $generator->generateReport();

                $hasPlaceholdersReplaced = true;
            } catch (SQLReportGenerationException $ex) {
                return $this->render(
                    'error',
                    ['report' => $report, 'details' => $ex->getMessage(), 'query' => $query]
                );
            }
        } else {
            if (!$hasPlaceholders) {
                try {
                    $generator = new SQLReportGenerator($query);
                    $data = $generator->generateReport();
                } catch (SQLReportGenerationException $ex) {
                    return $this->render(
                        'error',
                        ['report' => $report, 'details' => $ex->getMessage(), 'query' => $query]
                    );
                }
            }
        }

        Yii::$app->session->set(self::SQL_QUERY_KEY, $query);

        return $this->render('view', [
            'report' => $report, 'data' => $data, 'hasPlaceholders' => $hasPlaceholders,
            'hasPlaceholdersReplaced' => $hasPlaceholdersReplaced, 'values' => $values
        ]);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDownload()
    {
        $query = $this->getSession()->get(self::SQL_QUERY_KEY);

        if (!$query) {
            return $this->returnNotification(
                self::FLASH_ERROR_KEY,
                'Please specify and process the report',
                ''
            );
        }

        $exporter = new CsvGrid([
            'dataProvider' => new SqlDataProvider([
                'sql' => $query,
            ]),
        ]);
        return $exporter->export()->send('reports.csv');
    }
}
