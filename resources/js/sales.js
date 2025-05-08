import { closeModalDialog, showModalDialog } from "../../public/plugins/js/modal";
import { confirmAlert, failureAlert, successAlert, waitLoader } from "../../public/plugins/js/sweet-alert";
import { getMetaContent, responseMessages, showHiddenElmAndText } from "../../public/plugins/js/functions";
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function (){
    const csrfToken = getMetaContent('csrf-token')
    const closeModalForm = document.querySelectorAll('.closeModalForm')
    const btnPencarian = document.querySelector('.btnPencarian')
    const modalPencarian = document.querySelector('.modalPencarian')
    
    const btnTambah = document.querySelector('.btnTambah')
    const modalForm = document.querySelector('.modalForm')
    const tanggal = modalForm.querySelector('.tanggal')
    const dateError = modalForm.querySelector('.dateError')
    const nama_produk = modalForm.querySelector('.nama_produk')
    const productError = modalForm.querySelector('.productError')
    const subtotal = modalForm.querySelector('.subtotal')
    const subtotalError = modalForm.querySelector('.subtotalError')
    const kategori = modalForm.querySelector('.kategori')
    const kategoriError = modalForm.querySelector('.kategoriError')
    const btnSimpan = modalForm.querySelector('.btnSimpan')
    const btnHapus = modalForm.querySelector('.btnHapus')
    const dataTables = document.querySelectorAll('.data-tables')

    const btnSort = document.querySelector('.btnSort')
    const modalSort = document.querySelector('.modalSort')
    const sortBy = modalSort.querySelector('.sortBy')
    const sortAs = modalSort.querySelector('.sortAs')
    const btnApplySort = modalSort.querySelector('.btnApplySort')

    let url = new URL(window.location.href)

    //region Handle Close Modal
    closeModalForm.forEach((elm) => {
        if (modalPencarian) {
            elm.addEventListener('click', function () {
                closeModalDialog(modalPencarian)
            })
        }

        if (modalSort) {
            elm.addEventListener('click', function () {
                closeModalDialog(modalSort)
            })
        }

        if (modalForm) {
            elm.addEventListener('click', function () {
                closeModalDialog(modalForm, () => {
                    
                })
            })
        }
    })
    //endregion

    //region Handle Pencarian
    if (btnPencarian) {
        btnPencarian.addEventListener('click', function () {
            showModalDialog(modalPencarian, null, () => {
                const segmentUrl = modalPencarian.querySelector('.segmentUrl')
                const btnResetPencarian = modalPencarian.querySelector('.btnResetPencarian')
                const btnCari = modalPencarian.querySelector('.btnCari')

                modalPencarian.addEventListener('keypress', function (ev) {
                    if (ev.key === 'Enter') {
                        $(btnCari).trigger('click');
                    }
                })

                btnCari.addEventListener('click', function () {
                    const elmPencarian = modalPencarian.querySelectorAll('[name]')
                    const text_result = []
                    elmPencarian.forEach((elm) => {
                        const elmNames = elm.getAttribute('name')
                        if (elm.value !== '')
                            text_result.push(`${elmNames}=${elm.value}`)
                    })

                    window.location = `${segmentUrl.value}?${text_result.join('&')}`
                })

                btnResetPencarian.addEventListener('click', function () {
                    window.location = `${segmentUrl.value}`
                })
            })
        })
    }
    //endregion

    //region Handle Sort
    if (btnSort) {
        btnSort.addEventListener('click', function () {
            showModalDialog(modalSort, null, () => {
                const segmentUrl = modalSort.querySelector('.segmentUrl')
                const btnResetSort = modalSort.querySelector('.btnResetSort')

                btnApplySort.addEventListener('click', function () {
                    window.location = `${segmentUrl.value}?sort-by=${sortBy.value}&sort-as=${sortAs.value}`
                })

                btnResetSort.addEventListener('click', function () {
                    window.location = `${segmentUrl.value}`
                })
            })
        })
    }
    //endregion

    //region Handle Store
    if (btnTambah) {
        btnTambah.addEventListener('click', function () {
            showModalDialog(modalForm, '<i class="fas fa-plus-circle mr-2"></i> Tambah Data', () => {
                btnSimpan.addEventListener('click', function () {
                    confirmAlert({
                        title: 'Konfirmasi',
                        html: 'Apakah anda akan membuat data baru?',
                        confirmButtonText: 'Ya, Simpan',
                        showDenyButton: true,
                        denyButtonText: 'Tidak'
                    }, async () => {
                        await waitLoader('Mohon Tunggu...', 'Menyimpan Data Baru', async () => {
                            const response = await fetch('/sales/store', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    tanggal: tanggal.value,
                                    nama_produk: nama_produk.value,
                                    subtotal: subtotal.value,
                                    kategori: kategori.value,
                                    
                                }),
                            })

                            await handleResponse(response)
                        })
                    })
                })
            })
        })
    }
    //endregion

    //region Handle Update & Delete
    if (dataTables) {
        dataTables.forEach((item) => {
            const btnEdit = item.querySelector('.btnEdit')
            const dataId = item.getAttribute('data-id')

            if (btnEdit) {
                $(btnEdit).on('click', function () {
                    showModalDialog(modalForm, '<i class="fas fa-edit mr-2"></i> Update Data', async () => {

                        //region Handle Detail Data
                        await waitLoader('Mohon Tunggu...', 'Mengambil Data', async () => {
                            const response = await fetch('/sales/detail', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    id: dataId
                                })
                            })

                            const {status} = response
                            const {message, data} = await response.json()
                            if (status === 200) {
                                if (data !== null) {
                                    // console.log
                                    Swal.close()
                                    const {
                                        tanggal,
                                        nama_produk,
                                        subtotal,
                                        kategori,
                                    } = data

                                    tanggal.value = tanggal
                                    nama_produk.value = nama_produk
                                    subtotal.value = subtotal
                                    kategori.value = kategori
                                    

                                } else {
                                    closeModalDialog(modalForm)
                                    failureAlert({
                                        title: 'Oppss!',
                                        html: 'Data tidak ditemukan!'
                                    })
                                }
                            } else {
                                closeModalDialog(modalForm)
                                failureAlert({
                                    title: 'Oppss!',
                                    html: message
                                })
                            }
                        })
                        //endregion

                        //region Handle Update
                        $(btnSimpan).off('click').on('click', function () {
                            confirmAlert({
                                title: 'Konfirmasi',
                                html: 'Apakah anda akan mengubah data?',
                                confirmButtonText: 'Ya, Simpan',
                                showDenyButton: true,
                                denyButtonText: 'Tidak'
                            }, async () => {
                                await waitLoader('Mohon Tunggu...', 'Menyimpan perubahan data', async () => {
                                    const response = await fetch('/sales/update', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            id: dataId,
                                            tanggal: tanggal.value,
                                            nama_produk: nama_produk.value,
                                            subtotal: subtotal.value,
                                            kategori: kategori.value
                                        }),
                                    })

                                    await handleResponse(response)
                                })
                            })
                        })
                        //endregion

                        if (btnHapus) {
                            showHiddenElmAndText(btnHapus)
                            $(btnHapus).off('click').on('click', function () {
                                confirmAlert({
                                    title: 'Konfirmasi',
                                    html: 'Apakah anda akan menghapus data?',
                                    confirmButtonText: 'Ya, Hapus',
                                    showDenyButton: true,
                                    denyButtonText: 'Tidak'
                                }, async () => {
                                    await waitLoader('Mohon Tunggu...', 'Menghapus data', async () => {
                                        const response = await fetch('/sales/delete', {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            },
                                            body: JSON.stringify({
                                                id: dataId
                                            })
                                        })

                                        await handleResponse(response)
                                    })
                                })
                            })
                        }

                    })
                })
            }
        })
    }
    //endregion

    //region Handle Response Data
    const handleResponse = async (response) => {
        const {status} = response
        const {message, errorValidation} = await response.json()
        if (status === 200) {
            closeModalDialog(modalForm)
            successAlert({
                title: 'Berhasil',
                html: message,
                confirmButtonText: 'Tutup'
            }, () => {
                window.location.reload()
            })
        } else {
            if (errorValidation) {
                failureAlert({
                    title: 'Oppss!!',
                    html: 'Ada data yang belum lengkap!',
                    confirmButtonText: 'Tutup'
                })

                const {
                    tanggal,
                    nama_produk,
                    subtotal,
                    kategori
                } = errorValidation

                responseMessages(tanggalError, tanggal)
                responseMessages(productError, nama_produk)
                responseMessages(subtotalError, subtotal)
                responseMessages(kategoriError, kategori)

            } else {
                failureAlert({
                    html: message,
                    confirmButtonText: 'Tutup'
                })
            }
        }
    }
    //endregion
})