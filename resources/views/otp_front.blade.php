@include('layouts.partials.head')
<body>
<div class="container">
  <div class="row justify-content-md-center">
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-sm-12 mt-5 bgWhite">
            <div class="title">
              Verify OTP
            </div>
            
            <form method="post">
              @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <input class="otp" type="text" id="otp_dig1" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
                        <input class="otp" type="text" id="otp_dig2" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
                        <input class="otp" type="text" id="otp_dig3" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
                        <input class="otp" type="text" id="otp_dig4" oninput='digitValidate(this)'onkeyup='tabChange(4)' maxlength=1 >
                        <input class="otp" type="text" id="otp_dig5" oninput='digitValidate(this)' onkeyup='tabChange(5)' maxlength=1 >
                        <input class="otp" type="text" id="otp_dig6" oninput='digitValidate(this)'onkeyup='tabChange(6)' maxlength=1 >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" value="verify"  class='btn btn-primary btn-block mt-4 mb-4 customBtn' onclick="verify_otp()">
                    </div>
                </div>
            </form>
            
            
          </div>
        </div>
      </div>
  </div>
</div>
<!-- JavaScript Bundle with Popper -->
@include('layouts.partials.footer');