<h1>Edit Excursions</h1>

<?php
// Load the excursions
$excursions = Excursion::loadAllOrdered();
foreach ($excursions as $type => $excursionList) {
    ?>
	<h3><?php echo $type ?></h3>
	<div class="cards">
        <?php
        /* @var $excursion Excursion */
        foreach ($excursionList as $index => $excursion) {
            ?>
			<div class="card excursion">
				<img src="/img/excursions/<?php echo $excursion->getThumbnail() ?>"
				     alt="<?php echo "Excursion{$index}" ?>"/>
				<p><?php echo $excursion->getTitle() ?></p>
				<div class="control">
					<a href="modify?id=<?php echo $excursion->getId() ?>">Modify</a>
					<a href="delete?id=<?php echo $excursion->getId() ?>">Delete</a>
				</div>
			</div>
            <?php
        }
        ?>
	</div>
    <?php
}
?>

<a class="create" href="modify">Create new Excursion</a>
