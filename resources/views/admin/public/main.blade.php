<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{ staticAdmin() }}static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ staticAdmin() }}static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="{{ staticAdmin() }}lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="{{ staticAdmin() }}static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{ staticAdmin() }}static/h-ui.admin/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/css/pagination.css" />

    <title>我的桌面</title>
    @yield('css')
</head>
<body>
@yield('cnt')
<script type="text/javascript" src="{{ staticAdmin() }}lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ staticAdmin() }}lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="{{ staticAdmin() }}static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="{{ staticAdmin() }}static/h-ui.admin/js/H-ui.admin.js"></script>
@yield('js')
</body>
</html>
