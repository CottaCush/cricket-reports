<?php

namespace CottaCush\Cricket\Report\Models;

use CottaCush\Cricket\Interfaces\PlaceholderInterface;

/**
 * This is the model class for table "query_placeholders".
 *
 * @property int $id
 * @property int $query_id
 * @property string $name
 * @property string $description
 * @property string $placeholder_type
 *
 * @property PlaceholderType $placeholderType
 * @property Query $query
 * @property Query $dropdownQuery
 */
class QueryPlaceholder extends BaseReportsModel implements PlaceholderInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%_query_placeholders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['query_id', 'name', 'description', 'placeholder_type'], 'required'],
            [['query_id', 'dropdown_query_id'], 'integer'],
            [['name', 'description', 'placeholder_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'query_id' => 'Query ID',
            'name' => 'Name',
            'description' => 'Description',
            'placeholder_type' => 'Placeholder Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->hasOne(Query::class, ['id' => 'query_id']);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->placeholder_type;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return \yii\db\ActiveQuery
     */
    public function getDropdownQuery()
    {
        return $this->hasOne(Query::class, ['id' => 'dropdown_query_id']);
    }
}
