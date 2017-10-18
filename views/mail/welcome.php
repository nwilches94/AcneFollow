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

<?php $profile=Profile::find()->where(['user_id' => Yii::$app->user->id])->one(); ?>

Bienvenido a Acnefollow,<br><br>

Su dermatólogo <?= $profile['name'] ?> a creado su cuenta en la aplicación para que le sirva de apoyo en su tratamiento contra el acné.<br><br>

Su usuario es : <?= $user->email ?><br>
Su contraseña es: <?= $user->password ?><br><br>

Para poder acceder a la aplicación ingrese al siguiente link: <a href="http://acnefollow.tk">Acnefollow.tk</a><br>
Recuerda ser constante con el tratamiento y verás los cambios.<br><br>

<iframe class="youtube-player" type="text/html" width="600" height="400" src="http://www.youtube.com/embed/-09uLJRoc8M" frameborder="0"></iframe>

<?php if ($token !== null): ?>
	<?= Yii::t('user', 'In order to complete your registration, please click the link below') ?>.
	<?= $token->url ?>
	<?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
<?php endif ?>

<!--<? Yii::t('user', 'If you did not make this request you can ignore this email') ?>.-->
