import {getDeviceConfig} from "./breakpoint";
import { Popover } from 'flowbite';


export const checkClassList = (elm, searchClassName) => {
    return elm.classList.contains(searchClassName)
}

export const showHiddenElmAndText = (elm, elmText, text) => {
    if (checkClassList(elm, 'hidden')) {
        elm.classList.remove('hidden')
        if (typeof elmText !== 'undefined') {
            if (typeof text !== 'undefined') {
                elmText.innerHTML = text
            }
        }
    }
}

export const hiddenElm = (elm) => {
    if (!checkClassList(elm, 'hidden'))
        elm.classList.add('hidden')
}

export const getMetaContent = (metaName) => {
    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === metaName)
            return metas[i].getAttribute('content')
    }
    return undefined
}

export const formatter = new Intl.NumberFormat('en-US')

export function tableTooltip(trigger) {
    let triggerType = 'hover'
    if (typeof trigger !== 'undefined') {
        triggerType = trigger
    }

    const useTooltip = document.querySelectorAll('table.tw-table tr td')
    if (useTooltip) {
        useTooltip.forEach((elm, index) => {
            if (elm.offsetWidth < elm.scrollWidth) {
                const title = $(elm).closest('table').find('th').eq($(elm).index())[0].innerText
                const textContent = $(elm).html()
                const classList = elm.classList.value
                $(elm).replaceWith(`
                    <td class="${classList}">
                        <div class="flex items-center">
                            <div class="truncate popover-trigger" id="xx-${index}" data-popover-target="popover-default-${index}" data-popover-placement="right" data-popover-trigger="${triggerType}">
                                ${textContent}
                            </div>
                            <div class="!text-[11px] text-gray-400 ml-2">
                                <i class="fas fa-question-circle"></i>
                            </div>
                        </div>
                        <div data-popover id="popover-default-${index}" role="tooltip" class="absolute z-10 inline-block w-64 text-sm text-gray-500 duration-300 bg-white border border-gray-200 rounded-lg shadow-sm invisible transition-opacity opacity-0">
                            <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                                <span class="font-semibold text-gray-900 !text-[15px]">${title}</span>
                            </div>
                            <div class="px-3 py-2">
                                <p class="overflow-auto" style="white-space: normal; max-height: 200px;">${textContent}</p>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                    </td>
                `)
            }
        })
    }
}

export const triggerTableTooltip = (trigger) => {
    let triggerType = 'hover'
    if (typeof trigger !== 'undefined') {
        triggerType = trigger
    }
    const popoverTrigger = document.querySelectorAll('.popover-trigger')
    popoverTrigger.forEach((elm) => {
        const indexElm = elm.getAttribute('data-popover-target').split('-')[2]
        const targetElm = document.getElementById(`popover-default-${indexElm}`)
        const options = {
            placement: 'right',
            triggerType: triggerType,
            offset: 0,
        }

        new Popover(targetElm, elm, options)
    })
}

export function handleFixedTheadTh() {
    const tableFixedTh = document.querySelectorAll('table thead tr th[data-sticky]')
    if (tableFixedTh) {
        tableFixedTh.forEach((elm) => {
            const lw = elm.getAttribute('data-sticky-lw')
            const rw = elm.getAttribute('data-sticky-rw')
            const bpExclude = elm.getAttribute('data-sticky-bp-ex')
            const classListLw = `sticky border-left`
            const classListRw = `sticky border-right`
            renderFixedTable(elm, bpExclude, lw, rw, classListLw, classListRw)
        })
    }
}

export function handleFixedTd() {
    const tableFixedTd = document.querySelectorAll('table tr td[data-sticky]')
    if (tableFixedTd) {
        tableFixedTd.forEach((elm) => {
            const lw = elm.getAttribute('data-sticky-lw')
            const rw = elm.getAttribute('data-sticky-rw')
            const bpExclude = elm.getAttribute('data-sticky-bp-ex')
            const classListLw = `sticky-td border-left`
            const classListRw = `sticky-td border-right`
            renderFixedTable(elm, bpExclude, lw, rw, classListLw, classListRw)
        })
    }
}

export function handleFixedTfootTh() {
    const tableFixedTh = document.querySelectorAll('table tfoot tr th[data-sticky]')
    if (tableFixedTh) {
        tableFixedTh.forEach((elm) => {
            const lw = elm.getAttribute('data-sticky-lw')
            const rw = elm.getAttribute('data-sticky-rw')
            const bpExclude = elm.getAttribute('data-sticky-bp-ex')
            const classListLw = `border-left`
            const classListRw = `border-right`
            renderFixedTable(elm, bpExclude, lw, rw, classListLw, classListRw)
        })
    }
}

function renderFixedTable(elm, bpExclude, lw, rw, classListLw, classListRw) {
    if (bpExclude) {
        if (bpExclude.split(',').indexOf(getDeviceConfig(window.innerWidth)) === -1) {
            if (lw) {
                $(elm).addClass(classListLw)
                $(elm).css('left', lw).css('z-index', 10)
            }
            if (rw) {
                $(elm).addClass(classListRw)
                $(elm).css('right', rw)
            }
        } else {
            if (lw) {
                $(elm).removeClass(classListLw)
                $(elm).removeAttr('style')
            }
            if (rw) {
                $(elm).removeClass(classListRw)
                $(elm).removeAttr('style')
            }
        }
    } else {
        if (lw) {
            $(elm).addClass(classListLw)
            $(elm).css('left', lw)
            $(elm).css('left', lw).css('z-index', 10)
        }
        if (rw) {
            $(elm).addClass(classListRw)
            $(elm).css('right', rw)
        }
    }
}

export const renderPagination = (response, renderData, parentModal, options) => {
    const pagiLabelFrom = parentModal.querySelector('.pagiLabelFrom')
    const pagiLabelTo = parentModal.querySelector('.pagiLabelTo')
    const pagiLabelTotal = parentModal.querySelector('.pagiLabelTotal')
    const pagiPrevLink = parentModal.querySelector('.pagiPrevLink')
    const pagiLoopLink = parentModal.querySelector('.pagiLoopLink')
    const pagiNextLink = parentModal.querySelector('.pagiNextLink')

    const {links, next_page_url, prev_page_url, from, to, total} = response
    $(pagiLabelFrom).html(formatter.format(from))
    $(pagiLabelTo).html(formatter.format(to))
    $(pagiLabelTotal).html(formatter.format(total))

    //region Handle Pagination Prev Button
    let pagiPrev = `
        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-l-md leading-5" aria-hidden="true">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </span>
        </span>
    `
    if (prev_page_url !== null) {
        pagiPrev = `
            <a data-url="${prev_page_url}" rel="prev" class="pagiPrevActive cursor-pointer relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
        `
    }
    $(pagiPrevLink).html(pagiPrev)
    const pagiPrevActive = parentModal.querySelectorAll('.pagiPrevActive')
    if (pagiPrevActive) {
        pagiPrevActive.forEach((item) => {
            item.addEventListener('click', function () {
                const dataUrl = this.dataset.url
                renderData({
                    ...options,
                    url: dataUrl
                })
            })
        })
    }
    //endregion

    //region Handle Pagination Next Button
    let pagiNext = `
        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-r-md leading-5" aria-hidden="true">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </span>
        </span>
    `
    if (next_page_url !== null) {
        pagiNext = `
            <a data-url="${next_page_url}" rel="next" class="pagiNextActive cursor-pointer relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
        `
    }
    $(pagiNextLink).html(pagiNext)
    const pagiNextActive = parentModal.querySelectorAll('.pagiNextActive')
    if (pagiNextActive) {
        pagiNextActive.forEach((item) => {
            item.addEventListener('click', function () {
                const dataUrl = this.dataset.url
                renderData({
                    ...options,
                    url: dataUrl
                })
            })
        })
    }
    //endregion

    //region Handle Pagination Loop Button
    const pagiLink = []
    links.map((item, index) => {
        const {url, label, active} = item
        if (index !== 0 && index !== links.length - 1) {
            // const loopUrl = url !== null ? url : next_page_url
            let pLink = `
                <a data-url="${url}" class="pagiLinkActive cursor-pointer relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-200 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => ${label}]) }}">
                    ${label}
                </a>
            `
            if (active) {
                pLink = `
                    <span aria-current="page">
                        <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-white bg-green-1 border border-gray-300 cursor-default leading-5">
                            ${label}
                        </span>
                    </span>
                `
            }
            pagiLink.push(pLink)
        }
    })

    // @ts-ignore
    $(pagiLoopLink).html(pagiLink)
    const pagiLinkActive = parentModal.querySelectorAll('.pagiLinkActive')
    if (pagiLinkActive) {
        pagiLinkActive.forEach((elm) => {
            const dataUrl = elm.getAttribute('data-url')
            if (dataUrl !== 'null') {
                elm.addEventListener('click', async function () {
                    renderData({
                        ...options,
                        url: dataUrl
                    })
                })
            }
        })
    }
    //endregion
}

export function responseMessages(elm, messages) {
    $(elm).html(null)
    if (messages) {
        if (messages.length !== 0) {
            messages.map((item) => {
                $(elm).append(`
                    <li class="info-alert-text error">
                        <div><i class="fas fa-exclamation-circle mr-1"></i></div>
                        <div>${item}</div>
                    </li>
                `)
            })
        }
    }
}

export function inArray(haystack, find) {
    return haystack.indexOf(find) !== -1;
}

export function nFormatter(num, digits) {
    const lookup = [
        { value: 1, symbol: "" },
        { value: 1e3, symbol: "rb" },
        { value: 1e6, symbol: "Jt" },
        { value: 1e9, symbol: "M" },
        { value: 1e12, symbol: "T" },
        { value: 1e15, symbol: "P" },
        { value: 1e18, symbol: "E" }
    ];
    const regexp = /\.0+$|(?<=\.[0-9]*[1-9])0+$/;
    const item = lookup.findLast(item => num >= item.value);
    return item ? (num / item.value).toFixed(digits).replace(regexp, "").concat(item.symbol) : "0";
}

export function nFormatterMetrixTon(num, digits) {
    const lookup = [
        { value: 1, symbol: "" },
        { value: 1e3, symbol: "MT" },
        { value: 1e6, symbol: "MT" },
        { value: 1e9, symbol: "MT" },
        { value: 1e12, symbol: "MT" },
        { value: 1e15, symbol: "MT" },
        { value: 1e18, symbol: "MT" }
    ];
    const regexp = /\.0+$|(?<=\.[0-9]*[1-9])0+$/;
    const item = lookup.findLast(item => num >= item.value);
    return item ? (num / item.value).toFixed(digits).replace(regexp, "").concat(item.symbol) : "0";
}

// formatDate('2024-12-22', true); // Output: 22 Desember 2024
// formatDate('22 Desember 2024', false); // Output: 2024-12-22
export const formatDate = (dateString, toIndonesianFormat = true) => {
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    if (toIndonesianFormat) {
        const [y, m, d] = dateString.split('-');
        return `${d} ${months[parseInt(m)-1]} ${y}`;
    } else {
        let dateParts = dateString.split(' ');
        let monthIndex = months.indexOf(dateParts[1]);
        if (monthIndex === -1) {
            throw new Error('Nama bulan tidak dikenali');
        }

        const [d, m, y] = dateString.split(' ');
        return `${y}-${months.indexOf(m.slice(0,3))+1}-${d}`;
    }
}

// yearsBefore => mundur brp thn
// yearsAfter => maju brp thn
export const yearBounds = (yearsBefore, yearsAfter) => {
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    var yearFromNow = new Date(today);
    yearFromNow.setFullYear(yearFromNow.getFullYear() + yearsAfter);
    var yearAgo = new Date(today);
    yearAgo.setFullYear(yearAgo.getFullYear() - yearsBefore);

    return { minDate: yearAgo, maxDate: yearFromNow };
};

export const calculateAndSetDifference = (optionsArray) => {
    optionsArray.forEach(options => {
        const { penetapanSelector, pemberitahuanSelector, selisihSelector, convertToFloat = true } = options;

        $(penetapanSelector).on('input', function() {
            let val = this.value;
            this.value = val.replace(/[^0-9.\-]/g, '');

            if (this.value.startsWith('-') && this.value.length === 1) {
                this.value = '';
            }

            let penetapan = convertToFloat ? parseFloat(this.value) || 0 : this.value;
            let pemberitahuan = convertToFloat ? parseFloat($(pemberitahuanSelector).val()) || 0 : $(pemberitahuanSelector).val();
            let selisih = penetapan - pemberitahuan;

            $(selisihSelector).val(selisih.toFixed(2));
        });

        $(pemberitahuanSelector).on('input', function() {
            let val = this.value;
            this.value = val.replace(/[^0-9.\-]/g, '');

            if (this.value.startsWith('-') && this.value.length === 1) {
                this.value = '';
            }
        });

        $(selisihSelector).on('input', function() {
            let val = this.value;
            this.value = val.replace(/[^0-9.\-]/g, '');

            if (this.value.startsWith('-') && this.value.length === 1) {
                this.value = '';
            }
        });
    });
}

// locale = 'id-ID'/'en-EN'
export const formatCurrency = (number, locale = false, currency = 'IDR', fractionDigit = 0) => {
    const formatOptions = locale === false ?
        {
            style: 'decimal',
            minimumFractionDigits: fractionDigit,
            maximumFractionDigits: fractionDigit,
        } :
        {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: fractionDigit,
            maximumFractionDigits: fractionDigit,
        };

    const formatter = new Intl.NumberFormat(locale !== false ? locale : undefined, formatOptions);
    const roundUp = Math.ceil(number / 1000) * 1000;

    return formatter.format(roundUp);
};

export const roundTo1000 = (number) => {
    const result = Math.ceil(number / 1000) * 1000;
    return result.toFixed(2);
}
