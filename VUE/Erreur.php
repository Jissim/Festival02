<?php $title = 'Festival - Erreur'; ?>

<?php ob_start() ?>
<p>Une erreur est survenue : <?= $msgErreur ?></p>
<?php afficherErreurs(); ?>
<?php $contenu = ob_get_clean(); ?>

<?php require './VUE/Template.php'; ?>