<?php

namespace CottaCush\Cricket\Report\Models;

use CottaCush\Cricket\Report\Interfaces\CricketQueryableInterface;
use CottaCush\Cricket\Report\Libs\Utils;

/**
 * This is the model class for table "reports".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $project_id
 * @property string $type
 *
 * @property Query $queryObj
 */
class Report extends BaseReportsModel implements CricketQueryableInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%_reports}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type', 'query_id'], 'required'],
            [['description', 'query'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['type', 'status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Report Name',
            'description' => 'Description',
            'type' => 'Type',
            'query_id' => 'SQL Query',
        ];
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param null $filters
     * @return \yii\db\ActiveQuery
     */
    public static function getReports($filters = null)
    {
        return self::find()->where($filters);
    }

    public function getQuery()
    {
        return $this->queryObj;
    }

    public function getQueryObj()
    {
        return $this->hasOne(Query::class, ['id' => 'query_id']);
    }

    public function getEncodedId()
    {
        return Utils::encodeId($this->id);
    }
}
