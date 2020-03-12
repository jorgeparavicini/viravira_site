const ui = {
    confirm: async (message) => createConfirm(message)
};

const createConfirm = (message) => {
    return new Promise((complete, failed) => {
        $('#confirmMessage').text(message);

        $('#confirmYes').off('click');
        $('#confirmNo').off('click');

        $('#confirmYes').on('click', () => {
            $('.confirm').hide();
            complete(true);
        })
        $('#confirmNo').on('click', () => {
            $('.confirm').hide();
            complete(false);
        })
        $('.confirm').show();
    });
};