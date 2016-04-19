<!DOCTYPE html>
<html>
    <head>
        <title>DHT搜索</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ URL::asset('css/jqtree.css') }}"/>
        <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="{{ URL::asset('js/tree.jquery.js') }}"></script>
    </head>
    <body>
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading text-center">DHT搜索</div>
            <div class="panel-body">
                <div class="row">
                    <form onsubmit="onSubmit(); return false;" onkeydown="return key_down(event)">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" id="searchstr" class="form-control input-lg" placeholder="搜索2792125个资源..." @yield('query')>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-lg">搜索</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            @yield('listGroup')
        </div>
    </div>
    @yield('script')
    <script type="text/javascript">
        function onSubmit(e){
            var s=document.getElementById('searchstr').value;
            if(s=='') return false;
            window.location.href='/search/'+s+'/1';
        }
        function key_down(e){
            if(window.event)
                e = window.event;
            if((e.charCode||e.keyCode)=='13')
                onSubmit();
        }
    </script>
    </body>
</html>
