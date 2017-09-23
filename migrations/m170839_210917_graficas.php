<?php

use yii\db\Migration;

class m170839_210917_graficas extends Migration
{
    public function safeUp()
    {
        $this->createTable('grafica', [
            'id' => $this->primaryKey(),
            'examen_id' => $this->integer()->notNull(),
            'fecha' => $this->date()->notNull(),
            'tipo' => $this->string()->notNull(),
            'valorExamen' => $this->string()->notNull(),
            'valorReferencia' => $this->string()->notNull(),
        ]);

         // creates index for column `paciente_id`
        $this->createIndex(
            'idx-grafica-examen_id',
            'examen',
            'id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-examen_id',
            'grafica',
            'examen_id',
            'examen',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170839_210917_graficas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170839_210917_graficas cannot be reverted.\n";

        return false;
    }
    */
}

