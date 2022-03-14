const $editor = $(`#editor`);
const $output = $(`#output`);
const $outputParent = $(`.parent-content`);
const $run = $(`.run-code`);

function run() {
    const content = new FormData();
    content.append(`code`, $editor.find(`code`).text());

    toggleLoaders(true);

    fetch(`/parse`, {method: `POST`, body: content})
        .then(res => res.text())
        .then(script => fetch(script)
            .then(res => res.text())
            .then(output => {
                $output.html(output && output.length ? output : `<i>No output</i>`);
                toggleLoaders(false);
            }))
}

function toggleLoaders(show = true) {
    const LOADER = `<div class="loader"><img src="/assets/loading.png"></div>`;

    if(show) {
        $editor.append(LOADER);
        $outputParent.append(LOADER);
    } else {
        const $loaders = $(`.loader`);

        $loaders.css(`transition`, `opacity 300ms`);
        $loaders.css(`opacity`, 0);

        setTimeout(() => $loaders.remove(), 300);
    }
}

$run.on(`click`, run);
createEditor($editor, run);