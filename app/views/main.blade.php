<!DOCTYPE html>
<html>
<head>
    <title>Bitcoin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('/img/icon.png') }}">
    {{ HTML::style('css/bootstrap.min.css'); }}
    {{ HTML::style('css/main.css'); }}
    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/bootstrap.min.js'); }}
    {{ HTML::script('js/flot/jquery.flot.js'); }}
    {{ HTML::script('js/flot/jquery.flot.time.js'); }}
    {{ HTML::script('js/main.js'); }}
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class ="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Bitcoin 自动买卖系统</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a id="info_body_button" href="#">资料</a></li>
                    <li><a id="bid_body_button" href="#">买卖</a></li>
                    <li><a id="auto_body_button" href="#">自动控制</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a id="auto_status" href="#">自动: 关闭</a></li>
                    <li><a id="bid_value"></a></li>
                    <li><a id="ask_value"></a></li>
                    <li><a href="/logout">退出</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    <div id="info_body" class="container">
        <div class="row">
            <div id="account_info" class="col-md-4">
            </div>
            <div id="market_info" class="col-md-8">
            </div>
        </div>
    </div>
    <div id="bid_body" class="container">
        <div class="row">
            <div id="orders_info" class="col-md-12">
            </div>
            <div id="transactions_info" class="col-md-6">
            </div>
            <div id="deposits_info" class="col-md-6">
            </div>
        </div>
    </div>
    <div id="auto_body" class="container">
        @include ('auto_body')
    </div>
    <script>
    $(document).ready(function(){
        $('#bid_body').hide();
        $('#auto_body').hide();
        initProgramm();
        mainRefresh = setInterval(getMarketDepth2, frequency);
        $('#info_body_button').click(function(){
            $(this).parent('li').addClass('active');
            $('#bid_body_button, #auto_body_button').parent('li').removeClass('active');
            $('#bid_body, #auto_body').hide();
            $('#info_body').fadeIn('fast');
        });
        $('#bid_body_button').click(function(){
            $(this).parent('li').addClass('active');
            $('#info_body_button, #auto_body_button').parent('li').removeClass('active');
            $('#info_body, #auto_body').hide();
            $('#bid_body').fadeIn('fast');          
        });
        $('#auto_body_button').click(function(){
            $(this).parent('li').addClass('active');
            $('#info_body_button, #bid_body_button').parent('li').removeClass('active');
            $('#info_body, #bid_body').hide();
            $('#auto_body').fadeIn('fast');               
        });
        $('#auto_status').click(function(){
            if(auto_status) {
                var flag=confirm("您确定要关闭自动控制吗？ 如果关闭自动控制本系统将停止自动买卖。");
                if (flag) {
                    auto_status=0;
                    $('#auto_status_value, #auto_status').text('自动: 关闭');
                }
            } else {
                var flag=confirm("您确定要开启自动控制吗？ 如果开启自动控制本系统会自动下单买卖您的比特币。");
                if(flag) {
                    auto_status=1;
                    $('#auto_status_value, #auto_status').text('自动: 开启');
                }
            }
        });
    });
</script>
<!-- footer of page -->
<div class="navbar navbar-default navbar-fixed-bottom">
    <div class ="container">
        <p class="navbar-text pull-left">版权所有: 李渊</p>
    </div>
</div>
</body>
</html>