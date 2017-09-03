@extends('layouts.app')

@section('content')
    <h2 class="page-header">大数据分析</h3>
    <style>
         body{
	       background:#ddd;
         }
         .wel{
            width:100%;
         	height:300px;
         	border:1px solid #bbb;
         	background:#fff;
         	border-radius:20px;
         	color:#888;
            }
            .wel .span{
                  width:30%;
	            margin-left:100px;
            	font-size:20px;
            	float:left;
            	margin-top:40px;
            }
    </style>
    <div class="wel">
            <div class="span">
                                        今日访问量:{{$today_num}} 人
            </div>
            <div class="span">
                                        小程序总用户:{{$total}} 人
            </div>
            <div class="span">
                                        男性用户:{{$man_num}} 人
            </div>

            <div class="span">
                                        女性用户:{{$women_num}} 人
            </div>

    </div>
   
@endsection