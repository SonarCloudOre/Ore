$(document).ready(() => {
    setTimeout(function () {
        $('.multiselect-dropdown').select2({
            theme: 'bootstrap4',
            placeholder: 'Select an option',
        });
        $('.multiselect-dropdown:not(.no-open)').select2('open');
    }, 10);
});
