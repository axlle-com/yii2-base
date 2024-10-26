<?php

namespace app\protected\Url\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $url_id
 * @property string|null $ip
 * @property string $created_at
 */
class UrlStats extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%url_stats}}';
    }

    public function rules(): array
    {
        return [
            [['ip', 'url_id'], 'required'],
            [['url_id'], 'integer'],
            [['ip'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'url_id' => 'URL',
            'ip' => 'IP',
            'created_at' => 'Created At',
        ];
    }
}
