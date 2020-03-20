<?php

$excursion = null;
$error = null;

if (isset($_GET['id'])) {
    try {
        $excursion = Excursion::loadFromId($_GET['id']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if ($excursion != null && $error == null) {
    echo "<h1>Modify {$excursion->getTitle()}</h1>";
} else {
    echo "<h1>Create new Excursion</h1>";
}

if ($error != null) {
    echo "<h3 class='error'>{$error}</h3>";
}
?>

<form id="excursionEditor" action="update" method="POST" onsubmit="return validateForm()">
    <div class="container">
        <div class="container">
            <label for="title">Title</label>
            <input id="title" type="text" name="title"
                   value="<?php if ($excursion != null) echo $excursion->getTitle() ?>"
                   required>
        </div>

        <div class="container">
            <label for="type">Type</label>
            <input id="type" type="text" name="type" value="<?php if ($excursion != null) echo $excursion->getType() ?>"
                   required>
        </div>

        <div class="container">
            <label for="thumbnail">Thumbnail URL</label>
            <input id="thumbnail" type="text" name="thumbnail"
                   value="<?php if ($excursion != null) echo $excursion->getThumbnail() ?>" required>
        </div>
    </div>
    <div>
        <h2>Descriptions</h2>
        <div id="descriptions">
            <?php
            if ($excursion != null) {
                $index = 0;
                $descriptions = $excursion->getDescriptions();
                if ($excursion->getMainDescription() != null)
                    $descriptions['Description'] = $excursion->getMainDescription();
                foreach ($descriptions as $key => $description) {
                    ?>
                    <div class="description" id="description<?php echo $index ?>">
                        <div class="panels">
                            <div class="panel">
                                <label for="description<?php echo $index ?>Header">Header</label>
                                <input id="description<?php echo $index ?>Header" type="text"
                                       name="description<?php echo $index ?>Header"
                                       value="<?php echo $key ?>">
                            </div>
                            <div class="panel">
                                <label for="description<?php echo $index ?>Value">Value</label>
                                <input id="description<?php echo $index ?>Value" type="text"
                                       name="description<?php echo $index ?>Value"
                                       value="<?php echo $description ?>">
                            </div>
                        </div>
                        <button name="removedetail<?php echo $index ?>" type="button" onclick="
                                let element = document.getElementById('description<?php echo $index ?>');
                                element.remove();
                                ">remove
                        </button>
                    </div>
                    <?php
                    $index++;
                }
            }
            ?>
        </div>
        <button name="descriptionData" type="button" onclick="addDescription()">Add Description</button>
    </div>
    <div>
        <h2>Details</h2>
        <div id="details">
            <?php
            if ($excursion != null) {
                $index = 0;
                $details = $excursion->getDetails();
                if ($details !== null) {
                    foreach ($details as $key => $detail) {
                        ?>
                        <div class="detail" id="detail<?php echo $index ?>">
                            <div class="panels">
                                <div class="panel">
                                    <label for="detail<?php echo $index ?>Name">Name</label>
                                    <input id="detail<?php echo $index ?>Name" type="text"
                                           name="detail<?php echo $index ?>Name"
                                           value="<?php echo $key ?>">
                                </div>
                                <div class="panel">
                                    <label for="detail<?php echo $index ?>Value">Value</label>
                                    <input id="detail<?php echo $index ?>Value" type="text"
                                           name="detail<?php echo $index ?>Value"
                                           value="<?php echo $detail["value"] ?>">
                                </div>
                            </div>
                            <button name="removedetail<?php echo $index ?>" type="button" onclick="
                                    let element = document.getElementById('detail<?php echo $index ?>');
                                    element.remove();
                                    ">remove
                            </button>
                        </div>
                        <?php
                        $index++;
                    }
                }
            }
            ?>
        </div>
        <button name="detailData" type="button" onclick="addDetail()">Add Detail</button>
    </div>
    <div>
        <h2>Images</h2>
        <div id="images">
            <?php
            if ($excursion != null) {
                foreach ($excursion->getImages() as $index => $detail) {
                    ?>
                    <div class="image" id="image<?php echo $index ?>">
                        <div class="panels">
                            <div class="panel">
                                <label for="image<?php echo $index ?>Url">Name</label>
                                <input id="image<?php echo $index ?>Url" type="text"
                                       name="image<?php echo $index ?>Url"
                                       value="<?php echo $detail['url'] ?>">
                            </div>
                            <div class="panel">
                                <label for="image<?php echo $index ?>Description">Description</label>
                                <input id="image<?php echo $index ?>Description" type="text"
                                       name="image<?php echo $index ?>Description"
                                       value="<?php echo $detail["description"] ?>">
                            </div>
                        </div>
                        <button name="removedetail<?php echo $index ?>" type="button" onclick="
                                let element = document.getElementById('image<?php echo $index ?>');
                                element.remove();
                                ">remove
                        </button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button name="imagesData" type="button" onclick="addImage()">Add Image</button>
    </div>
    <div>
        <?php
        if ($excursion !== null) {
            echo "<input type=\"hidden\" name=\"id\" value=\"{$excursion->getId()}\">";
        }
        ?>
        <input type="submit" value="<?php if ($excursion != null) echo "Update"; else echo "Create" ?>">
    </div>
</form>


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

        let panels = document.createElement("div");
        panels.classList.add("panels");
        let leftPanel = document.createElement("div");
        leftPanel.classList.add("panel");
        let rightPanel = document.createElement("div");
        rightPanel.classList.add("panel");

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
        removeButton.onclick = function () {
            child.remove();
            return false;
        };

        child.append(panels, removeButton);
        panels.append(leftPanel, rightPanel);
        leftPanel.append(label, input);
        rightPanel.append(valueLabel, valueInput);
        details.append(child);

        return false;
    }

    function addImage(url = null, description = null) {
        let images = $("#images");
        let count = images.children().length;
        let id = `image${count}`;
        let child = document.createElement("div");
        child.classList.add("image");

        let panels = document.createElement("div");
        panels.classList.add("panels");
        let leftPanel = document.createElement("div");
        leftPanel.classList.add("panel");
        let rightPanel = document.createElement("div");
        rightPanel.classList.add("panel");

        let urlLabel = document.createElement("label");
        urlLabel.setAttribute("for", `${id}Url`);
        urlLabel.textContent = "URL";
        let urlInput = document.createElement("input");
        urlInput.id = `${id}Url`;
        urlInput.setAttribute("type", "text");
        urlInput.setAttribute("name", `${id}Url`);
        if (url !== null)
            urlInput.setAttribute("value", url);


        let descriptionLabel = document.createElement("label");
        descriptionLabel.setAttribute("for", `${id}Description`);
        descriptionLabel.textContent = "Description";
        let descriptionInput = document.createElement("input");
        descriptionInput.id = `${id}Description`;
        descriptionInput.setAttribute("type", "text");
        descriptionInput.setAttribute("name", `${id}Description`);
        if (description !== null)
            descriptionInput.setAttribute("value", description);


        let removeButton = document.createElement("button");
        removeButton.setAttribute("name", `remove${id}`);
        removeButton.setAttribute("type", "button");
        removeButton.textContent = "remove";
        removeButton.onclick = function () {
            child.remove();
            return false;
        };

        child.append(panels, removeButton);
        panels.append(leftPanel, rightPanel);
        leftPanel.append(urlLabel, urlInput);
        rightPanel.append(descriptionLabel, descriptionInput);
        images.append(child);

        return false;
    }

    function addDescription() {
        let descriptions = $("#descriptions");
        let count = descriptions.children().length;
        let id = `description${count}`;
        let child = document.createElement("div");
        child.classList.add("description");

        let panels = document.createElement("div");
        panels.classList.add("panels");
        let leftPanel = document.createElement("div");
        leftPanel.classList.add("panel");
        let rightPanel = document.createElement("div");
        rightPanel.classList.add("panel");

        let headerLabel = document.createElement("label");
        headerLabel.setAttribute("for", `${id}Header`);
        headerLabel.textContent = "Header";
        let input = document.createElement("input");
        input.id = `${id}Header`;
        input.setAttribute("type", "text");
        input.setAttribute("name", `${id}Header`);

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
        removeButton.onclick = function () {
            child.remove();
            return false;
        };

        child.append(panels, removeButton);
        panels.append(leftPanel, rightPanel);
        leftPanel.append(headerLabel, input);
        rightPanel.append(valueLabel, valueInput);
        descriptions.append(child);

        return false;
    }

    function validateForm() {
        return true;
    }
</script>