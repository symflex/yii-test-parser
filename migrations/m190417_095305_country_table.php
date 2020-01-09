<?php

use yii\db\Migration;

/**
 * Class m190417_095305_country_table
 */
class m190417_095305_country_table extends Migration
{
    public const TABLE = 'country';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id'   => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'code' => $this->string(2)->notNull()
        ]);

        $this->createIndex('country_code', self::TABLE, ['code']);

        $this->insert(self::TABLE, [
            'name' => 'USA',
            'code' => 'us'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190417_095305_country_table cannot be reverted.\n";

        return false;
    }
    */
}
