<?php

use yii\db\Migration;

class m241026_150318_create_urls_table extends Migration
{
    private const string INDEX = '{{%idx_urls_created_at}}';

    private string $tableName = '{{%urls}}';

    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'original_url' => $this->text()->notNull(),
            'token' => $this->string(5)->notNull()->unique(), // TODO HASH
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            self::INDEX,
            $this->tableName,
            'created_at'
        );
    }

    public function safeDown(): void
    {
        $this->dropTable($this->tableName);
    }
}
