<?php

use yii\db\Migration;

class m170831_040917_controlCajas extends Migration
{
    public function safeUp()
    {
        $this->createTable('controlCaja', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'fecha' => $this->date()->notNull(),
            'cajaTomada' => $this->integer()->notNull(),
            'dosisAcumulada' => $this->integer()->notNull(),
            'dosisRestante' => $this->integer()->notNull(),
            'dosisCaja' => $this->integer()->notNull()
        ]);
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-controlCaja-paciente_id',
            'controlCaja',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-controlCaja_id',
            'controlCaja',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170831_040917_controlCajas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
    public function down()
    {
        echo "m170831_040917_controlCajas cannot be reverted.\n";

        return false;
    }
    */
}
