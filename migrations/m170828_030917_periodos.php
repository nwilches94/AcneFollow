<?php

use yii\db\Migration;

class m170828_030917_periodos extends Migration
{
    public function safeUp()
    {
        $this->createTable('periodo', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'fecha' => $this->date()
        ]);
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-periodo-paciente_id',
            'periodo',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-periodo_id',
            'periodo',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170828_030917_periodos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170828_030917_periodos cannot be reverted.\n";

        return false;
    }
    */
}
