<?php

if (isset($_GET['id'])) {
	$id = '-public-' . trim(strip_tags($_GET['id']));
	if (!file_exists('includes/widgets/content' . $id . '.php')) {
		http_response_code(404);
		include('404.html');
		die();
	}
} else {
	$id = '';
}

?>
<?php include 'includes/layouts/overalheader.php'; ?>


<?php if ($id) { ?>
<?php include 'includes/widgets/content' . $id . '.php'; ?>
<?php } else { ?>
<?php include 'public.php'; ?>
<?php } ?>


<?php include 'includes/layouts/footer.php'; ?>