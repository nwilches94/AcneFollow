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

class m170834_140917_profile extends Migration
{
    public function up()
    {
    	$this->dropcolumn('{{%profile}}', 'cedula');
        $this->addColumn('{{%profile}}', 'cedula', $this->integer(11)->null());
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'cedula');
    }
}
