$(document).ready(function () {
    $(document).on('submit', '#formLogin', function (e) {
        e.preventDefault();
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json'
        })
        .done(function (data) {
            if (data) {
                location.reload();
            } else {
                $('.login-messages-password').text(Lang.get('auth.failed'));
                $('#email').css('border-color','red');
                $('#password').css('border-color','red');
                $('input[type=password]').val('');
            }
        })
        .fail(function (data) {
            if (data.responseJSON.email) {
                $('.login-messages').text(Lang.get('auth.failed_email'));
                $('#email').css('border-color','red');
            }

            if (data.responseJSON.password) {
                $('.login-messages-password').text(Lang.get('auth.failed_password'));
                $('#password').css('border-color','red');
            }

            $('input[type=password]').val('');
        });
    });
    $(document).on('submit', '#formRegister', function (e) {
        e.preventDefault();
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json'
        })
        .done(function (data) {
            if (data) {
                $('#modalRegister').modal('hide');
                $('#modalConfirm').modal('show');
            }
        })
        .fail(function (data) {
            var errors = JSON.parse(data.responseText);

            if (errors.name) {
                $('.name-messages').text(errors.name);
                $('#name').css('border-color', 'red');
            }

            if (errors.email) {
                $('#email-register').css('border-color', 'red');
                $('.email-messages').text(errors.email);
            }

            if ($.inArray(Lang.get('validation.confirmed', {'attribute' : 'password'}), errors.password) >= 0) {
                var errorsPasswordConfirmation = errors.password.slice(-1);
                errors.password = errors.password.slice(0, -1);
                $('#password-confirm').css('border-color', 'red');
            }

            if (errors.password) {
                $('#password-register').css('border-color', 'red');
                $('.password-messages').text(errors.password);
            }

            $('.password-confirmation-messages').text(errorsPasswordConfirmation);
            $('input[type=password]').val('');
        });
    });
    $(document).on('submit', '#formResetPassword', function (e) {
        e.preventDefault();
        $('.send-mail-success').addClass('hidden');
        $('.email-reset-messages').text('');
        $('.send-mail-fail').addClass('hidden');
        $('.spinner').removeClass('hidden');
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json'
        })
        .done(function (data) {
            $('.spinner').addClass('hidden');
            if (data) {
                $('.send-mail-success').removeClass('hidden');
                $('.send-mail-success').text(Lang.get('lang.send_mail_reset_password_success'));
            } else {
                $('.send-mail-fail').removeClass('hidden');
                $('.email-reset-messages').text(Lang.get('lang.email_user_not_exist'));
            }
        })
        .fail(function (data) {
            var errors = JSON.parse(data.responseText);
            $('.spinner').addClass('hidden');
            $('.send-mail-fail').removeClass('hidden');
            $('.email-reset-messages').text(errors.email);
        });
    });

    $(document).on('focus', '.reset-password-email', function () {
        $('.send-mail-fail').addClass('hidden');
    });

    if ($('input[name="confirmation-failed"]').val()) {
        $('#modalConfirm').find('.modal-content').empty();
        $('#modalConfirm').find('.modal-content').append(`
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                    <strong>${$('input[name="confirmation-failed"]').val()}</strong>
                </h3>
                <button type="button" class="close btn-close-form" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-4">
                <div class="text-center mb-3">
                    ${Lang.get('lang.email_user_not_exist')}
                </div>
            </div>`);
        $('#modalConfirm').modal('show');
    }
});
