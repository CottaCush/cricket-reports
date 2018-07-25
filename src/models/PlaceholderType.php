<?php

namespace CottaCush\Cricket\Report\Models;

/**
 * This is the model class for table "placeholder_types".
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 */
class PlaceholderType extends BaseReportsModel
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_DATE = 'date';
    const TYPE_TEXT = 'text';

    const BOOLEAN_VALUES_MAP = [
        '1' => 'Yes',
        '0' => 'No'
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'key', 'created_at'], 'required'],
            [['is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'key'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'key' => 'Key',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
