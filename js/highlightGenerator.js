generateHighlights();

function pickRandoms(startIndex, rangeSize, numberOfPicks) {
    let result = [];

    if (numberOfPicks > rangeSize) rangeSize = numberOfPicks;

    while (result.length < numberOfPicks) {
        let random = Math.floor(Math.random() * rangeSize + startIndex);
        if (result.indexOf(random) === -1) {
            result.push(random);
        }
    }

    return result;
}

function generateHighlights() {
    let highlightIds = pickRandoms(1, 12, 4);
    console.log(highlightIds);
    $('.slide').each(function(i, slide) {
        slide.src = "../img/Gallery/gallery" + highlightIds[i] + ".jpg";
        console.log(slide);
    })
}