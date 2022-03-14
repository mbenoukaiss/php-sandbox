function createEditor($element, runCallback) {
    const DEFAULT_CODE = ``;
    $element.append(`<code class="language-php" contenteditable="plaintext-only" spellcheck="false">${DEFAULT_CODE}</code>`);

    const $code = $element.find(`code`);
    $code.on('input', function () {
        const restore = saveCaretPosition(this);
        Prism.highlightElement(this);
        restore();
    })

    fixTabulations($element);
    placeCaretAtEnd($code);

    $element.on(`keydown`, event => {
        if (event.key === `Enter` && event.ctrlKey) {
            runCallback();
        }
    })
}

function saveCaretPosition(context) {
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    range.setStart(context, 0);

    const len = range.toString().length;

    return () => {
        const pos = getTextNodeAtPosition(context, len);
        selection.removeAllRanges();
        const range = new Range();
        range.setStart(pos.node, pos.position);
        selection.addRange(range);
    }
}

function getTextNodeAtPosition(root, index) {
    const NODE_TYPE = NodeFilter.SHOW_TEXT;
    const treeWalker = document.createTreeWalker(root, NODE_TYPE, function next(elem) {
        if (index > elem.textContent.length) {
            index -= elem.textContent.length;
            return NodeFilter.FILTER_REJECT
        }
        return NodeFilter.FILTER_ACCEPT;
    });

    const c = treeWalker.nextNode();
    return {
        node: c ? c : root,
        position: index
    };
}

function placeCaretAtEnd($element) {
    setTimeout(() => {
        $element[0].focus();

        if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
            const range = document.createRange();
            range.selectNodeContents($element[0]);
            range.collapse(false);

            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (typeof document.body.createTextRange != "undefined") {
            const textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.collapse(false);
            textRange.select();
        }
    }, 0)
}

function fixTabulations($element) {
    $element.on('keydown', function (e) {
        if (e.keyCode === 9) { // tab key
            e.preventDefault();

            // insert four non-breaking spaces for the tab key
            const editor = document.getElementById("editor");
            const doc = editor.ownerDocument.defaultView;
            const selection = doc.getSelection();
            const range = selection.getRangeAt(0);

            const tabNode = document.createTextNode("\u00a0\u00a0\u00a0\u00a0");
            range.insertNode(tabNode);

            range.setStartAfter(tabNode);
            range.setEndAfter(tabNode);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    });
}

