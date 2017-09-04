<?php

use yii\db\Migration;

class m170827_020917_fotos extends Migration
{
    public function safeUp()
    {
        $this->createTable('foto', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'fecha' => $this->date()
        ]);
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-foto-paciente_id',
            'foto',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-foto_id',
            'foto',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170827_020917_fotos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170827_020917_examenes cannot be reverted.\n";

        return false;
    }
    */
}
