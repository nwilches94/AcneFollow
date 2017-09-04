<?php

use yii\db\Migration;

class m170829_030917_mensajes extends Migration
{
    public function safeUp()
    {
        $this->createTable('mensaje', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'mensaje' => $this->text()->notNull(),
            'leido' => $this->integer(1)->notNull(),
            'origen' => $this->string()->notNull(),
            'fecha' => $this->date()->notNull()
        ]);
		
		// creates index for column `paciente_id`
        $this->createIndex(
            'idx-mensaje-paciente_id',
            'mensaje',
            'paciente_id'
        );

        // add foreign key for table `paciente`
        $this->addForeignKey(
            'fk-post-mensaje_id',
            'mensaje',
            'paciente_id',
            'paciente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m170829_030917_mensajes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
    public function down()
    {
        echo "m170829_030917_mensajes cannot be reverted.\n";

        return false;
    }
    */
}
