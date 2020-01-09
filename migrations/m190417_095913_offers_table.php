<?php

use yii\db\Migration;

/**
 * Class m190417_095913_offers_table
 */
class m190417_095913_offers_table extends Migration
{
    public const TABLE = 'offers';

    public const TABLE_COUNTRY = 'country';

    public const TABLE_AD_NETWORK = 'ad_networks';

    public const TABLE_COUNTRY_CROSS = 'county_to_offers';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'network_id' => $this->integer()->notNull(),
            'internal_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'payout' => $this->double(2)->notNull()
        ]);

        $this->createTable(self::TABLE_COUNTRY_CROSS, [
            'offer_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'PRIMARY KEY(offer_id, country_id)'
        ]);

        $this->createIndex('idx-network_id', self::TABLE, 'network_id');
        $this->createIndex('idx-internal_id', self::TABLE, 'network_id');
        $this->createIndex('idx-network-internal', self::TABLE, ['network_id', 'internal_id'], true);

        $this->addForeignKey(
            'fk-offer-network-id',
            self::TABLE,
            'network_id',
            self::TABLE_AD_NETWORK,
            'id'
        );

        $this->addForeignKey(
            'fk-offer-country-id',
            self::TABLE_COUNTRY_CROSS,
            'country_id',
            self::TABLE_COUNTRY,
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-offer',
            self::TABLE_COUNTRY_CROSS,
            'offer_id',
            self::TABLE,
            'id',
            'CASCADE',
            'CASCADE'
        );
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
        echo "m190417_095913_offers_table cannot be reverted.\n";

        return false;
    }
    */
}
