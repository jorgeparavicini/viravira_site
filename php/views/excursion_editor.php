<?php
if (array_key_exists("creationType", $_POST)) {
	switch ($_POST['creationType']) {
		case "createNew":
			createNewExcursion();
			break;
		case "edit":
			editExcursion();
			break;
		case "created":
			// TODO: implement
			echo "<h1>Excursion Created</h1>";
			break;
	}
    editExcursion();
} else {
    createNewExcursion();
}

function editExcursion()
{
    ?>
	<h1></h1>
    <?php
}

function createNewExcursion()
{
    ?>
	<h1>Create new Excursion</h1>
	<form action="excursion_editor.php" method="POST" onsubmit="return validateForm()">
		<div>
			<label for="title">Title</label>
			<input id="title" type="text" name="title" required>

			<label for="type">Type</label>
			<input id="type" type="text" name="type" required>

			<label for="thumbnail">Thumbnail URL</label>
			<input id="thumbnail" type="text" name="thumbnail" required>
		</div>
		<div>
			<h2>Details</h2>
			<div id="details"></div>
			<button name="detailData" type="button" onclick="addDetail()">Add Detail</button>
		</div>
		<div>
			<h2>Images</h2>
			<div id="images"></div>
			<button name="imagesData" type="button" onclick="addImage()">Add Image</button>
		</div>
		<div>
			<input type="hidden" name="creationType" value="created">
			<input type="submit">
		</div>
	</form>
    <?php
}

?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script>
function addDetail() {
    let details = $("#details");
    let count = details.children().length;
    let id = `detail${count}`;
    let child = document.createElement("div");
    child.classList.add("detail");

    let label = document.createElement("label");
    label.setAttribute("for", `${id}Name`);
    label.textContent = "Name";
    let input = document.createElement("input");
    input.id = `${id}Name`;
    input.setAttribute("type", "text");
    input.setAttribute("name", `${id}Name`);

    let valueLabel = document.createElement("label");
    valueLabel.setAttribute("for", `${id}Value`);
    valueLabel.textContent = "Value";
    let valueInput = document.createElement("input");
    valueInput.id = `${id}Value`;
    valueInput.setAttribute("type", "text");
    valueInput.setAttribute("name", `${id}Value`);

    let removeButton = document.createElement("button");
    removeButton.setAttribute("name", `remove${id}`);
    removeButton.setAttribute("type", "button");
    removeButton.textContent = "remove";
    removeButton.onclick = function() {
        child.remove();
        return false;
    };

    child.append(label, input, valueLabel, valueInput, removeButton);
    details.append(child);

    return false;
}

function addImage() {
	let images = $("#images");
	let count = images.children().length;
	let id = `image${count}`;
	let child = document.createElement("div");
	child.classList.add("image");

    let urlLabel = document.createElement("label");
    urlLabel.setAttribute("for", `${id}Url`);
    urlLabel.textContent = "URL";
    let urlInput = document.createElement("input");
    urlInput.id = `${id}Url`;
    urlInput.setAttribute("type", "text");
    urlInput.setAttribute("name", `${id}Url`);

    let descriptionLabel = document.createElement("label");
    descriptionLabel.setAttribute("for", `${id}Description`);
    descriptionLabel.textContent = "Description";
    let descriptionInput = document.createElement("input");
    descriptionInput.id = `${id}Description`;
    descriptionInput.setAttribute("type", "text");
    descriptionInput.setAttribute("name", `${id}Description`);


    let removeButton = document.createElement("button");
    removeButton.setAttribute("name", `remove${id}`);
    removeButton.setAttribute("type", "button");
    removeButton.textContent = "remove";
    removeButton.onclick = function() {
        child.remove();
        return false;
    };

    child.append(urlLabel, urlInput, descriptionLabel, descriptionInput, removeButton);
    images.append(child);

    return false;
}

function validateForm() {
    return true;
}
</script>