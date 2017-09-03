
var album_params={};
var album_token = {};
//防止xss攻击
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	$("#pic_chosen").chosen({
		 no_results_text: "没有找到",
		max_selected_options:3,
		width:"100%"
	});
	
	
	$('.update_div').on('shown.zui.tab', function(e) {
		$(".chosen-select").chosen({
			 no_results_text: "没有找到",
			 max_selected_options:3,
			 width:"100%"
		});
	});
	
	




function album_commit(){
	var notice = alert_notice('图片正在上传中...','success');
	
	$.ajax({
		url:album_post_url,
		type:"post",	
		data:{
			'params':album_params,
			'category_id':category,
			'_album_id':album_id
			},
		dataType:'json',
		success:function(data){
			console.log(data);
			if(data.flag){
				alert_notice('图片上传成功','success');
				window.location.href = photo_list;
		 	}else{
		 		alert_notice(data.msg);
		 	}		 	
		},
		error:function(res){
			console.log(res);
		}
	});
		
}



$("#publish_album").click(function(){
	
	$(".input-group").removeClass("has-error");

	var files =  $('#albumUpload').fileinput('getFileStack');
	
	if(files.length<=0){
		$('#albumUpload').fileinput('_showError','请先上传文件');
		return false;
	}
	
	$(this).addClass("disabled");
	album_params.imgs=new Array();
	$("#albumUpload").fileinput("upload");
	
})

$("#albumUpload").fileinput({
    language: 'zh',
    showUpload: false,
    showRemove: false,
    showCancel: false,
    showUploadedThumbs:false,
    maxFileCount: 50,
    previewFileType: "image",
    allowedFileExtensions: ["jpg","jpeg", "png"],
    msgInvalidFileExtension: '不支持文件类型"{name}"。只支持扩展名为"{extensions}"的文件。',
    browseClass: "btn btn-primary",
    browseLabel: "选择本地图片",
    browseIcon: "<i class=\"icon icon-picture\"></i> ",
    removeClass: "btn btn-danger",
    removeLabel: "删除",
    removeIcon: "<i class=\"icon icon-trash\"></i> ",
    uploadUrl: up_url,
    uploadAsync: true,
    previewSettings: {
        image: {width: "auto", height: "100px"}
    },
    fileActionSettings: {},
    dropZoneTitle: "拖拽一组/单幅图片或点击下面按钮上传",
    textEncoding: "UTF-8",
   uploadExtraData: get_album_token
}).on('filepreajax',function(event,previewId,index){
	var files =  $('#albumUpload').fileinput('getFileStack');
	//构造每次请求的key
	var extraData = $("#albumUpload").fileinput('uploadExtraData');
	var name =files[index].name;
	extraData.key = album_token.prefix+generic_name()+name.substr(name.lastIndexOf("."));
	// $("#"+previewId).data("imgname",name);
	$("#"+previewId).data("imgsrc",extraData.key);

}).on("fileuploaded",function(event, data, previewId, index){
	//单个上传成功，保存key
	var obj = {};
	obj.index = index;
	obj.filename = data.files[index].name;
	obj.imgsrc = $("#"+previewId).data("imgsrc");
	album_params.imgs.push(obj);
}).on("filebatchuploadcomplete",function(){
	//全部上传成功
	album_token = {};
	album_commit();
	
}).on('fileloaded', function(event, file, previewId, index, reader) {
	  var type = file.type;
    if (type!="image/jpeg"&&type!="image/png"){
    	$.zui.messager.show("请选择格式为jpg,png的图片", {placement: 'center', type: 'success', time: '3000', icon: 'check'});
        $("#albumUpload").fileinput("clear");
    }
}); 


});


var cubeGroupIdx = 0;
var cubeGroupFiles = {};
function sixImgChoose(){
    var files = $('#sixUpload')[0].files;
    $(files).each(function(idx){
        checkImgWidthAndHeight1v1(this);
    });
    if(!_alreadyShowError){
        var sixImgGroups = {};
        if(files.length >= 6){
            $(files).each(function(idx){
                var fullName = this.name.substring(0,this.name.lastIndexOf('.'));
                var nameArr = fullName.split('_');
                if(nameArr.length == 2){
                    if(!sixImgGroups[nameArr[0]]){
                        sixImgGroups[nameArr[0]] = {};
                    }
                    sixImgGroups[nameArr[0]][nameArr[1]] = this;
                }else{
                     if(!sixImgGroups['']){
                        sixImgGroups[''] = {};
                    }
                    sixImgGroups[''][nameArr[0]] = this;
                }
            });
            //校验每个分组中的六个面命名是否规范
            var validateMsg = '';
            $.each(sixImgGroups,function(groupName,groupObj){
                var size = Object.getOwnPropertyNames(groupObj).length;
                if(size == 6){
                    if(validateCubeImgs(groupObj)){
                        //var cubeGroupIdx = Object.getOwnPropertyNames($('#imgUpload').fileinput('_getCubeFiles')).length;
                        var cubeGroupId = 'cube'+cubeGroupIdx++;
                        $('#imgUpload').fileinput('_appendCubeFiles',cubeGroupId,groupObj);
                        addCubePreview(cubeGroupId,groupName,groupObj);
                    }else{
                        validateMsg += '组（'+groupName+')的图片方位命名不符合规范，请参考命名规范。\n';
                        return false;
                    }
                }else{
                    validateMsg += '组（'+groupName+')的图片数量不为6，当前数量'+size+'张\n';
                    return false;
                }
            });
            if(validateMsg != ''){
                $.zui.messager.show(validateMsg, {placement: 'center',  time: '5000', icon: 'exclamation-sign'});
            }
        }else{
            $.zui.messager.show('需要6张1:1图片组成六面体，当前只有'+files.length+'张', {placement: 'center',  time: '5000', icon: 'exclamation-sign'});
        }
    }
}
var _alreadyShowError = false;
function checkImgWidthAndHeight1v1(file){
    var objUrl = window.URL || window.webkitURL;
    var url = objUrl.createObjectURL(file);
    var img = new Image();
    img.onload = function(){
        if(img.naturalWidth != img.naturalHeight){
            //$('#imgUpload').fileinput('_showError','六面体全景图片必须为1:1比例');
            $.zui.messager.show('六面体全景图片必须为1:1比例', {placement: 'center',  time: '5000', icon: 'exclamation-sign'});
            _alreadyShowError = true;
            objUrl.revokeObjectURL(url);
        }else{
            _alreadyShowError = false;
        }
    };
    img.src = url;
}
function validateCubeImgs(groupObj){
    if(groupObj.f && groupObj.b && groupObj.l && groupObj.r && groupObj.u && groupObj.d){
        return true;
    }
    return false;
}
function addCubePreview(cubeGroupId,groupName,groupObj){
    var html = '';
    var imgFile = groupObj.f ? groupObj.f : '';
    var objUrl = window.URL || window.webkitURL;
    var url = objUrl.createObjectURL(imgFile);
    html += '<div class="file-preview-frame" data-fileindex="1" data-cubeid="'+cubeGroupId+'">'+
        '<img class="file-preview-image" style="width:auto;height:100px;" alt="'+groupName+'"' +
        ' title="'+groupName+'" src="'+url+'">'+
        '<div class="file-thumbnail-footer">'+
        '<div class="file-footer-caption" title="'+groupName+'">'+groupName+'</div>'+
        '<div class="file-thumb-progress hide">'+
        '<div class="progress">'+
        '<div class="progress-bar progress-bar-success progress-bar-striped active" style="width:0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar"> 0% </div>'+
        '</div>'+
        '</div>'+
        '<div class="file-actions">'+
        '<div class="file-footer-buttons">'+
        '<button class="kv-file-remove2 btn btn-xs btn-default" title="删除文件" type="button">'+
        '<i class="icon icon-trash text-danger"></i>'+
        '</button>'+
        '</div>'+
        '<div class="clearfix"></div>'+
        '</div>'+
        '</div>'+
        '</div>';
    var files = $('#imgUpload').fileinput('getFileStack');
    if (files.length == 0){
        $(".file-preview").find(".file-drop-zone-title").remove();
        if($("#myContainer").length == 0){
            $(".file-preview").find(".file-preview-thumbnails").before("<div id = 'myContainer'></div>");
        }
        $("#myContainer").append(html);
    }else{
        $(".file-preview").find(".file-preview-thumbnails").append(html);
    }
}

function showCubeError(msg){
    $.zui.messager.show('六面体全景图片必须为1:1比例', {placement: 'center', type: 'danger', time: '5000', icon: 'exclamation-sign'});

}

function checkImgWidthAndHeight(width,height,previewId){
	if(width != 2*height){
	    $('#imgUpload').fileinput('_showError','球面全景图片必须为2:1比例');
	    return false;
	}
	return true;
}



function get_album_token() {	
	if (album_token.prefix) 
	{
		return album_token;
	}
	  $.ajax({
	  	url:act_token,
	  	type:'post',
	  	async : false,//设置成同步，才能对全局变量赋值
	  	data:{'act':"around"},
	  	dataType:'json',
	  	success:function(obj)
	  	{	  		
			if(obj.flag == 1)
			{
				album_token.prefix= obj.prefix;
				
				if (obj.token) 
					album_token.token = obj.token;				
				return album_token;
			}
			
	  	}
	  });	  
}

function generic_name() {
　　var $chars = 'abcdefghijklmnopqrstwxyz0123456789';  
　　var maxPos = $chars.length;
　　var pwd = '';
　　for (i = 0; i < 3; i++) {
　　　　pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
　　}
　　return new Date().getTime()+pwd;
}


function showerr(content,obj){
	alert_notice(content,'default','top');
	if(obj!=null){
		$(obj).parent(".input-group").addClass("has-error");
	}
}