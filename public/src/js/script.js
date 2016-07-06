$(document).foundation();
jQuery(document).ready(function() {
    // Momentjs
    var eDisplayMoments = $('.momentjs');  
    eDisplayMoments.each(function(index){
        var stringsec =$(this).attr('data-date');
        this.innerHTML = moment(stringsec).fromNow()
    });

});

var triggerEnter = function(elem) {
    var e = jQuery.Event("keypress");
    e.which = 13; //choose the one you want
    e.keyCode = 13;
    elem.trigger(e);
};

function skillAdd(){
    $('#tags').tagsInput({
        'height':'auto',
        'width':'100%',
        'interactive':true,
        'defaultText':'Скилл нэмэх',
        'delimiter': [','],
        'removeWithBackspace' : true,
        'minChars' : 3,
        'maxChars' : 0,
        'autocomplete_url':'http://localhost:8000/api/alltag',
        'autocomplete':{autoFill:true}
    });
    var taginput = $('#tags_addTag input')
    $.each(JsonArray, function() {
        taginput.val(this.name);
        triggerEnter(taginput);
    });

}

// Momentjs MN
moment.locale('mn', {
    months : "1сар_2сар_3сар_4сар_5сар_6сар_7сар_8сар_9сар_10сар_11сар_12сар".split("_"),
    monthsShort : "1сар_2сар_3сар_4сар_5сар_6сар_7сар_8сар_9сар_10сар_11сар_12сар".split("_"),
    weekdays : "даваа_мягмар_лхагва_пүрэв_баасан_бямба_ням".split("_"),
    weekdaysShort : "да._мя._лх._пү._ба._бя._ня.".split("_"),
    weekdaysMin : "Да_Мя_Лх_Пү_Ба_Бя_Ня".split("_"),
    longDateFormat : {
        LT : "HH:mm",
        LTS : "HH:mm:ss",
        L : "DD/MM/YYYY",
        LL : "D MMMM YYYY",
        LLL : "D MMMM YYYY LT",
        LLLL : "dddd D MMMM YYYY LT"
    },
    calendar : {
        sameDay: "[Өнөөдөр] LT",
        nextDay: '[Маргааш] LT',
        nextWeek: 'dddd [à] LT',
        lastDay: '[Өчигдөр] LT',
        lastWeek: 'dddd [өнгөрсөн] LT',
        sameElse: 'L'
    },
    relativeTime : {
        future : "%s дараа",
        past : "%s өмнө",
        s : "1 секундын",
        m : "1 минутын",
        mm : "%d минутын",
        h : "1 цагийн",
        hh : "%d цагийн",
        d : "1 өдөрийн",
        dd : "%d өдөрийн",
        M : "1 сарын",
        MM : "%d сарын",
        y : "1 жилийн",
        yy : "%d жилийн"
    },
    week : {
        dow : 1, // Monday is the first day of the week.
        doy : 4  // The week that contains Jan 4th is the first week of the year.
    }
});

// AJAX PAGINATION
function ajaxPagination(url, obj, appendObject){
    var loading_content = '<div class="is-loading text-center"><img src="../images/load-indicator.gif"/></div>';
    $('.'+appendObject).append(loading_content);
    obj = $(obj);
    $.ajax({
      method: "POST",
      url: url,
      dataType: 'json'
    })
    .done(function (data) {
        if((appendObject == 'feed-content') && (data.count === 0)){
            var feed_content = '<div>Таны хуудас хоосон байна. Хэрэглэгч болон таг дагаж өөрийн !</div>';
            $('.is-loading').fadeOut(300).remove();
            $('.'+appendObject).append(feed_content);
            return false;
        }
        var new_list = $(data.html).hide();
        $('.'+appendObject).append(new_list);
        var eDisplayMoments = $('.momentjs', new_list);  
        eDisplayMoments.each(function(index){
            var stringsec =$(this).attr('data-date');
            this.innerHTML = moment(stringsec).fromNow()
        });
        $('pre code', new_list).each(function(i, block) {
            hljs.highlightBlock(block);
        });
        obj.remove();
        $('.is-loading').fadeOut(300).remove();
        $(new_list).each(function(index) {
            $(this).delay(30*index).fadeIn(300);
        });
    }).fail(function () {
        console.log('error.');
    });
    return false;
}
// Enable Tab
function enableTab(id) {
    var el = document.getElementById(id);
    el.onkeydown = function(e) {
        if (e.keyCode === 9) { // tab was pressed

            // get caret position/selection
            var val = this.value,
                start = this.selectionStart,
                end = this.selectionEnd;

            // set textarea value to: text before caret + tab + text after caret
            this.value = val.substring(0, start) + '\t' + val.substring(end);

            // put caret at right position again
            this.selectionStart = this.selectionEnd = start + 1;

            // prevent the focus lose
            return false;

        }
    };
}

// USER FOLLOW & UNFOLLOW
$(document).on('click', 'button.clickFollow', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    jQuery.post("/follow/"+follow_id, function(){}).done(function(data){
        if (data.success){
            if(data.type === 'follow'){
                obj.html('<i class="fa fa-check-square"></i> <span>Дагаж байгаа</span>');
            }else{
                obj.html('<i class="fa fa-user-plus"></i> <span>Дагах</span>');
            }
        }
    });
});

// POST SAVE & UNSAVE
$(document).on('click', 'button.saveButton', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    jQuery.post("/savepost/"+follow_id, function(){}).done(function(data){
        if (data.success){
            if(data.type == 'save'){
                obj.html('<i class="fa fa-bookmark"></i> saved '+data.count+'');
            }else{
                obj.html('<i class="fa fa-bookmark-o"></i> save '+data.count+'');
            }
        }
    });
});
// TAG FOLLOW & UNFOLLOW
$(document).on('click', '.tagFollow', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    jQuery.post("/tagfollow/"+follow_id, function(){}).done(function(data){
        if (data.success){
            obj.removeClass('tagFollow').addClass('tagUnfollow');
            obj.html('<i class="fa fa-check-square"></i>Дагаж байгаа');
        }
    });
});
$(document).on('click', 'button.tagUnfollow', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    jQuery.post("/tagunfollow/"+follow_id, function(){}).done(function(data){
        if (data.success){
            obj.removeClass('tagUnfollow').addClass('tagFollow');
            obj.html('<i class="fa fa-tags"></i>Дагах');
        }
    });
});


$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

$(document).on('submit', '#commentForm', function(e){
    var submitdata = $('#commentPane').val();
    if(submitdata != ''){
        var posturl = $(this).attr('action');
        $.ajax({
          method: "POST",
          url: posturl,
          dataType: 'json',
          data: {body: submitdata}
        })
        .done(function (data) {
            var new_comment = $(data.html).hide();
            $('#postComments').prepend(new_comment);
            new_comment.fadeIn(300);
            $('.newComment pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        }).fail(function () {
            console.log('error.');
        });
    };
    $('#commentPane').val('');
    return false;
});
$(document).on('click', '.pagination-link', function(e){
    var obj = $(this);
    var ajax_url = $(this).attr('data-url');
    var appendObject = $(this).attr('data-content');
    ajaxPagination(ajax_url, obj, appendObject);
});
$(document).on('focus', '#tags_addTag input',function(){
    $(this).keypress(function (e) {
        var keyCode = e.keyCode || e.which; 
        if ((keyCode === 32)||(keyCode === 9)) {
            e.preventDefault();
            triggerEnter($(e.target));
        }
    });
});