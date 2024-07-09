<?php

if (isset($_GET['id'])) {
	$id = '-0-' . trim(strip_tags($_GET['id']));
} else {
	$id = '';
}
?>
<?php include 'includes/layouts/overalheader.php'; ?>

<?php include 'includes/layouts/footer.php'; ?>