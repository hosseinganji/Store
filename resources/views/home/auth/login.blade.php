@extends('home.layouts.app')

@section('title')
    Login Page
@endsection

@section('script')
    <script>
        $("#otpCodeDiv").hide();
        $("#resendButtonOTP").hide();
        let loginToken;

        $("#phoneNumberForm").submit(function(event) {
            // console.log( $("#phoneNumber").val() );
            event.preventDefault();







            $.post("{{ url('/login') }}", {
                '_token': "{{ csrf_token() }}",
                'cellphone': $("#phoneNumber").val()

            }, function(response, status) {
                // console.log(response , status);
                loginToken = response.login_token;
                // console.log(loginToken);

                $("#phoneNumberDiv").remove();
                timer();
                $("#otpCodeDiv").fadeIn();

                $(document).bind("keypress", function(e) {
                    if (e.keyCode == 13) {
                        $("#login").click();
                        return false;
                    }
                });

            }).fail(function(response, status) {
                $("#inputErrorPhoneNumber").html(response.responseJSON.errors.cellphone[0]);
            })
        });

        $("#checkOTPForm").submit(function(event) {
            event.preventDefault();


            $.post("{{ url('/check-otp') }}", {
                '_token': "{{ csrf_token() }}",
                'otp': $("#checkOTPInput").val(),
                'login_token': loginToken,

            }, function(response, status) {
                $(location).attr('href', "{{ route('home.homepage') }}");

            }).fail(function(response, status) {
                $("#inputErrorOTP").html(response.responseJSON.errors.otp[0]);
            })
        });

        $("#resendButtonOTP").click(function(event) {
            event.preventDefault();

            $.post("{{ url('/resend-otp') }}", {
                '_token': "{{ csrf_token() }}",
                'login_token': loginToken

            }, function(response, status) {
                // console.log(response , status);
                loginToken = response.login_token;
                // console.log(loginToken);

                timer();
                $('#resendButtonOTP').fadeOut(1000);
                $('#spanTimerOTP').delay(1000).fadeIn();

            }).fail(function(response, status) {
                $("#inputErrorPhoneNumber").html(response.responseJSON.errors.cellphone[0]);
            })
        });

        function timer() {
            var timer2 = "2:01";
            var interval = setInterval(function() {
                var timer = timer2.split(':');
                //by parsing integer, I avoid all extra string processing
                var minutes = parseInt(timer[0], 10);
                var seconds = parseInt(timer[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;

                if (seconds == 0 && minutes == 0) {
                    clearInterval(interval);
                    $('#spanTimerOTP').fadeOut(1000);
                    $('#resendButtonOTP').delay(1000).fadeIn();
                }

                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;
                //minutes = (minutes < 10) ?  minutes : minutes;
                $('#spanTimerOTP').html(minutes + ':' + seconds);
                timer2 = minutes + ':' + seconds;
            }, 1000);
        }
    </script>
@endsection

@section('content')
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')

    <div class="col-lg-5 m-auto mb-5" id="phoneNumberDiv">
        <div class="contact-form bg-light p-30">
            <h1 class="h3 fw-bold mb-5 mx-auto text-center">ورود / ثبت نام</h1>

            <form id="phoneNumberForm">
                <div class="control-group">
                    <input type="text" id="phoneNumber" style="direction: rtl;" class="form-control"
                        placeholder="شماره همراه خود را وارد کنید...">
                    <p id="inputErrorPhoneNumber" class="help-block text-danger text-right mt-2"></p>
                </div>
                <div>
                    <button id="send" class="btn btn-primary py-2 px-4" type="submit">
                        ارسال
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5 m-auto mb-5" id="otpCodeDiv">
        <div class="contact-form bg-light p-30">
            <h1 class="h3 fw-bold mb-5 mx-auto text-center">کد تایید یکبار مصرف</h1>
            <form id="checkOTPForm">
                <div class="control-group">
                    <input type="text" id="checkOTPInput" style="direction: rtl;" class="form-control"
                        placeholder="کد تایید ارسال شده را وارد کنید...">
                    <p id="inputErrorOTP" class="help-block text-danger text-right mt-2"></p>
                </div>
                <div>
                    <span id="spanTimerOTP" class="bg-secondary"></span>
                    <button id="resendButtonOTP" class="btn btn-secondary py-2 px-4 float-start">ارسال مجدد</button>
                    <button id="login" class="btn btn-primary py-2 px-4" type="submit">ورود</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        #spanTimerOTP {
            float: right;
            padding: 10px 20px;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>






    @include('home.layouts.footer.footer')
@endsection
