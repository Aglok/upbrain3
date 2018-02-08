<!-- Vk API -->
    $(function() {

        VK.init({apiId: 3058653}); // зарегистрировал VK-приложение
        // тут: https://vk.com/editapp?act=create
        // в Настройках нужно указать свой домен, откуда будет работать код
        $('#btn-auth').on('click' , function() {

            var that = $(this);
            VK.Auth.login(function (response) {
                var el = document.getElementById('gen-name');

                if (response.session) {

                    /* Пользователь успешно авторизовался */

                    if (response.session.mid && response.session.user) {
                        el.innerHTML = 'Привет, %USERNAME%!'
                            .replace('%USERNAME%', response.session.user.first_name + ' ' + response.session.user.last_name)
                            .replace('%UID%', response.session.user.id);
                        that.html('Запишите номер');


                        var user = response.session.user;

                        $.ajax({
                            type: 'POST',
                            url: 'prize',
                            data: {
                                "_token": $('input[name="csrf-token"]').attr('content'),
                                user_id:user.id,
                                domain:user.domain,
                                href:user.href,
                                first_name:user.first_name,
                                last_name:user.last_name,
                                nickname:user.nickname
                            },

                            success: function (date) {
                                //console.log(date);
                                $('#gen-code').html(date);
                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                console.log('Ошибка:' + errorThrown);
                            }
                        });

                    } else {
                        el.innerHTML = 'данные пользователя не пришли что-то';
                    }

                } else {
                    /* Пользователь нажал кнопку Отмена в окне авторизации */
                    el.innerHTML = 'Пользователь не согласился';
                }
            });
        });
    });
<!-- /Vk API -->