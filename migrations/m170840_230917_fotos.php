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

class m170840_230917_fotos extends Migration
{
    public function up()
    {
		$this->addColumn('{{%foto}}', 'notas', $this->text()->null());
    }

    public function down()
    {
		$this->dropcolumn('{{%foto}}', 'notas');
    }
}
