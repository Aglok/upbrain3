<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="{{csrf_token()}}" name="csrf-token" />
	<title>Личный кабинет</title>

	{!! Html::style('packages/sleepingowl/default/css/admin-app.css')!!}
	{{--Chat--}}
	{!! Html::style('css/aglok/growl.css')!!}
	{{--{!! Html::style('css/aglok/chat.css')!!}--}}
	{{--Common--}}
	{!! Html::style('css/aglok/profile.css')!!}

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="skin-blue sidebar-mini">
	<div class="wrapper" id="vueApp">
		@if(Auth::check())
			@include('users.topmenu')
			@include('users.sidebar')
		@endif
		@yield('content')
	</div>

	<!-- Pusher сообщения будут приходить участникам обсуждения и вставляться в чат-->
	@if(Auth::check())
		<script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			Pusher.logToConsole = true;
			var pusher = new Pusher('{{Config::get('pusher.appKey')}}');
			var channel = pusher.subscribe('for_user_{{Auth::id()}}');
			channel.bind('new_message', function(data) {
				var thread = $('.' + data.div_id);
				var thread_id = data.thread_id;
				var thread_plain_text = data.text;
				console.log(thread, data);
				if (thread.length) {
					// add new message to thread
					thread.append(data.html);

					// make sure the thread is set to read
					$.ajax({
						url: "/messages/" + thread_id + "/read"
					});
				} else {
					var message = '<p>' + data.sender_name + ' said: ' + data.text + '</p><p><a href="' + data.thread_url + '">View Message</a></p>';

					// notify the user
					$.growl.notice({ title: data.thread_subject, message: message });

					// set unread count
					$.ajax({
						url: "{{route('messages.unread')}}"
					}).success(function( data ) {
						var div = $('#unread_messages');

						var count = data.msg_count;
						if (count == 0) {
							$(div).addClass('hidden');
						} else {
							$(div).text(count).removeClass('hidden');

							// if on messages.index - add alert class and update latest message
							$('#thread_list_' + thread_id).addClass('alert-info');
							$('#thread_list_' + thread_id + '_text').html(thread_plain_text);
						}
					});
				}
			});
		</script>
	@endif
	{!! Html::script('packages/sleepingowl/default/js/admin-app.js')!!}
	{!! Html::script('packages/sleepingowl/default/js/vue.js')!!}
	{!! Html::script('packages/sleepingowl/default/js/modules.js')!!}
	{!! Html::script('js/aglok/common.js')!!}
	{{--{!! Html::script('js/aglok/chat.js')!!}--}}
	{!! Html::script('js/aglok/growl.js')!!}
	<script>
        $(document).ready(function() {

            $('#dataTable').DataTable({
                responsive: true,
                columnDefs: [
                    { "visible": false, "targets": 7 }
                ],
                drawCallback: function ( settings ) {
                    let api = this.api();
                    let rows = api.rows( {page:'current'} ).nodes();
                    let last=null;
                    let api_column = api.column(7, {page:'current'} ).data();

                    api.column(7, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="'+rows[i].cells.length+'"><b>'+group+'</b></td></tr>'
                            );

                            last = group;
                        }
                    });
                }
			});
        } );
	</script>
</body>

</html>
