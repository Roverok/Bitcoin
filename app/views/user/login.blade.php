<!DOCTYPE html>
<html>
<head>
    <title>登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style('css/bootstrap.min.css'); }}
    {{ HTML::style('css/main.css'); }}
    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/bootstrap.min.js'); }}
    {{ HTML::script('js/main.js')}}
</head>
<body class="login_body">
    <div class="login_block">
        <h2>比特币自动买卖系统</h2>
        <hr/>
        <div id="error-information" class="alert alert-danger"></div>
        <form role="form" id="login_form">
            <div class="form-group">
                <label for="InputUsername">用户名</label>
                <input type="text" class="form-control" id="InputUsername" placeholder="用户名">
            </div>
            <div class="form-group">
                <label for="InputPassword">密码</label>
                <input type="password" class="form-control" id="InputPassword" placeholder="密码">
            </div>
            <button type="submit" class="btn btn-info pull-right">登陆</button>
        </form>
    </div>
    <script>
    $(document).ready(function(e){
        // hide error information element
        $('#error-information').hide();
        // submit action if "enter" key pressed or mouse submit clicked 
        $('#login_form').submit(function(ev){
            var username = $('#InputUsername').val();
            var password = $('#InputPassword').val();
            if(username===''||password==='') {
                animationRefresh("用户名或密码不能为空.");
            }
            else {
                // send user credentials to backend
                ajaxSender(username, password);
            }
            // disable original submit action
            ev.preventDefault();
        });

        // send user credentials by ajax
        function ajaxSender(username, password) {
            var credentials = {
                'username': username,
                'password': password
            };
            sendAjax('/login',credentials, function(result){
                if (result==='Success') {
                    window.location.replace('/');
                } else {
                    $('#InputUsername').val('');
                    $('#InputPassword').val('');
                    animationRefresh(result);
                }            
            })
        }

        // animation show error message
        function animationRefresh(result) {
          var el=$('.login_block');
          var curHeight = el.height();
          $('#error-information').text(result).fadeIn('slow');
          var autoHeight=el.css('height','auto').height()+37;
          el.height(curHeight).animate({height: autoHeight}, 300);
        }      
    });
    </script>
</body>
</html>