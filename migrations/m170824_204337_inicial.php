<?php

use yii\db\Migration;

class m170824_204337_inicial extends Migration
{
    public function safeUp()
    {
        $this->createTable('paciente', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `doctor_id`
        $this->createIndex(
            'idx-paciente-doctor_id',
            'paciente',
            'doctor_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-doctor_id',
            'paciente',
            'doctor_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-paciente-user_id',
            'paciente',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'paciente',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        echo "m170824_204337_inicial cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170824_204337_inicial cannot be reverted.\n";

        return false;
    }
    */
}
