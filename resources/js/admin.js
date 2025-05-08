import { daterangeOptions, sanitizeDaterange } from "./config";
import Swal from "sweetalert2";

$(".form-check.has-sub-menu .form-check-input").on("click", function (e) {
    const isChecked = $(this).is(":checked");
    const $checkboxes = $(this)
        .closest(".parent-container")
        .find(".form-check-input");

    for (let i = 0; i < $checkboxes.length; i++) {
        const element = $checkboxes[i];
        if (isChecked) $(element).prop("checked", true);
        else $(element).prop("checked", false);
    }
});

$("._action-reset").on("click", (e) => {
    e.preventDefault();
    // clear input text
    $("form#filter input[type=text]").val("");
});

const getOptions1 = (date) => {
    let defaultOption = JSON.parse(JSON.stringify(daterangeOptions));
    if (date) {
        defaultOption.defaultDate = sanitizeDaterange(date);
    }
    return defaultOption;
};

$("form#privilege").submit(function (e) {
    // e.preventDefault();
    var arr = [];

    $("input:checked[name=pages]").each(function () {
        arr.push($(this).val());
    });

    $("#pages").val(arr.join(","));
    const data = $("#pages").val();
    console.log(data);
    // alert($('#my_match').val());

    // Prevent actual submit for demo purposes:
    // return false;
});

try {
    const $daterange_billing = flatpickr(
        "input.daterange",
        getOptions1(oldDate)
    );
} catch (error) {}

// PMK
$(".deleteRow").on("click", function (e) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            const id = $(this).data("id");
            document.getElementById(`deleteRow${id}`).submit();
        }
    });
});

// Add PMK
try {
    flatpickr("input#berlaku_dari", {
        altInput: true,
        altFormat: "d-M-Y",
    });
    flatpickr("input#berlaku_sampai", {
        altInput: true,
        altFormat: "d-M-Y",
    });
} catch (error) {}
