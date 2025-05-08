import {checkClassList} from "./functions";

export const showModalDialog = (elm, title, callback) => {
    if (checkClassList(elm, 'hidden')) {
        elm.classList.remove('hidden')

        if (typeof title !== "undefined") {
            if (title !== null) {
                const titleElm = elm.querySelector('.tw-modal-title')
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = title
                titleElm.replaceChildren(tempDiv)
            }
        }

        const event = new Event("show")
        elm.dispatchEvent(event)

        if (typeof callback !== "undefined") {
            callback()
        }
    }
}

export const closeModalDialog = (elm, callback) => {
    if (!checkClassList(elm, 'hidden')) {
        elm.classList.add('hidden')

        if (typeof callback !== "undefined") {
            callback()
        }

        const event = new Event("hidden")
        elm.dispatchEvent(event)
    }
}
