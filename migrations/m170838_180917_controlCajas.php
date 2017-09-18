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

class m170838_180917_controlCajas extends Migration
{
    public function up()
    {
    	$this->dropcolumn('{{%controlCaja}}', 'dosisAcumulada');
        $this->addColumn('{{%controlCaja}}', 'dosisAcumulada', $this->float()->notNull());
		$this->dropcolumn('{{%controlCaja}}', 'dosisRestante');
        $this->addColumn('{{%controlCaja}}', 'dosisRestante', $this->float()->notNull());
		$this->dropcolumn('{{%controlCaja}}', 'dosisCaja');
        $this->addColumn('{{%controlCaja}}', 'dosisCaja', $this->float()->notNull());
    }
	
    public function down()
    {
        $this->dropcolumn('{{%controlCaja}}', 'dosisAcumulada');
		$this->dropcolumn('{{%controlCaja}}', 'dosisRestante');
		$this->dropcolumn('{{%controlCaja}}', 'dosisCaja');
    }
}
