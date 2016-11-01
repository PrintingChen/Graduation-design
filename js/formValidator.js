//jquery插件规范
//目的是通过匿名函数调用时传入参数创建闭包
(function(root,factory,plug){
	//调用闭包传入必要参数（jquery对象，插件名字）
	factory(root.jQuery,plug);
})(window,function($,plug){
	var __RULES__ = {
		"notempty":function(rules){
			var val = this.val();
			if(val==="")return false;
			return true;//return true代表验证成功，false验证失败
		},
		"regex":function(rules){
			return new RegExp(rules).test(this.val());
		},
		"equalto":function(rules){
			var val = this.val();
			var confirmVal = $(rules).val();
			return val===confirmVal;
		}
	};
	//通过jquery插件规范fn接口创建名叫plug的插件
	$.fn[plug] = function(){
		//this代表的是jquery的目标
		//获得当前表单中所有需要被验证的域的集合
		//dom对象和jquery对象是有区别
		//dom.className dom.setAttribute
		//$.addClass() $.attr()
		this.$fields = this.find("input,select,textarea").not("[type=button],[type=reset],[type=submit]");
		this.$fields.on("focus",function(){
			$(this).next().remove();
		}).on("blur",function(){
			var $field = $(this);
			var valid = true;
			$.each(__RULES__,function(key,func){
				var value = $field.data(key);
				if(value){
					//需要验证
					valid = func.call($field,value);
					//代表验证结果是假
					if(!valid){
						//console.log("需要验证["+key+"]规则,验证结果为："+valid);
						$field.removeClass("error success").addClass("error");
						$field.next().remove();
						$field.after("<div class=\"input-help error-message\"><p>"+$field.data(key+"-message")+"</p></div>");
						return false;
					}else{
						$field.removeClass("error success").addClass("success");
						$field.next().remove();
						$field.after("<div class=\"input-help success-message\"><p><i class='fa fa-check'></i></p></div>");
					}
				}
			});
		}).on("keyup",function(){
			var $field = $(this);
			var valid = true;
			$.each(__RULES__,function(key,func){
				var value = $field.data(key);
				if(value){
					//需要验证
					valid = func.call($field,value);
					//代表验证结果是假
					if(!valid){
						//console.log("需要验证["+key+"]规则,验证结果为："+valid);
						$field.removeClass("error success").addClass("error");
						$field.next().remove();
						$field.after("<div class=\"input-help error-message\"><p>"+$field.data(key+"-message")+"</p></div>");
						return false;
					}else{
						$field.removeClass("error success").addClass("success");
						$field.next().remove();
						$field.after("<div class=\"input-help success-message\"><p><i class=\"fa fa-check\"></i></p></div>");
					}
				}
			});
		});
	}
},"formValidator");
// <div class="input-help"><ul><li>请输入原始密码</li></ul></div>