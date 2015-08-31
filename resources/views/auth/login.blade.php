@extends('templates.minimal')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 hidden-xs">
                <h1 style="margin-bottom: 0px;display: inline-block;padding-right: 7px;border-radius: 4px 4px 0px 0px;margin-left: 10px;" class="panel"><i class="glyphicon glyphicon-bookmark" style="font-size: 38px;"></i>bookmark
                </h1>
            </div>
            <div class="col-sm-6 col-sm-offset-3 hidden-xs">
                <div class="panel">
                    <div class="tabbable tabs-right clearfix">
                        <ul id="myTab1" class="nav nav-tabs" style="margin-left: 0px;">
                            <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                            <li><a href="#login" data-toggle="tab">Login</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="register" style="width: calc(100% - 88px);">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form method="post" action="register">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" value="register" name="action">
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="firstname">First name</label>
                                                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="form-group">
                                                        <label for="lastname">Last name</label>
                                                        <input type="text" class="form-control" name="lastname" id="lastname">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_txt">Password</label>
                                                <input type="text" class="form-control" data-bind="value: passwordPlainText" id="password_txt" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Re-type Password</label>
                                                <input type="password" class="form-control" name="password" data-bind="value: password"
                                                       id="password" required>
                                            </div>
                                            <button type="submit" data-bind="enable: passwordsMatch()" class="btn btn-primary btn-block">Register</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="login" style="width: calc(100% - 88px);">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form method="post" action="login">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" value="login" name="action">
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Re-type Password</label>
                                                <input type="password" class="form-control" name="password"
                                                       id="password" required>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="flat-checkbox-1">
                                                <label for="flat-checkbox-1">Remember me</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 visible-xs">
                <div class="panel">
                    <div class="tabbable tabs-right clearfix">
                        <ul id="myTab1" class="nav nav-tabs">
                            <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                            <li><a href="#login" data-toggle="tab">Login</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="register">
                            </div>
                            <div class="tab-pane fade" id="login">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            rePosition();

            $('.checkbox input').iCheck({
                checkboxClass: 'icheckbox_flat',
                increaseArea: '20%'
            });

            $(window).resize(function () {
                rePosition();
            });

            function rePosition() {
                var _main = $('.container');
                var h = $(window).height();
                var hMain = _main.height();
                _main.css('margin-top', ((h / 2) - (hMain / 2)) + 'px');
            }

            function LoginViewModel() {
                this.passwordPlainText = ko.observable("");
                this.password = ko.observable("");

                this.passwordsMatch = ko.computed(function(){
                    if (this.password()
                    && this.passwordPlainText()
                    && this.password() == this.passwordPlainText()) {
                        return true;
                    }
                    return false;
                },this);
            }

            ko.applyBindings(LoginViewModel());
        });
    </script>
@endsection