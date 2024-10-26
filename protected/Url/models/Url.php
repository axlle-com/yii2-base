<?php

namespace app\protected\Url\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $token
 * @property string $original_url
 * @property string $created_at
 */
class Url extends ActiveRecord
{
    public ?int $click_count = null;

    public static function tableName(): string
    {
        return '{{%urls}}';
    }

    public function rules(): array
    {
        return [
            [['token', 'original_url'], 'required'],
            [['created_at'], 'safe'],
            [['token'], 'string', 'max' => 5],
            [['original_url'], 'string'],
            ['click_count', 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'original_url' => 'Original URL',
            'created_at' => 'Created At',
            'click_count' => 'Click count',
        ];
    }

    /**
     * @return ActiveQuery<UrlStats>
     */
    public function getStats(): ActiveQuery
    {
        return $this->hasMany(UrlStats::class, ['url_id' => 'id']);
    }
}
