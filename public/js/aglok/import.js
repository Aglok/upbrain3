$(function () {

    //Используем преобразование в select2
    $('#import-select').select2({
        placeholder: 'Выберите из списка раздел',
        allowClear: true
    });

    function displayOn() {

        var errorMsg, // сообщение об ошибке при валидации файла
            maxFileSize = 10 * 1024 * 1024; // (байт) Максимальный размер файла (10мб)

        // Валидация выбранного файла (формат, размер)
        var validateFile = function(file)
        {
            if (!file.name.match(/^(.*).(xls|xlsx|csv)/) ) {
                return 'Файл должен быть в формате xls, xlsx или csv';
            }

            if ( file.size > maxFileSize ) {
                return 'Размер файла не должен превышать 10 Мб';
            }
        };

        $('#import-select').change(function () {

            $('.import-file').css('display', 'block');

            $('#import-form').on('submit', function (event) {

                event.preventDefault();

                var formData = new FormData($(this).get(0));
                var file = $('#import-file').prop("files")[0];

                // Валидация файлов (проверяем формат и размер)
                if (errorMsg = validateFile(file) ) {
                    alert(errorMsg);
                    return;
                }

                swal.queue([{
                    title: 'Импортировать данные?',
                    html: $('<progress>')
                        .attr({value: 0, max: 100})
                        .addClass('progressbar')
                        .text('Загрузка файла'),
                    showCancelButton: true,
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет',
                    buttonsStyling: true,
                    showLoaderOnConfirm: true,

                    preConfirm: function () {

                        return new Promise(function (resolve) {

                            let progressBar = $('.progressbar');

                            $.ajax({
                                type: 'POST',
                                url: 'importExcel',
                                contentType: false, // важно - убираем форматирование данных по умолчанию
                                processData: false, // важно - убираем преобразование строк по умолчанию
                                data: formData,

                                xhr: function(){

                                    let xhr = $.ajaxSettings.xhr();

                                    xhr.upload.addEventListener('progress', function(event) {

                                        if(event.lengthComputable){

                                            progressBar.each(function(){

                                                var percent = Math.ceil(event.loaded/event.total*100);
                                                progressBar.val(percent);

                                            });
                                        }
                                    }, false);
                                    return xhr;
                                },
                                success: function(json){

                                    if(json){
                                        swal.insertQueueStep(json);
                                        progressBar.hide();
                                        resolve();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown)
                                {
                                    console.log('Ошибка:'+ errorThrown);
                                }
                            });

                        })
                    }
                }
                ]).catch(function (e) {
                    console.log(e);
                })
            });
        });
    }

    displayOn();
});