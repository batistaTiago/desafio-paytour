$(() => {
    $('input[type="file"').on('change', e => {
        const file = e.currentTarget.files[0];
        const label = $('.bt-file-input-container > label');
        const icon = label.children('i');
        const span = $('.bt-file-input-container span');

        if (!file) {
            // clicou em cancel
            icon.attr('class', 'fas fa-paperclip');
            span.html(`Clique aqui para carregar seu curriculo`);
            label.removeClass('has-file')
            return;
        }

        if ((file.size / 1024) > 1024) {
            // impede que arquivos maiores que 1MB sejam carregados
            alert('O tamanho maximo do arquivo é de 1MB');
            return;
        }

        label.addClass('has-file');
        icon.attr('class', 'fas fa-check');
        span.html(`Você selecionou o arquivo ${file.name}`);
    });

    $('#job-entry-form').on('submit', e => {
        const sender = $(e.currentTarget);
        const fileInput = sender.find('input[type="file"]');

        if (!fileInput.val()) {
            /* dispara animacao se nenhum arquivo tiver sido carregado */
            fileInput.closest('.bt-file-input-container').addClass('shake-animation');
        }
    });

    $('.bt-file-input-container').on('animationend', e => {
        /* remove o gatilho de animacao */
        $('.bt-file-input-container').removeClass('shake-animation');
    });
});