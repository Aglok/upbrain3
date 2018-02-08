$(function(){
    $('#user_upgrade_skills').on('click', function(){
        $.ajax({
            type: 'POST',
            url: location.href+'/user_upgrade_skills',
            data: {'upgrade': 'ok'}
        }).done(function (data) {
            infoChat($('.table-responsive'), data);
        });

    });
});
