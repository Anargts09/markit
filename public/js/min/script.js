function hasScrolled(){var t=$(this).scrollTop();t>lastScrollTop&&t>navbarHeight?$(".slideUp").css({top:-42}):t+$(window).height()<$(document).height()&&$(".slideUp").css({top:0}),lastScrollTop=t}function ajaxPagination(t,a,s){return a=$(a),a.addClass("is-loading"),$.ajax({method:"POST",url:t,dataType:"json"}).done(function(t){var o=$(t.html).hide();$("."+s).append(o);var n=$(".momentjs",o);n.each(function(t){var a=$(this).attr("data-date");this.innerHTML=moment(a).fromNow()}),$("pre code",o).each(function(t,a){hljs.highlightBlock(a)}),a.remove(),$(o).each(function(t){$(this).delay(30*t).fadeIn(300)})}).fail(function(){console.log("error.")}),!1}function enableTab(t){var a=document.getElementById(t);a.onkeydown=function(t){if(9===t.keyCode){var a=this.value,s=this.selectionStart,o=this.selectionEnd;return this.value=a.substring(0,s)+"	"+a.substring(o),this.selectionStart=this.selectionEnd=s+1,!1}}}$(document).foundation(),jQuery(document).ready(function(){var t=$(".momentjs");t.each(function(t){var a=$(this).attr("data-date");this.innerHTML=moment(a).fromNow()})});var didScroll,lastScrollTop=0,scrollAmount=10,navbarHeight=$(".slideUp").outerHeight();$(window).scroll(function(t){didScroll=!0}),setInterval(function(){didScroll&&(hasScrolled(),didScroll=!1)},250),moment.locale("mn",{months:"1сар_2сар_3сар_4сар_5сар_6сар_7сар_8сар_9сар_10сар_11сар_12сар".split("_"),monthsShort:"1сар_2сар_3сар_4сар_5сар_6сар_7сар_8сар_9сар_10сар_11сар_12сар".split("_"),weekdays:"даваа_мягмар_лхагва_пүрэв_баасан_бямба_ням".split("_"),weekdaysShort:"да._мя._лх._пү._ба._бя._ня.".split("_"),weekdaysMin:"Да_Мя_Лх_Пү_Ба_Бя_Ня".split("_"),longDateFormat:{LT:"HH:mm",LTS:"HH:mm:ss",L:"DD/MM/YYYY",LL:"D MMMM YYYY",LLL:"D MMMM YYYY LT",LLLL:"dddd D MMMM YYYY LT"},calendar:{sameDay:"[Өнөөдөр] LT",nextDay:"[Маргааш] LT",nextWeek:"dddd [à] LT",lastDay:"[Өчигдөр] LT",lastWeek:"dddd [өнгөрсөн] LT",sameElse:"L"},relativeTime:{future:"%s дараа",past:"%s өмнө",s:"секундын",m:"1 минутын",mm:"%d минутын",h:"цагийн",hh:"%d цагийн",d:"1 өдөрийн",dd:"%d өдөрийн",M:"сарын",MM:"%d сарын",y:"une жилийн",yy:"%d жилийн"},week:{dow:1,doy:4}}),$(document).on("click","button.clickFollow",function(t){var a=$(this),s=$(this).attr("data-id");a.addClass("is-loading"),jQuery.post("/follow/"+s,function(){}).done(function(t){a.removeClass("is-loading"),t.success&&("follow"==t.type?a.html('<i class="fa fa-check-square"></i> <span>Дагаж байгаа</span>'):a.html('<i class="fa fa-user-plus"></i> <span>Дагах</span>'))})}),$(document).on("click",".tagFollow",function(t){var a=$(this),s=$(this).attr("data-id");a.addClass("is-loading"),jQuery.post("/tagfollow/"+s,function(){}).done(function(t){a.removeClass("is-loading"),t.success&&(a.removeClass("tagFollow").addClass("tagUnfollow"),a.html('<i class="fa fa-check-square"></i>Дагаж байгаа'))})}),$(document).on("click","button.tagUnfollow",function(t){var a=$(this),s=$(this).attr("data-id");a.addClass("is-loading"),jQuery.post("/tagunfollow/"+s,function(){}).done(function(t){a.removeClass("is-loading"),t.success&&(a.removeClass("tagUnfollow").addClass("tagFollow"),a.html('<i class="fa fa-tags"></i>Дагах'))})}),$(document).on("click",".saveButton",function(t){var a=$(this),s=$(this).attr("data-id");a.addClass("is-loading"),jQuery.post("/savepost/"+s,function(){}).done(function(t){a.removeClass("is-loading"),t.success&&(a.removeClass("saveButton").addClass("is-outlined").addClass("unsaveButton"),a.html('<i class="fa fa-bookmark"></i> Saved'))})}),$(document).on("click",".unsaveButton",function(t){var a=$(this),s=$(this).attr("data-id");a.addClass("is-loading"),jQuery.post("/unsavepost/"+s,function(){}).done(function(t){a.removeClass("is-loading"),t.success&&(a.removeClass("unsaveButton").addClass("saveButton"),a.html('<i class="fa fa-bookmark-o"></i> Save'))})});