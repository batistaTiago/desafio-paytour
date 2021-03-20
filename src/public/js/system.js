$(() => {
    $('main form').on('submit', e => {
        const sender = $(e.currentTarget);
        const button = sender.find('button[type="submit"]');
        button.attr('disabled', true);

        button.html('');

        const icon = $('<i>');
        icon.addClass('fa fa-spinner bt-basic-rotation');
        icon.css('color', 'white');

        button.html(icon);
    });

    $('main form input[type="tel"]').inputmask({
        mask: "+99 99 9-9999-9999",
        removeMaskOnSubmit: true
    });

    $('.bt-form-group > .bt-input-group > input, .bt-form-group > .bt-input-group > select').on('focus', e => {
        $(e.currentTarget).parent().addClass('bt-focused-custom-input');
    });

    $('.bt-form-group > .bt-input-group > input, .bt-form-group > .bt-input-group > select').on('blur', e => {
        $(e.currentTarget).parent().removeClass('bt-focused-custom-input');
    });
});