<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";

if (isset($_GET['id']) || (isset($_GET['action']) && $_GET['action'] == "create")) {
    require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/modify_excursion.php";
    return;
}
?>

<link rel="stylesheet" href="/css/confirm.css" type="text/css">
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
					<a href="edit?id=<?php echo $excursion->getId() ?>">Modify</a>
					<a href="delete?id=<?php echo $excursion->getId() ?>"
					   class="delete"
					   data-title="<?php echo $excursion->getTitle() ?>">Delete</a>
				</div>
			</div>
            <?php
        }
        ?>
	</div>
    <?php
}
?>

<a class="create" href="edit?action=create">Create new Excursion</a>

<div class="confirm">
	<div>
		<p id="confirmMessage">Confirm text</p>
		<div>
			<label><input id="confirmYes" type="button" value="Yes"/></label>
			<label><input id="confirmNo" type="button" value="No"></label>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/js/alert.js"></script>
<script>

	$(".delete").each(function() {
	    $(this).on("click", function(event) {
	        event.preventDefault();
	        save(event, $(this).attr("data-title"), function () {
	            location.href = event.target.href;
	        })
	    })
	});

    const save = async (event, title, confirmed) => {
        const confirm = await ui.confirm(`Are you sure you want to delete the excursion: ${title}?`);

        if (confirm) {
            confirmed();
        }
    }
</script>
