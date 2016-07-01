$(document).foundation();
jQuery(document).ready(function() {
    // Momentjs
    var eDisplayMoments = $('.momentjs');  
    eDisplayMoments.each(function(index){
        var stringsec =$(this).attr('data-date');
        this.innerHTML = moment(stringsec).fromNow()
    });
});

// ---------------------------------------------------------------
// SlideUp for Foundation top-bar
// ---------------------------------------------------------------

var didScroll;
var lastScrollTop = 0;
var scrollAmount = 10;          // Value of scroll amount
var navbarHeight = $('.slideUp').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var sup = $(this).scrollTop();

    if (sup > lastScrollTop && sup > navbarHeight){
        // On Scroll Down
        $('.slideUp').css({top: - 42});
    } else {
        // On Scroll Up
        if(sup + $(window).height() < $(document).height()) {
            $('.slideUp').css({top: 0});
        }
    }

    lastScrollTop = sup;
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
        s : "секундын",
        m : "1 минутын",
        mm : "%d минутын",
        h : "цагийн",
        hh : "%d цагийн",
        d : "1 өдөрийн",
        dd : "%d өдөрийн",
        M : "сарын",
        MM : "%d сарын",
        y : "une жилийн",
        yy : "%d жилийн"
    },
    week : {
        dow : 1, // Monday is the first day of the week.
        doy : 4  // The week that contains Jan 4th is the first week of the year.
    }
});

// AJAX PAGINATION
function ajaxPagination(url, obj, appendObject){
    obj = $(obj);
    obj.addClass('is-loading');
    $.ajax({
      method: "POST",
      url: url,
      dataType: 'json'
    })
    .done(function (data) {
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
    obj.addClass('is-loading');
    jQuery.post("/follow/"+follow_id, function(){}).done(function(data){
        obj.removeClass('is-loading');
        if (data.success){
            if(data.type == 'follow'){
                obj.html('<i class="fa fa-check-square"></i> <span>Дагаж байгаа</span>');
            }else{
                obj.html('<i class="fa fa-user-plus"></i> <span>Дагах</span>');
            }
        }
    });
});
// TAG FOLLOW & UNFOLLOW
$(document).on('click', '.tagFollow', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    obj.addClass('is-loading');
    jQuery.post("/tagfollow/"+follow_id, function(){}).done(function(data){
        obj.removeClass('is-loading');
        if (data.success){
            obj.removeClass('tagFollow').addClass('tagUnfollow');
            obj.html('<i class="fa fa-check-square"></i>Дагаж байгаа');
        }
    });
});
$(document).on('click', 'button.tagUnfollow', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    obj.addClass('is-loading');
    jQuery.post("/tagunfollow/"+follow_id, function(){}).done(function(data){
        obj.removeClass('is-loading');
        if (data.success){
            obj.removeClass('tagUnfollow').addClass('tagFollow');
            obj.html('<i class="fa fa-tags"></i>Дагах');
        }
    });
});
// POST SAVE & UNSAVE
$(document).on('click', '.saveButton', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    obj.addClass('is-loading');
    jQuery.post("/savepost/"+follow_id, function(){}).done(function(data){
        obj.removeClass('is-loading');
        if (data.success){
            obj.removeClass('saveButton').addClass('is-outlined').addClass('unsaveButton');
            obj.html('<i class="fa fa-bookmark"></i> Saved');
        }
    });
});
$(document).on('click', '.unsaveButton', function(e){
    var obj = $(this);
    var follow_id = $(this).attr('data-id');
    obj.addClass('is-loading');
    jQuery.post("/unsavepost/"+follow_id, function(){}).done(function(data){
        obj.removeClass('is-loading');
        if (data.success){
            obj.removeClass('unsaveButton').addClass('saveButton');
            obj.html('<i class="fa fa-bookmark-o"></i> Save');
        }
    });
});