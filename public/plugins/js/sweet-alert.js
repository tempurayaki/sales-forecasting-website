import Swal from "sweetalert2"

export const confirmAlert = (options, isConfirmFn, isCancelFn) => {
    Swal.fire({
        ...options,
    }).then((res) => {
        if (res.isConfirmed) {
            isConfirmFn()
            return false
        }

        if (typeof isCancelFn !== 'undefined') {
            if (res.isDenied || res.isDismissed) {
                isCancelFn()
                return false
            }
        }
    })
}

export const waitLoader = (title, html, didOpenCallback) => {
    return Swal.fire({
        html: `
            <b>${title}</b>
            <div>${html}</div>
        `,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        timerProgressBar: true,
        didOpen: async function () {
            Swal.showLoading();
            didOpenCallback()
        }
    })
}

export const successAlert = (options, isConfirmFn) => {
    Swal.fire({
        ...options,
        icon: 'success',
        allowOutsideClick: false
    }).then((res) => {
        if (res.isConfirmed) {
            if (typeof isConfirmFn !== 'undefined') {
                isConfirmFn()
            }
            return false
        }
    })
}

export const failureAlert = (options, isConfirmFn) => {
    Swal.fire({
        ...options,
        icon: 'error',
        allowOutsideClick: false
    }).then((res) => {
        if (res.isConfirmed) {
            if (typeof isConfirmFn !== 'undefined') {
                isConfirmFn()
            }
            return false
        }
    })
}

export const closeAlert = () => {
    Swal.close()
}

export const notifAlert = (options) => {
    Swal.fire({
        icon: 'success',
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        ...options
    })
}
