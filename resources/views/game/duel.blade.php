{!! Html::script('js/owl.js') !!}
<div id="duel">
    <button onclick="(function(){duel.sendObj();})()">Начать</button>
</div>
<script>
    var duel;

    Duel = function (div) {
        var d = this;
        d.div = div;
        d.open_connection(function(){return 'Соединение прошло успешно!'});
    };
    Duel.prototype.open_connection = function (callback) {
        var d = this;

        this.connection = new WebSocket("ws://localhost:8080");

        this.connection.onopen = function() {
            if (callback) callback();
        };

        this.connection.onmessage = function(msg) {
                //var response = $.parseJSON(msg.data);
                //console.log("Полученные данные: " + msg.data);
                d.div.append(msg.data);
              //  d.message_func(response);
        };

        this.connection.onclose = function() {
            setTimeout(function(){d.open_connection();}, 5000);
        };

        this.connection.onerror = function (error) {
            console.log('WebSocket Error ' + error);
        };
    };

    Duel.prototype.send = function(data){
        this.connection.send(JSON.stringify(data));
    };

    Duel.prototype.message_func = function (response) {
        var d = this;
        d[response['function']](response);
    };

    Duel.prototype.sendObj= function(){

        var d = this;
        d.send({action:"find", id:{{Auth::id()}}, date:Date.now()});
        d.div.html('');
        //console.log(msg);
    };

    Duel.prototype.show_task= function(data){

        var d = this;
        d.div.html('');
        d.div.append($('\<input id="answer" type="text" value="">'), $('\<input type="submit" value="Отправить">').click(function(){d.send({action: "message", msg: $('#answer').val()})}));
        //console.log(msg);
    };

    $(document).ready(function(){
        duel = new Duel($('#duel'));
    });
</script>