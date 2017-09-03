@extends('layouts.login')

@section('content')

<div class="c-head">
       <div class="logo">
              <img src="{{asset('images/logo.png')}}">
       </div> 
       <div class="name">
              <img src="{{asset('images/name.png')}}">
       </div> 
</div>
<div class="runbo">
   <img src="{{asset('images/runbo.jpg')}}">
</div>

<div class="container">      
    <form class="form-signin" action="" method="post">
        {{ csrf_field() }}
        <div class="login-head"><span>商家登录</span></div>    
        <div class="ins form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="inputUsername" class="sr-only">账号:</label>
            <input type="text" id="inputUsername" class="form-control" placeholder="请输入用户名" name="username" value="{{ old('username') }}"
                   required
                   autofocus>
           
        </div>

        <div class="ins form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="inputPassword" class="sr-only">密码:</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="请输入密码" name="password"
                   required>

        </div>
        <div>
             @if ($errors->has('username'))
                <span class="help-block">
                    {{ $errors->first('username') }}
                </span>
            @endif
             @if ($errors->has('password'))
                <span class="help-block">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>
        

       
        <div class="submit"><button class="btn btn-lg btn-primary" type="submit">立即登录</button></div>
    </form>

</div> 
 <!-- <div class="merchant">
     <div class="merchant-head">
               <span>HooSoo</span>
    </div>
    <div class="merchant-img">
           <div class="img i1">
                  <div class="txtusb">小蜗牛团队</div>
                  <div class="des">小蜗牛团队</div>
           </div>
           <div class="img i2">
                  <div>小蜗牛后台</div>
           </div>
           <div class="img i3"> 
                  <div>微信小程序</div>
           </div>    
    </div>
 </div> -->
@endsection