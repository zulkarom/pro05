<?php

use yii\db\Migration;

/**
 * Class m180801_041453_add_new_fullname_to_user
 */
class m180801_041453_add_new_fullname_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180801_041453_add_new_fullname_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180801_041453_add_new_fullname_to_user cannot be reverted.\n";

        return false;
    }
    */
}
