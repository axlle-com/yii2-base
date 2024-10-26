<?php

namespace app\protected\Url\forms;

use yii\base\Model;

class UrlFilterForm extends Model
{
    public ?string $start_date = null;
    public ?string $end_date = null;

    public function rules(): array
    {
        return [
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [
                ['start_date'],
                'compare',
                'compareAttribute' => 'end_date',
                'operator' => '<=',
                'type' => 'date',
                'message' => 'Начальная дата должна быть раньше конечной даты.'
            ],
        ];
    }

    public function isEmpty(): bool
    {
        return $this->start_date === null || $this->end_date === null;
    }
}
