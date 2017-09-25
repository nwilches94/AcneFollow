<?php

use app\models\Paciente;
use dektrium\user\models\profile;

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var dektrium\user\models\User
 */
?>
<!--<? Yii::t('user', 'Hello') ?>,

<? Yii::t('user', 'Your account on {0} has been created', Yii::$app->name) ?>.-->

<!--<?php if ($module->enableGeneratingPassword): ?>
	<? Yii::t('user', 'We have generated a password for you') ?>:
	<? $user->password ?>
<?php endif ?>-->

<?php 	$paciente=Paciente::find()->where(['doctor_id' => Yii::$app->user->id])->one();
		$profile=Profile::find()->where(['user_id' => $paciente['user_id']])->one();
?>

Bienvenido a Acnefollow<br><br>

Su dermatologo <?= $profile['name'] ?> a creado su cuenta en la aplicacion para que le sirva de apoyo en su tratamiento contra el acne.<br>
Su usuario es : <?= $user->email ?><br>
Su contraseña es: <?= $user->password ?><br>
Para poder acceder a la aplicacion ingrese al siguiente link: <a href="acnefollow.tk">Acnefollow.tk</a><br><br>
Recuerda ser constante con el tratamiento y verás los cambios.

<?php if ($token !== null): ?>
	<?= Yii::t('user', 'In order to complete your registration, please click the link below') ?>.
	<?= $token->url ?>
	<?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
<?php endif ?>

<!--<? Yii::t('user', 'If you did not make this request you can ignore this email') ?>.-->
