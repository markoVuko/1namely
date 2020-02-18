window.onload = function() {
	
	localStorage.removeItem("x");
	localStorage.removeItem("userposts");
	if(document.getElementById("profile-page")==null){
		fillGlobalFeed();
	}
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
	$("#setsub").click(function(e){
		e.preventDefault();
		editUser();
	});

	$("#subpost").click(function(e){
		e.preventDefault();
		submitPost();
	});
	
	$("#settingslink").click(function(e){
		e.preventDefault();
		$("#modal").css("display","block");
	});

	window.onclick = function(event) {
	  if (event.target.id == "modal") {

	    $("#modal").css("display","none");
	  }
	}

	showYourPosts();

	$(window).scroll(function() {
	  if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
		var x = localStorage.getItem("x");
	    if(x){
	    	seeMorePosts();
	    }
	  }
		});
	$(document).on("click", ".username-link",function(e){
		e.preventDefault();
		fillThing($(this).data("id"));
		$("#modal").css("display","block");
	});

	$(document).on("click","#follow-link",function(e){
		e.preventDefault();
		toggleFollow($(this).html());
	});

	$("#fl-followed").click(function(e){
		e.preventDefault();
		showFollowedPosts();
	});

	$("#fl-global").click(function(e){
		e.preventDefault();
		fillGlobalFeed();
	});

	$("#iusub").click(function(e){
		e.preventDefault();
		insertUser();
	});

	$("#saveUser").click(function(e){
		e.preventDefault();
		adminEdit();
	});

	$(document).on("change","#euname",function(e){
		fillEditForm($(this).val());
	});
	
	$("#submit-contact").click(validate);
	$("#contact-form").submit(function(e){
		e.preventDefault();
	});

	$(".feed-content").hide();
	$(".feed-block a").click(function(e)
	{
		e.preventDefault();
		if($(this).hasClass("notsel"))
		 { 
		 	$(".feed-block a").addClass("notsel");    
		 	$(".feed-block a").html("Open");       
		   	$(this).removeClass("notsel");
		   	$(this).html("Close");
		   	$(".feed-content").slideUp("fast");
		   	$("#"+ $(this).attr("href")).slideDown("slow");
	 	 } else {

		   	$("#"+ $(this).attr("href")).slideUp("slow");           
		   	$(this).addClass("notsel");
		   	$(this).html("Open");
	 	 }
	 });

	$(document).on("click",".likelink",function(e){
		e.preventDefault();
		toggleLike($(this).data("id"),$(this).attr("href"), $(this));
	});
}

function validateReg() {
	var greske = 0;
	var username = document.getElementById("regUser")
	var usernameRX=/^\w{3,12}$/;
	if(!usernameRX.test(username.value))
	{
		greske++;
		username.classList.add("bad");
		$("#regUser").css("background-color","pink");
		alert("Username must be 3-12 characters");
	} else {
		username.classList.remove("bad");
		$("#regUser").css("background-color","white");
	}

	var email = document.getElementById("regGmail");
	var emailRX = /^(\w+(\.\w{2,})?){3,50}@(\w{2,10}(\.{1,1}[a-z]{2,3}){1,3})$/;
	if(!emailRX.test(email.value))
	{
		greske++;
		$("#regGmail").css("background-color","pink");
		alert("Email must be a valid format(eg: name@gmail.com");
	} else {
		$("#regGmail").css("background-color","white");
	}

	var pw1 = document.getElementById("regPw1");
	var pwRX = /^(?=.*[A-z])(?=.*[0-9])[A-Za-z0-9]{8,30}$/;
	if(!pwRX.test(pw1.value))
	{
		greske++;
		$("#regPw1").css("background-color","pink");
		alert("Password must be 8-30 letters and numbers.");
	} else {
		$("#regPw1").css("background-color","white");
	}

	var pw2 = document.getElementById("regPw1");
	if(!pwRX.test(pw2.value))
	{
		greske++;
		$("#regPw2").css("background-color","pink");
	} else {
		$("#regPw2").css("background-color","white");
	}
	if(pw1.value!=pw2.value){
		$("#regPw1").css("background-color","pink");
		$("#regPw2").css("background-color","pink");
		alert("Passwords must match!");
	} 


	if(greske==0)
	{
		return true;
	} else { return false; }
}

function validateLog() {
	var greske = 0;
	var username = document.getElementById("logUser")
	var usernameRX=/^\w{3,12}$/;
	if(!usernameRX.test(username.value))
	{
		greske++;
		username.classList.add("bad");
		$("#logUser").css("background-color","pink");
		alert("Username must be 3-12 characters");
	} else {
		username.classList.remove("bad");
		$("#logUser").css("background-color","white");
	}

	var pw = document.getElementById("logPw");
	var pwRX = /^(?=.*[A-z])(?=.*[0-9])[A-Za-z0-9]{8,30}$/;
	if(!pwRX.test(pw.value))
	{
		greske++;
		$("#logPw").css("background-color","pink");
		alert("Password must be 8-30 letters and numbers.");
	} else {
		$("#logPw").css("background-color","white");
	}

	if(greske==0)
	{
		return true;
	} else { return false; }
}

function toggleLike(id, liked, link){
	if(liked=="full") {
		$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "unlike",
				post:id,
				username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				
				var string =`<img class="like" src="app/assets/img/like-empty.png" alt="like button" > ${res.numLikes}`;
				link.data("id",id);
				link.attr("href","empty");
				link.html(string);				
			},
			error:function(e){
				console.log(e);
			}
		});
	} else {
		$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "like",
				post:id,
				username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				var string =`<img class="like" src="app/assets/img/like-full.png" alt="like button" > ${res.numLikes}`;
				link.data("id",id);
				link.attr("href","full");
				link.html(string);	
			},
			error:function(e){
				console.log(e);
			}
		});
	}
}

function validate(){
	var firstName = document.getElementById("firstname");
	var firstNameRX = /^[A-Z][a-z]{2,11}$/;
	var greske = [];
	if(!firstNameRX.test(firstName.value))
	{
		
		firstName.classList.add("bad");
		greske.push("The first name must start with a capital letter and contain 3-12 letters");
	} 
	else {
		firstName.classList.remove("bad");
	}

	var lastName = document.getElementById("lastname");
	var lastNameRX = /^[A-Z][a-z]{2,19}$/;
	if(!lastNameRX.test(lastName.value))
	{
		
		lastName.classList.add("bad");
		greske.push("The last name must start with a capital letter and contain 3-12 letters");
	} 
	else {
		lastName.classList.remove("bad");
	}

	var email = document.getElementById("email");
	var emailRX = /^(\w+(\.\w{2,})?){3,50}@(\w{2,10}(\.{1,1}[a-z]{2,3}){1,3})$/;
	if(!emailRX.test(email.value))
	{
		email.classList.add("bad");
		greske.push("You've entered an invalid email.");
	}
	else {
		email.classList.remove("bad");
	}

	var num = document.getElementById("number");
	var numRX = /^06[1-9](\s|-|\/)?[0-9]{3}(\s|-|\/)?[0-9]{3,4}$/;
	if(!numRX.test(num.value))
	{
		num.classList.add("bad");
		greske.push("You've entered an invalid number.<br> Try: 06X( -/)XXX( -/)XXX(X)")
	}
	else {
		num.classList.remove("bad");
	}

	var gend = document.getElementsByName("gender");
	var pick = false;

	for(var i=0;i<gend.length;i++)
	{
		if(gend[i].checked)
		{
			pick=true;
			break;
		}
	}
	if(!pick)
	{
		greske.push("Choose a gender!");
	}

	var txt = document.getElementById("feedback");
	if(txt.value.length==0)
	{
		greske.push("Write your feedback!");
	}
	var ispis="";
	if(greske.length>0){
		ispis+=`<div id="bad-val">`;
		for(var i=0;i<greske.length;i++)
		{
			ispis+=`<p>${greske[i]}</p>`;
		}
		ispis+=`</div>`;
		$("#val-message").html(ispis);
	}
	if(greske.length==0) {
		$.ajax({
			url:"app/Controllers/AJAXController.php",
			method:"POST",
			data:{
				action:"contact",
				firstName:firstName.value,
				lastName:lastName.value,
				email:email.value,
				num:num.value,
				gender:$("input[name='gender']:checked").val(),
				text:txt.value
			},
			success:function(response,status,jqXHR){
				console.log(response);
				if(jqXHR.status==204){
					ispis=`<div id="good-val"><p>Your feedback was sent successfully!</p></div>`;
					$("#val-message").html(ispis);
				}
			},
			error:function(error){
				if(error.status==409){
					ispis=`<div id="bad-val"><p>Failed to send feedback, please check your input.</p></div>`;
					$("#val-message").html(ispis);
				}
				if(error.status==412){
					var res = error.json();
					let odg="";
					res.forEach(function(r){
						odg += r+"\n";
					});
					alert(odg);
				}
			}
		});
		
	}
}

function fillEditForm(username){
	if(username!=0){
		$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action:"fetchuser",
				username:username
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				$("#euemail").val(res.gmail);
				if(res.Path){
					$("#eupic").attr("src","app/"+res.Path);
				}
				$('input:radio[name="eurole"]').each(function() {
				   if($(this).val()==res.Role){
				   	$(this).prop('checked', true);
				   }
				});
				var gender = 0;
				switch(res.gender){
					case "male": gender = 1; break;
					case "female": gender = 2; break;
					case "other": gender = 3; break;
				}
				$("#eugender").val(gender);
			},
			error:function(e){
				console.log(e);
			}
	});
	} else {
		document.getElementById("editusform").reset();
	}
}

function adminEdit() {
	var username = $("#euname").val();
	var gmail = $("#euemail").val();
	var pw = $("#eupass").val();
	var role = $('input[name="eurole"]:checked').val();
	console.log(role);
	var gender = $("#eugender").val();
	var image = $('#euimg')[0].files[0];
	var fd = new FormData();
	fd.append("username",username);
	fd.append("gmail",gmail);
	fd.append("pw",pw);
	fd.append("role",role);
	fd.append("gender",gender);
	fd.append("image",image);
	fd.append("action","adminedit");
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			processData: false,
      		contentType: false,
			data: fd,
			dataType:"JSON",
			success:function(res,status,jqXHR){
				$("#eupic").attr("src","app/"+res.Path);
				alert("User edited");
			},
			error:function(e){
				console.log(e);
			}
	});
}

function insertUser(){
	var username = $("#iuname").val();
	var gmail = $("#iuemail").val();
	var pw = $("#iupass").val();
	var role = $('input[name="role"]:checked').val();
	var gender = $("#iugender").val();
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "insertuser",
				username: username,
				gmail:gmail,
				pw:pw,
				role:role,
				gender:gender
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				alert("User inserted");
			},
			error:function(e){
				console.log(e);
			}
	});
}

function showFollowedPosts(){
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "showfollowedposts",
				username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res1,status,jqXHR){
							console.log(res1);
					var res = res1[0];
					var likes = res1[1];
					var numl = res1[2];
					console.log(res);
					var string = "";
					var n = res.length;
							for(i=n;i>n-5;i--){
								if(res[i]){
									string += `<div class="post">
												<input type="hidden" class="pbid" value="${res[i].Id}">`;
									if(likes[i]){
										string +=`<a href="full" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-full.png" alt="like button" > ${numl[i].numLikes}</a>`;
									} else {
										string +=`<a href="empty" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-empty.png" alt="like button" > ${numl[i].numLikes}</a>`;
									}
									string +=`<h3>${res[i].title}</h3>
												<span class="postby">By <a class="username-link" href="?user='${res[i].username}'" data-id='${res[i].username}'>${res[i].username}</a></span>
												<hr><br>
												<span class="postText">${res[i].text}</span>`;
									if(res[i].path) {
										string +=`<img class="postimg" src="app/${res[i].path}" alt="${res[i].alt}" >`;
									}
									
									string += `</div>`;
								}
							}
					$("#feed-posts").html(string);
					localStorage.setItem("userposts",JSON.stringify(res1));
					localStorage.setItem("x",5);
							
			},
			error:function(e){
				console.log(e);
			}
	});
}

function toggleFollow(cur){
	console.log(cur);
	if(cur=="Unfollow") {
		$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "unfollowuser",
				their_username:$("#modal-username").html(),
				my_username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				$("#follow-link").attr("data-id","follow");
				$("#follow-link").html("Follow");
				var fol = $("#modal-followers").html();
				fol = parseInt(fol.split(" "));
				fol--;
				$("#modal-followers").html(fol + " followers");
			},
			error:function(e){
				console.log(e);
			}
	});
	} else {
		$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "followuser",
				their_username:$("#modal-username").html(),
				my_username:$("#profile-username").html()
				
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				$("#follow-link").attr("data-id","unfollow");
				$("#follow-link").html("Unfollow");
				var fol = $("#modal-followers").html();
				fol = parseInt(fol.split(" "));
				fol++;
				$("#modal-followers").html(fol + " followers");
			},
			error:function(e){
				console.log(e);
			}
	});
	}
}

function fillThing(x) {
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "showuserstats",
				their_username:x,
				my_username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res,status,jqXHR){
				console.log(res);
					var n = 1;
					var u;
					Object.keys(res).forEach(function(el){
						switch(n){
							case 1:
							$("#modal-username").html(res[el].username);
							$("#modal-gmail").html(res[el].gmail);
							$("#modal-gender").html(res[el].gender);
							u = res[el].username;
							break;

							case 2: 
							if(u!=$("#profile-username").html()){
								if(res[el]){
									$("#follow-link").attr("data-id","unfollow");
									$("#follow-link").html("Unfollow");
								} else {
									$("#follow-link").attr("data-id","follow");
									$("#follow-link").html("Follow")
								}
							}
							break;

							case 3:
							$("#modal-followers").html(res[el].numFol + " followers");
							break;

							case 4: 
							$("#modal-pic").attr("src","app/" + res[el].Path);
							$("#modal-pic").attr("alt",res[el].Alt);
							break;
						}
						n++;
					});
			},
			error:function(e){
				console.log(e);
			}
	});
}

function fillGlobalFeed() {
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "showglobalposts",
				username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res1,status,jqXHR){
							console.log(res1);
					var res = res1[0];
					var likes = res1[1];
					var numl = res1[2];
					console.log(res);
					var string = "";
					var n = res.length;
							for(i=n;i>n-5;i--){
								if(res[i]){
									string += `<div class="post">
												<input type="hidden" class="pbid" value="${res[i].Id}">`;
									if(likes[i]){
										string +=`<a href="full" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-full.png" alt="like button" > ${numl[i].numLikes}</a>`;
									} else {
										string +=`<a href="empty" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-empty.png" alt="like button" > ${numl[i].numLikes}</a>`;
									}
									string +=`<h3>${res[i].title}</h3>
												<span class="postby">By <a class="username-link" href="?user='${res[i].username}'" data-id='${res[i].username}'>${res[i].username}</a></span>
												<hr><br>
												<span class="postText">${res[i].text}</span>`;
									if(res[i].path) {
										string +=`<img class="postimg" src="app/${res[i].path}" alt="${res[i].alt}" >`;
									}
									
									string += `</div>`;
								}
							}
					$("#feed-posts").html(string);
					localStorage.setItem("userposts",JSON.stringify(res1));
					localStorage.setItem("x",5);
							
			},
			error:function(e){
				console.log(e);
			}
	});
}

function seeMorePosts() {
	var res1 = JSON.parse(localStorage.getItem("userposts"));
	var res = res1[0];
	var likes = res1[1];
	var numl = res1[2];
	var x = localStorage.getItem("x");
	var string = $("#postlist").html();
	var string2 = $("#feed-posts").html();
	var string3 = "";
	for(i=res.length-x;i>res.length-(5+x);i--){
		if(res[i]){
									string3 += `<div class="post">
												<input type="hidden" class="pbid" value="${res[i].Id}">`;
									if(likes[i]){
										string3 +=`<a href="full" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-full.png" alt="like button" > ${numl[i].numLikes}</a>`;
									} else {
										string3 +=`<a href="empty" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-empty.png" alt="like button" > ${numl[i].numLikes}</a>`;
									}
									string3 +=`<h3>${res[i].title}</h3>
												<span class="postby">By <a class="username-link" href="?user='${res[i].username}'" data-id='${res[i].username}'>${res[i].username}</a></span>
												<hr><br>
												<span class="postText">${res[i].text}</span>`;
									if(res[i].path) {
										string3 +=`<img class="postimg" src="app/${res[i].path}" alt="${res[i].alt}" >`;
									}
									
									string3 += `</div>`;
								}
	}
	string += string3;
	string2 += string3;
	$("#postlist").html(string);
	$("#feed-posts").html(string2);
	x+=5;
	if(x>=res.length){
		localStorage.removeItem("x");
		localStorage.removeItem("userposts");
	} else {
		localStorage.setItem("x",x);
	}
}

function showYourPosts() {
	var puid = $("#puid").val();
	$.ajax({
		url:"app/Controllers/AJAXController.php",
			method:"POST",
			data: {
				action: "showuserposts",
				puid:puid,
				username:$("#profile-username").html()
			},
			dataType:"JSON",
			success:function(res1,status,jqXHR){
							
					var res = res1[0];
					var likes = res1[1];
					var numl = res1[2];
					console.log(res1);
					var string = "";
					var n = res.length;
							for(i=n;i>n-5;i--){
								if(res[i]){
									string += `<div class="post">
												<input type="hidden" class="pbid" value="${res[i].Id}">`;
									if(likes[i]){
										string +=`<a href="full" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-full.png" alt="like button" > ${numl[i].numLikes}</a>`;
									} else {
										string +=`<a href="empty" data-id="${res[i].Id}" class="likelink"><img class="like" src="app/assets/img/like-empty.png" alt="like button" > ${numl[i].numLikes}</a>`;
									}
									string +=`<h3>${res[i].title}</h3>
												<span class="postby">By <a class="username-link" href="?user='${res[i].username}'" data-id='${res[i].username}'>${res[i].username}</a></span>
												<hr><br>
												<span class="postText">${res[i].text}</span>`;
									if(res[i].path) {
										string +=`<img class="postimg" src="app/${res[i].path}" alt="${res[i].alt}" >`;
									}
									
									string += `</div>`;
								}
							}
					$("#postlist").html(string);
					localStorage.setItem("userposts",JSON.stringify(res1));
					localStorage.setItem("x",5);
							
			},
			error:function(e){
				console.log(e);
			}
	});
}

function submitPost(){
	var ptitle = $("#title").val();
	var ptext = $("#text").val();
	var puid = $("#puid").val();
	var pimage = $('#postpic')[0].files[0];
	var fd = new FormData();
	fd.append("ptitle",ptitle);
	fd.append("ptext",ptext);
	fd.append("pimage",pimage);
	fd.append("puid",puid);
	fd.append("action","subpost");
	if(ptitle!=null&&ptext!=null){
		$.ajax({
			url:"app/Controllers/AJAXController.php",
			method:"POST",
			processData: false,
      		contentType: false,
			data: fd,
			dataType:"JSON",
			success:function(res,status,jqXHR){
				alert("Post submitted.");
				console.log(res);
				var string = `<div class="post">
								<input type="hidden" class="pbid" value="${res.Id}">
								<h3>${res.title}</h3>
								<span class="postby">By ${$("#setusername").val()}</span>
								<hr><br>
								<span class="postText">${res.text}</span>`;
				if(res.path) {
							string +=`<img class="postimg" src="app/${res.path}" alt="${res.alt}" >`;
				}
				string += `</div>`;
				$("#postlist").prepend(string);
			},
			error:function(e){
				console.log(e);
			}
		});
	}
}

function editUser() {
	var username = $("#setusername").val();
	var mail = $("#setmail").val();
	var pw1 = $("#setpw1").val();
	var pw2 = $("#setpw2").val();
	var image = $('#setprofile')[0].files[0];
	var fd = new FormData();
	fd.append("image",image);
	fd.append("username",username);
	fd.append("pw1",pw1);
	fd.append("pw2",pw2);
	fd.append("gmail",mail);
	fd.append("action","edituser");
	console.log(image);
	if(mail.trim().length!=0||(pw1.trim().length!=0&&pw2.trim().length!=0&&pw1.value==pw2.value)||image!=null){
					$.ajax({
						url:"app/Controllers/AJAXController.php",
						method:"POST",
						processData: false,
      					contentType: false,
						data: fd,
						dataType:"JSON",
						success:function(res,status,jqXHR){
							$("#mainProfilePic").attr("src","app/"+res.Path);
							$("#userProfile").attr("src","app/"+res.Path);
							alert("Settings changed.");
							
						},
						error:function(e){
							console.log(e);
						}
					});
				}
}


	


