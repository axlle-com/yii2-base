<?php

namespace app\protected\Url\repositories;

use app\protected\Url\forms\UrlFilterForm;
use app\protected\Url\models\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class UrlRepository implements \app\protected\Url\contracts\UrlRepository
{
    /**
     * @throws Exception
     */
    public function saveUrl(Url $url): Url
    {
        if ($url->save()) {
            return $url;
        }

        throw new Exception("Can't save url");
    }

    public function findByToken(string $shortUrl): ?Url
    {
        return Url::findOne(['token' => $shortUrl]);
    }

    public function getStatsDataProvider(?UrlFilterForm $form = null): ActiveDataProvider
    {
        $query = Url::find()
            ->alias('u')
            ->leftJoin('url_stats ust', 'u.id = ust.url_id')
            ->groupBy('u.id')
            ->select([
                'u.*',
                'click_count' => 'COUNT(ust.id)',
            ]);

        if ($form !== null && ! $form->isEmpty()) {
            $query->andWhere(['>=', 'ust.created_at', "$form->start_date 00:00:00"])
                ->andWhere(['<=', 'ust.created_at', "$form->end_date 23:59:59"]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);
    }
}
