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

class m170846_041017_graficas extends Migration
{
    public function up()
    {
		// add foreign key for table `paciente`
		$this->dropForeignKey(
            'fk-post-examen_id',
            'grafica'
        );

    	$this->dropcolumn('{{%grafica}}', 'examen_id');
    }

    public function down()
    {
    	// drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-post-examen_id',
            'grafica'
        );
		
        $this->dropcolumn('{{%grafica}}', 'examen_id');
    }
	
}
