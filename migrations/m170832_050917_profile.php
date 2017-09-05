<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use dektrium\user\migrations\Migration;

class m170832_050917_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'sexo', $this->string(255)->null());
		$this->addColumn('{{%profile}}', 'peso', $this->integer(11)->null());
		$this->addColumn('{{%profile}}', 'telefono', $this->string(255)->null());
		$this->addColumn('{{%profile}}', 'fecha', $this->date()->null());
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'sexo');
		$this->dropcolumn('{{%profile}}', 'peso');
		$this->dropcolumn('{{%profile}}', 'telefono');
		$this->dropcolumn('{{%profile}}', 'fecha');
    }
}
