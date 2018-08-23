<?php

namespace CottaCush\Cricket\Report\Models;

use CottaCush\Cricket\Report\Interfaces\Replaceable;

/**
 * This is the model class for table "report_placeholders".
 *
 * @property int $id
 * @property int $report_id
 * @property string $name
 * @property string $description
 * @property string $placeholder_type
 *
 * @property PlaceholderType $placeholderType
 * @property Report $report
 * @property Report $dropdownReport
 */
class ReportPlaceholder extends BaseReportsModel implements Replaceable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%_report_placeholders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'name', 'description', 'placeholder_type'], 'required'],
            [['report_id', 'dropdown_report_id'], 'integer'],
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
            'report_id' => 'Report ID',
            'name' => 'Name',
            'description' => 'Description',
            'placeholder_type' => 'Placeholder Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
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
    public function getDropdownReport()
    {
        return $this->hasOne(Report::class, ['id' => 'dropdown_report_id']);
    }
}
