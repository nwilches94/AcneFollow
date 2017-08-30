<?php

use yii\db\Migration;

class m170826_121910_examenes extends Migration
{
    public function safeUp()
    {
        $this->createTable('examen', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'paciente_id' => $this->integer()->notNull(),
            'fecha' => $this->dateTime(),
            'notas' => $this->text()->null(),
        ]);

        // creates index for column `paciente_id`
        $this->createIndex(
            'idx-examen-paciente_id',
            'examen',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-paciente_id',
            'examen',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170826_121910_examenes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170826_121910_examenes cannot be reverted.\n";

        return false;
    }
    */
}
