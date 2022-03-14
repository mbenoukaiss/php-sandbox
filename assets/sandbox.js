const $editor = $(`#editor`);
const $output = $(`#output`);
const $run = $(`.run-code`);

function run() {
    const content = new FormData();
    content.append(`code`, $editor.find(`code`).text());

    fetch(`/parse.php`, {method: `POST`, body: content})
        .then(res => res.text())
        .then(url => fetch(url)
            .then(res => res.text())
            .then(output => $output.html(output && output.length ? output : `<i>No output</i>`)))
}

$run.on(`click`, run);
createEditor($editor, run);