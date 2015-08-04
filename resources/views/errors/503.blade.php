@extends('templates.minimal')

@section('content')
    <div class="row" id="main">
        <div class="hidden-xs col-sm-6 col-sm-offset-3">
            <h1 style="margin-bottom:0px;"><i class="glyphicon glyphicon-bookmark" style="font-size: 38px;"></i>bookmark
            </h1>

            <div style="margin-left: 40px;">
                <h4 style="margin-top: 0px">
                    <p>is not feeling well today.</p>
                </h4>
                <h6>
                    <hr style="border-color: #4FC1E9;"/>
                    <p>Please feel free to check back later to see if we're back up.</p>

                    <p>If you feel that you've encountered this page in error, feel free to contact the <a
                                href="mailto:tyler.collette@gmail.com">webmaster</a>.
                    </p>
                </h6>
            </div>
        </div>

        <div class="visible-xs col-xs-12" style="display: inline-block; vertical-align: middle; float: none;">
            <h2 style="margin-bottom:0px;"><i class="glyphicon glyphicon-bookmark" style="font-size: 33px;"></i>bookmark
            </h2>

            <div style="margin-left: 35px">
                <h4 style="margin-top: 0px">
                    <p>is not feeling well today.</p>
                </h4>
                <h6>
                    <hr style="border-color: #4FC1E9;"/>
                    <p>Please feel free to check back later to see if we're back up.</p>

                    <p>If you feel that you've encountered this page in error, feel free to contact the <a
                                href="mailto:tyler.collette@gmail.com">webmaster</a>.
                    </p>
                </h6>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    $(document).ready(function(){
        rePosition();

        $(window).resize(function(){
            rePosition();
        });

        function rePosition() {
            var _main = $('#main');
            var h = $(window).height();
            var hMain = _main.height();
            _main.css('margin-top',((h/2)-(hMain/2)) + 'px');
        }
    });
@endsection