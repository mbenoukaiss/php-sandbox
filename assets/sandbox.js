import $ from 'cash-dom';
import {createEditor} from "./editor";

const $containers = $(`.parent-content`);
const $editor = $(`#editor`);
const $output = $(`.output`);
const $console = $(`.console .console-content`);
const $executionTime = $(`.execution-time`);
const $run = $(`.run-code`);

let currentScript = null;

function run() {
    const content = new FormData();
    content.append(`code`, $editor.find(`code`).text());

    toggleLoaders(true);

    fetch(`/create-script`, {method: `POST`, body: content})
        .then(res => res.text())
        .then(script => fetch(`/run?script=${script}`)
            .then(res => res.json())
            .then(response => {
                currentScript = script;

                $output.html(response.output && response.output.length ? response.output.replace(/^<br ?\/?>/g, '') : `<i>No output</i>`);
                $executionTime.html(`Script took <b>${response.executionTime}</b> to run`);

                newCommandLine({
                    clear: true,
                    focus: false,
                });

                toggleLoaders(false);
            }))
}

function toggleLoaders(show = true) {
    const LOADER = `<div class="loader"><img src="/assets/images/loading.png" alt="Loading"></div>`;

    if(show) {
        $containers.append(LOADER);
    } else {
        const $loaders = $(`.loader`);

        $loaders.css(`transition`, `opacity 300ms`);
        $loaders.css(`opacity`, 0);

        setTimeout(() => $loaders.remove(), 300);
    }
}

$run.on(`click`, run);

$(document).on(`keydown`, event => {
    if (event.key === `Enter` && event.ctrlKey) {
        run();
    }
});

createEditor($editor);

$(`.console`).on(`click`, function() {
    const selection = window.getSelection();
    if(selection.type !== `Range`) {
        $(this).find(`.current-console-line`).trigger(`focus`);
    }
})

$(`.console`).on(`keypress`, `.current-console-line`, function(event) {
    if(event.key === `Enter` && !event.ctrlKey) {
        event.preventDefault();

        const $line = $(this);

        console.log();
        fetch(`/command?script=${currentScript}&command=${$line.text()}`)
            .then(response => response.text())
            .then(response => {
                if(response.length) {
                    $console.append(`<textarea rows="${response.split(`\n`).length - 1}" readonly>${response}</textarea>`);
                }

                newCommandLine({
                    clear: false,
                    focus: true,
                });
            })
    }
});

function newCommandLine({clear = false, focus = false}) {
    $(`.current-console-line[contenteditable]`).prop(`contenteditable`, false);
    $console[clear ? `html` : `append`](`<b>sandbox:</b>&nbsp;<span class="current-console-line" contenteditable></span>`);

    if(focus) {
        $console.find(`.current-console-line`).trigger(`focus`);
    }
}