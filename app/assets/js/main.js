window.onload = function() {
	scrollMenu();
	$("#logForm").hide();   
	$("#user-forms a").click(function(e)
	{
		e.preventDefault();
		if($(this).hasClass("notsel"))
		 { 
		 	$("#user-forms a").addClass("notsel");           
		   	$(this).removeClass("notsel");
		   	$("#user-forms form").slideUp("fast");
		   	$("#"+ $(this).attr("href")).slideDown("slow");
	 	 }
	 });
	var regForm = new Vue({
		el: '#regForm',
		data: {
			regUser: '',
			regGmail: '',
			regPw1: '',
			regPw2: '',
			regGender: ''
		},
		methods: {
			checkReg: function(e){
				if(this.regUser.trim().length!=0&&this.regGmail.trim().length!=0&&this.regPw1.trim().length!=0&&this.regPw1.trim().length!=0&&(this.regPw1.trim()==this.regPw2.trim())&&this.regGender.trim()!=0){
					$.ajax({
						url:"app/Controllers/AJAXController.php",
						method:"POST",
						data: {
							action:"register",
							username:regUser.value,
							pw1:regPw1.value,
							pw2:regPw1.value,
							gmail:regGmail.value,
							gender:regGender.value
						},
						success:function(res,status,jqXHR){
							if(jqXHR.status==200){
								console.log(res);
							}
						},
						error:function(e){
							console.log(e);
						}
						
					});
				}
				e.preventDefault();
			}
		}
	});

	var logForm = new Vue({
		el: '#logForm',
		data: {
			logUser: '',
			logPw: ''
		},
		methods: {
			checkLog: function(e){
				if(this.logUser.trim().length!=0&&this.logPw.trim().length!=0){
					$.ajax({
						url:"app/Controllers/AJAXController.php",
						method:"POST",
						data: {
							action:"login",
							username:logUser.value,
							password:logPw.value
						},
						success:function(res,status,jqXHR){
							if(jqXHR.status==200){
								console.log(res);
							}
						},
						error:function(e){
							console.log(e);
						}
						
					});
				}
				e.preventDefault();
			}
		}
	});
}


	


