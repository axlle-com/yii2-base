<?php

namespace app\protected\Url\forms;

use yii\base\Model;

class UrlForm extends Model
{
    public ?string $original_url = null;

    public function rules(): array
    {
        return [
            [['original_url'], 'required'],
            [['original_url'], 'url'],
        ];
    }
}
