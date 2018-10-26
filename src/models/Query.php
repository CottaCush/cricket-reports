<?php

namespace CottaCush\Cricket\Report\Models;

use CottaCush\Cricket\Interfaces\QueryInterface;

/**
 * This is the model class for table "queries".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $project_id
 * @property string $created_at
 * @property int $created_by
 * @property string $last_updated_at
 * @property int $last_updated_by
 * @property string $query
 * @property boolean $is_dropdown_query
 *
 * @property QueryPlaceholder[] placeholders
 * @property QueryPlaceholder[] $sessionPlaceholders
 * @property QueryPlaceholder[] $inputPlaceholders
 * @property Query[] $placeholderQueries
 * @property QueryPlaceholder[] $dropdownPlaceholders
 */
class Query extends BaseReportsModel implements QueryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%_queries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'query', 'is_dropdown_query', 'cricket_id'], 'required'],
            [['query'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Query Name',
            'description' => 'Description',
            'project_id' => 'Project ID',
            'query' => 'SQL Query',
            'status' => 'Status',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
            'is_dropdown_query' => 'Is a dropdown query?'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceholders()
    {
        return $this->hasMany(QueryPlaceholder::class, ['query_id' => 'id']);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return \yii\db\ActiveQuery
     */
    public function getSessionPlaceholders()
    {
        return $this->getPlaceholders()->andWhere(['placeholder_type' => PlaceholderType::TYPE_SESSION]);
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return \yii\db\ActiveQuery
     */
    public function getInputPlaceholders()
    {
        return $this->getPlaceholders()->andWhere(['!=', 'placeholder_type', PlaceholderType::TYPE_SESSION]);
    }

    public function hasInputPlaceholders()
    {
        return $this->getInputPlaceholders()->exists();
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param $projectId
     * @return \yii\db\ActiveQuery
     */
    public static function getDropdownQueries($projectId)
    {
        return self::find()->where(['is_dropdown_query' => true, 'project_id' => $projectId]);
    }

    public function getPlaceholderQueries()
    {
        return $this->hasMany(Query::class, ['id' => 'dropdown_query_id'])
            ->via('placeholders');
    }

    public function getDropdownPlaceholders()
    {
        return $this->hasMany(QueryPlaceholder::class, ['dropdown_query_id' => 'id']);
    }

    public function getQuery()
    {
        return $this->query;
    }
}
