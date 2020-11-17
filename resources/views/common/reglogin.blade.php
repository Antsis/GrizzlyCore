<!-- login&reg1 -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <!-- <div class="modal-header">
        </div> -->
        <div class="modal-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login-page" role="tab" aria-controls="login-page" aria-selected="true">登录</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="reg-tab" data-toggle="tab" href="#reg-page1" role="tab" aria-controls="reg-page1" aria-selected="false">注册</a>
                </li>
                <li class="nav-item ml-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="p-2" aria-hidden="true">&times;</span>
                    </button>
                </li>
              </ul>
              <!-- login -->
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active mt-2" id="login-page" role="tabpanel" aria-labelledby="login-tab">
                    
                    <form class="container-lg">
                        <div class="form-group">
                            <label for="login-phone">手机/邮箱/用户名</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="login-phone" placeholder="请输入手机号, 邮箱或者用户名"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="password" class="form-control" id="login-password" placeholder="请输入密码"/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="login_state" >
                            <label class="form-check-label" for="login_state">7天内自动登录</label>
                        </div>
                        <div class="form-group">
                            <small class="pr-2">使用其他账号登录:</small><a class="btn btn-primary btn-sm oauth-login" href="#" data-login-url="{{url('login/qqLogin')}}" ><img class="pr-1" src="{{asset('static/images/icons/Connect_logo_1.png')}}">使用QQ登录</a>
                        </div>
                        <small class="mt-2 mb-3 form-text text-muted">还没注册?<a href="#reg" onclick="document.getElementById('reg-tab').click()">点击注册</a></small>
                        <button id="login" type="submit" class="btn btn-primary btn-block mb-2" data-purl="{{url('login/login')}}">登录</button>
                        <button id="login-reset" type="reset" class="invisible position-absolute" aria-hidden="true"></button>
                    </form>
                </div>
                <!-- reg1 -->
                <div class="tab-pane fade mt-2" id="reg-page1" role="tabpanel" aria-labelledby="reg-tab">
                    <form class="container-lg">
                        <div class="form-group">
                            <label for="reg-phone-email">手机/邮箱</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="reg-phone-email" placeholder="请输入手机号或者邮箱"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code">验证码</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="code" placeholder="请输入验证码" maxlength="4" data-purl="{{url('login/checkCode')}}"/>
                                
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="refresh">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img id="code-img" src="{{ url('login/verify') }}" alt="captcha" onclick="this.setAttribute('src', '{{ url('login/verify') }}?id='+Math.random())" data-src="{{ url('login/verify') }}"></span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="reg-license">
                            <label class="form-check-label" for="reg-license">同意注册协议</label>
                            <div class="invalid-feedback">你必须同意注册协议</div>
                        </div>
                        <div class="form-group">
                            <small class="pr-2">使用其他账号登录:</small><a class="btn btn-primary btn-sm oauth-login" href="#" data-login-url="{{url('login/qqLogin')}}"  ><img class="pr-1" src="{{asset('static/images/icons/Connect_logo_1.png')}}">使用QQ登录</a>
                        </div>
                        <button id="reg-submit" type="submit" class="btn btn-primary btn-block mb-2" data-target="#staticBackdrop" data-purl="{{url('login/register')}}">注册</button>
                        <button id="reg-reset" type="reset" class="invisible position-absolute" aria-hidden="true"></button>
                    </form>
                </div>
            
            </div>
        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
    </div>
  </div>

  
  <!-- reg-page2 -->
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body ">
            <h4 class="text-center">填写验证码和密码完成注册</h4>
            <p class="text-center">验证码已发送至 <span id="feedback-phone-email"></span></p>
            
            <form class="container-lg">
                <div class="form-group">
                    <label for="sms-code">验证码</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="sms-code" placeholder="请输入6位验证码" maxlength="6"/>
                        <div class="input-group-prepend">
                            <button class="input-group-text" id="resend" type="button" data-purl="{{url('login/sendCodeSmsEmail')}}">重新发送验证码</button>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="reg-password">密码</label>
                    <input type="password" class="form-control" id="reg-password" placeholder="请输入8-20位字母/数字/符号,至少包含两种的密码"/>
                    <div class="invalid-feedback"></div>
                </div>
                <button id="reg-submit2" type="submit" class="btn btn-primary btn-block mb-2 mt-4" data-dismiss="modal" data-purl="{{url('login/register2')}}">完成</button>
                <button id="reg2-reset" type="reset" class="invisible position-absolute" aria-hidden="true"></button>
            </form>
        </div>
      </div>
    </div>
  </div>

  <!-- notice -->
  <!-- Modal -->
  <div class="modal fade" id="notice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">提示</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <p>登录成功!</p>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.reload()">关闭</button>
        </div>
    </div>
    </div>
</div>
