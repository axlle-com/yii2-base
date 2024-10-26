<?php

use yii\db\Migration;

class m241026_150553_create_url_stats_table extends Migration
{
    private const string FOREIGN_KEY = '{{%fk_url_stats_url_id}}';
    private const string INDEX = '{{%idx_url_stats_url_id}}';
    private const string INDEX_CREATED_AT = '{{%idx_url_stats_created_at}}';

    private string $tableNameUrl = '{{%urls}}';
    private string $tableName = '{{%url_stats}}';

    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'url_id' => $this->bigInteger()->unsigned()->notNull(),
            'ip' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            self::INDEX,
            $this->tableName,
            'url_id'
        );
        $this->createIndex(
            self::INDEX_CREATED_AT,
            $this->tableName,
            'created_at'
        );

        $this->addForeignKey(
            self::FOREIGN_KEY,
            $this->tableName,
            'url_id',
            $this->tableNameUrl,
            'id',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey(self::FOREIGN_KEY, $this->tableName);
        $this->dropIndex(self::INDEX, $this->tableName);

        $this->dropTable($this->tableName);
    }
}
