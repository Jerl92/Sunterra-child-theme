jQuery(document).ready(function(e) {
    jQuery('input#searchInput').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
    jQuery('#ns-ticket-return-adresse').keypress(function(e) {
        if (e.which == 13) {
            jQuery('input[type=submit]').addClass('disabled');
        };
    });
});

jQuery(document).ready(function(e) {
    jQuery('input#ns-ticket-inovice-number').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 13) {
            e.preventDefault();
            return;
        }
    });
});

jQuery(document).ready(function(e) {
    jQuery('input#ns-ticket-subject').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 13) {
            e.preventDefault();
            return;
        }
    });
});

jQuery(document).ready(function(e) {
    jQuery('input#ns-ticket-serial-number').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 13) {
            e.preventDefault();
            return;
        }
    });
});


jQuery(document).ready(function(e) {
    jQuery('input#ns-ticket-issuse').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 13) {
            e.preventDefault();
            return;
        }
    });
});

jQuery(document).ready(function() {
    var totalWidth = 0;
    var windowwidth = jQuery(window).width();
    jQuery("ul#menu-header-top-menu").children("li").each(function() {
        var $this = jQuery(this);
        var width = $this.outerWidth(true);
        totalWidth = totalWidth + width;
    });
    jQuery("ul#menu-header-top-menu").css("width", totalWidth);
});

jQuery(document).ready(function() {
    var scroller = new FTScroller(document.getElementById('top-menu-container'), {
        scrollingY: false,
        scrollbars: false,
        bouncing: false,
        overflow: 'scroll',
        updateOnWindowResize: true
    });
});

jQuery(window).resize(function() {
    var totalWidth = 0;
    var windowwidth = jQuery(window).width();
    jQuery("ul#menu-header-top-menu").children("li").each(function() {
        var $this = jQuery(this);
        var width = $this.outerWidth(true);
        totalWidth = totalWidth + width;
    });
    jQuery("ul#menu-header-top-menu").css("width", totalWidth);
});

jQuery(document).ready(function() {
    jQuery('.ht-container-min').css('display', 'none');
    jQuery('#top-menu-container').css('border-bottom', 'none');
    jQuery('#top-menu-container').css('position', 'relative');
});

jQuery(document).ready(function() {
    jQuery('.add_alternative_adresse').on('click', function(e) {
        if (jQuery("#ticket-retrun-adresse-edit").hasClass("hide")) {
            jQuery("#ticket-retrun-adresse-edit").removeClass("hide");
            jQuery(".ns-ticket-retrun-adresse-table").addClass("hide");
            jQuery(".add_alternative_adresse").addClass("hide");
            jQuery(".select_alternative_adresse").removeClass("hide");
        }
    });
    jQuery('.select_alternative_adresse').on('click', function(e) {
        if (jQuery(".ns-ticket-retrun-adresse-table").hasClass("hide")) {
            jQuery("#ticket-retrun-adresse-edit").addClass("hide");
            jQuery(".ns-ticket-retrun-adresse-table").removeClass("hide");
            jQuery(".add_alternative_adresse").removeClass("hide");
            jQuery(".select_alternative_adresse").addClass("hide");
        }
    });
    jQuery('input[type=radio]').each(function(e) {
        jQuery('input[type=radio]').on('click', function(e) {
            jQuery("#clear_alternative_adresse").removeClass("disabled");
        });
    });
    jQuery("#clear_alternative_adresse").on('click', function(e) {
        jQuery("#clear_alternative_adresse").addClass("disabled");
    });
    jQuery("#clear_alternative_adresse").on("click", function() {
        jQuery(".ns-ticket-retrun-adresse-table input").each(function(index) {
            jQuery(this).prop("checked", false);
        });
    });
});

jQuery(document).ready(function() {
    var w = jQuery(window).width();
    if (w < 782) {
        var jQuerywpAdminBar = jQuery('#wpadminbar');
        if (jQuerywpAdminBar.length) {
            jQuery('.top-menu-container-admin-fix').css('margin-top', '46px');
        }
    } else {
        var jQuerywpAdminBar = jQuery('#wpadminbar');
        if (jQuerywpAdminBar.length) {
            jQuery('.top-menu-container-admin-fix').css('margin-top', '32px');
        }
    }
});

jQuery(window).resize(function() {
    var y = jQuery(this).scrollTop();
    var w = jQuery(window).width();
    if (w < 782) {
        var jQuerywpAdminBar = jQuery('#wpadminbar');
        if (jQuerywpAdminBar.length) {
            jQuery('.top-menu-container-admin-fix').css('margin-top', '46px');
        }
    } else {
        var jQuerywpAdminBar = jQuery('#wpadminbar');
        if (jQuerywpAdminBar.length) {
            jQuery('.top-menu-container-admin-fix').css('margin-top', '32px');
        }
    }
    if (w > 920) {
        jQuery('#top-menu-container').css('position', 'relative');
        jQuery('.ht-container-min').css('display', 'none');
        //jQuery('#top-menu-container').css('height', '38px');
        jQuery('#top-menu-container').css('border-bottom', 'none');
        jQuery('#top-menu-container, .ht-container-min').removeClass('top-menu-container-animation');
        jQuery('#top-menu-container').css('top', 'auto');
        jQuery('#top-menu-container').css('display', 'block');
        jQuery('#top-menu-container').css('position', 'relative');
        //jQuery('#header').css('padding', '0 0 8px 0');
        jQuery('#header').css('top', '0px');
    };
    if (w < 920) {
        jQuery('.ht-container-min').css('display', 'none');
        jQuery('#top-menu-container').css('position', 'relative');
        //jQuery('#top-menu-container').css('height', 'auto');
    }
});

jQuery(document).scroll(function() {
    var y = jQuery(this).scrollTop();
    var w = jQuery(window).width();
    if (w > 920) {
        if (y < 225) {
            jQuery('#top-menu-container').css('position', 'relative');
            jQuery('.ht-container-min').css('display', 'none');
            //jQuery('#top-menu-container').css('height', '38px');
            jQuery('#top-menu-container').css('display', 'block');
            jQuery('#top-menu-container').css('border-bottom', 'none');
            jQuery('#top-menu-container').removeClass('top-menu-container-animation');
            jQuery('#header').css('padding', '0');
            jQuery('#top-menu-container').css('top', '0');
            jQuery('#header').css('top', '0px');
            var jQuerywpAdminBar = jQuery('#wpadminbar');
            if (jQuerywpAdminBar.length) {
                jQuery('.top-menu-container-admin-fix').css('margin-top', '32px');
            }
        } else {
            jQuery('.ht-container-min').css('display', 'block');
            jQuery('#top-menu-container, .ht-container-min').css('position', 'fixed');
            jQuery('#header').css('padding', '38px 0 0 0');
            //jQuery('#top-menu-container').css('height', '77.5px');
            jQuery('#top-menu-container, .ht-container-min').addClass('top-menu-container-animation');
            jQuery('#top-menu-container').css('top', '0');
            var jQuerywpAdminBar = jQuery('#wpadminbar');
            if (jQuerywpAdminBar.length) {
                jQuery('#header').css('top', '32px');
                // jQuery('#top-menu-container').css('top', '32px');
                // jQuery('.ht-container-min').css('top', '70px');
            }
            var jQuerywphome = jQuery('body.home');
            if (jQuerywphome.length && jQuerywpAdminBar.length) {
                jQuery('#top-menu-container').css('top', '32px');
                jQuery('.ht-container-min').css('top', '70px');
            }
        }
    } else {
        jQuery('#header').css('padding', '0');
        jQuery('#top-menu-container').css('top', '0');
    }
});

/*
jQuery(window).load(function() {   
    jQuery('#ticket-retrun-adresse-div').css('display', 'none');
    jQuery('#retrun-adresse-map-toggle').click(function(){
        if (jQuery('#ticket-retrun-adresse-div').css('display') == 'none')  {
            jQuery('#ticket-retrun-adresse-div').css('display', 'block');
            jQuery('#ticket-retrun-adresse-div').css('visibility', 'visible');
            jQuery('#retrun-adresse-map-click').removeClass('down');
            jQuery('#retrun-adresse-map-click').addClass('up');
        } else {
            jQuery('#ticket-retrun-adresse-div').css('display', 'none');
            jQuery('#retrun-adresse-map-click').removeClass('up');
            jQuery('#retrun-adresse-map-click').addClass('down');
        }
    }); 
});
*/

jQuery(document).ready(function() {
    var windowHeight_ = jQuery(window).height();
    var documentHeight_ = jQuery(document).height();

    if (windowHeight_ >= documentHeight_) {
        jQuery('#footer').css('position', 'fixed');
        jQuery('#footer').css('bottom', '0');
        jQuery('#footer').css('width', '100%');
    } else {
        jQuery('#footer').css('position', 'relative');
        jQuery('#footer').css('bottom', '0');
        jQuery('#footer').css('width', '100%');
    }
});

jQuery(window).resize(function() {
    var windowHeight_ = jQuery(window).height();
    var documentHeight_ = jQuery(document).height();

    if (windowHeight_ >= documentHeight_) {
        jQuery('#footer').css('position', 'fixed');
        jQuery('#footer').css('bottom', '0');
        jQuery('#footer').css('width', '100%');
    } else {
        jQuery('#footer').css('position', 'relative');
        jQuery('#footer').css('bottom', 'auto');
        jQuery('#footer').css('width', '100%');
    }
});

jQuery(document).ready(function() {
    jQuery("#ns_submit").click(function(event) {
        var i = 0;
        jQuery("input#ns-ticket-inovice-number").filter(function() {
            if (jQuery(this).val().length === 0) {
                jQuery(this).addClass("error");
                i = 1;
            } else {
                jQuery(this).removeClass("error");
            }
        });
        jQuery("input#ns-ticket-subject").filter(function() {
            if (jQuery(this).val().length === 0) {
                jQuery(this).addClass("error");
                i = 1;
            } else {
                jQuery(this).removeClass("error");
            }
        });
        jQuery("input#ns-ticket-serial-number").filter(function() {
            if (jQuery(this).val().length === 0) {
                jQuery(this).addClass("error");
                i = 1;
            } else {
                jQuery(this).removeClass("error");
            }
        });
        jQuery("select#ns-ticket-form-factor").filter(function() {
            if (jQuery(this).val() == 0) {
                jQuery(this).addClass("error");
                i = 1;
            } else {
                jQuery(this).removeClass("error");
            }
        });
        jQuery("input#ns-ticket-issuse").filter(function() {
            if (jQuery(this).val().length === 0) {
                jQuery(this).addClass("error");
                i = 1;
            } else {
                jQuery(this).removeClass("error");
            }
        });
        // Check if TinyMCE is active
        if (typeof tinyMCE != "undefined") {
            // Get content of active editor
            var editorContent = tinyMCE.activeEditor.getContent();
            if ((editorContent === '' || editorContent === null)) {
                jQuery("#wp-ns-ticket-details-editor-container").addClass("error");
                i = 1;
            } else {
                jQuery("#wp-ns-ticket-details-editor-container").removeClass("error");
            }
        }
        if (i == 0) {
            jQuery('#ns_submit').css("display", "none");
            jQuery('#ns_submit_disable').css("display", "block");
        } else {
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#nanosupport-add-ticket").offset().top - 150
            }, 500);
        }
    });
});

jQuery(document).ready(function($) {
    adaptColor('.ns-label-dashboard');
    $('.count-status-flex').find('a').each(function(e) {
        adaptColor($(this));
        console.log($(this).attr('href'));
    });
    $('.homepage-wrapper-flex').find('a').each(function(e) {
        adaptColor($(this));
        console.log($(this).attr('href'));
    });
    $('.ticket_status').each(function(e) {
        adaptColor($(this));
    });
    adaptColor('#status_selecte_filters');
    $(".ticket_status").click(function(event) {
        var color = $( this ).css( "background-color" );
        console.log(color);
        $("#status_selecte_filters").css( "background-color", color );
    });
    $("#status_selecte_filters").change(function () {
        var firstDropVal = $( this ).css( "background-color");
        console.log(firstDropVal);
        $("#status_selecte_filters").css( "background-color", firstDropVal );
    });
});

function adaptColor(selector) {
    var rgb = jQuery(selector).css("background-color");

    if (rgb) {
        if (rgb.match(/^rgb/)) {
            var a = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/),
                r = a[1],
                g = a[2],
                b = a[3];
        }
        var hsp = Math.sqrt(
            0.299 * (r * r) +
            0.587 * (g * g) +
            0.114 * (b * b)
        );
        if (hsp > 127.5) {
            jQuery(selector).css('color', '#4a4646');
        } else {
            jQuery(selector).css('color', 'white');
        }
    }

};

jQuery(document).ready(function($) {
    if(jQuery("#um_field_delete_single_user_password")){
        jQuery("#um_field_delete_single_user_password").empty();
    }
});

jQuery(window).resize(function($) {
    var contentHeight = jQuery("#content").height();
    var sidebarHeight = jQuery("#sidebar").height();
    var windowwidth = jQuery(document).width();
    var windowHeight = jQuery(window).height();

    if (contentHeight < sidebarHeight) {
        var pagesubnavHeight = jQuery("#page-subnav").height();
        var pageheaderHeight = jQuery("#page-header").height();
        var headerHeight = jQuery("#header").height();

        var primaryHeight = contentHeight + headerHeight + pageheaderHeight + 'px';
        if (windowwidth > 720) {
            if (sidebarHeight > contentHeight) {
                jQuery("#sidebar").height(primaryHeight);
                sidebar = document.getElementById('sidebar');
                jQuery('#sidebar').css('overflow', 'scroll');
                sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    var scroller = new FTScroller(sidebar, {
                        scrollingX: false,
                        scrollbars: false,
                        alwaysScroll: true,
                        bouncing: false,
                        overflow: 'scroll',
                        updateOnWindowResize: true
                    });
                }
            }
        }
    }
});

jQuery(document).ready(function () {
    var contentHeight = jQuery("#content").height();
    var sidebarHeight = jQuery("#sidebar").height();
    var windowwidth = jQuery(document).width();
    var windowHeight = jQuery(window).height();

    if (contentHeight < sidebarHeight) {
        var pagesubnavHeight = jQuery("#page-subnav").height();
        var pageheaderHeight = jQuery("#page-header").height();
        var headerHeight = jQuery("#header").height();

        var primaryHeight = contentHeight + headerHeight + pageheaderHeight + 'px';
        if (windowwidth > 720) {
            if (sidebarHeight > contentHeight) {
                jQuery("#sidebar").height(primaryHeight);
                sidebar = document.getElementById('sidebar');
                jQuery('#sidebar').css('overflow', 'scroll');
                sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    var scroller = new FTScroller(sidebar, {
                        scrollingX: false,
                        scrollbars: false,
                        alwaysScroll: true,
                        bouncing: false,
                        overflow: 'scroll',
                        updateOnWindowResize: true
                    });
                }
            }
        }
    }
});

jQuery(document).ready(function () {
    var windowheight = $( window ).height();
    var documentheight = $( document ).height();
    var contentheight = $( '#content' ).height();

    if(windowheight > documentheight){
        jQuery("#content").height(windowheight);
        jQuery("#primary").height(windowheight);
        jQuery("#sidebar").height(windowHeight);
    } else {
        jQuery("#content").height(contentHeight);
        jQuery("#primary").height(contentHeight);
        jQuery("#sidebar").height(contentHeight);
    }
    var scroller = new FTScroller(sidebar, {
        scrollingX: false,
        scrollbars: false,
        alwaysScroll: true,
        bouncing: false,
        overflow: 'scroll',
        updateOnWindowResize: true
    });
});

jQuery(document).resize(function () {
    var windowheight = $( window ).height();
    var documentheight = $( document ).height();
    var contentheight = $( '#content' ).height();

    if(windowheight > documentheight){
        jQuery("#content").height(windowheight);
        jQuery("#primary").height(windowheight);
        jQuery("#sidebar").height(windowHeight);
    } else {
        jQuery("#content").height(contentHeight);
        jQuery("#primary").height(contentHeight);
        jQuery("#sidebar").height(contentHeight);
    }
    var scroller = new FTScroller(sidebar, {
        scrollingX: false,
        scrollbars: false,
        alwaysScroll: true,
        bouncing: false,
        overflow: 'scroll',
        updateOnWindowResize: true
    });
});

/* 

    navigator.getUserMedia({video: { facingMode: { exact: "environment" } }}, function(stream) {
		var video = document.getElementById("v");
		var canvas = document.getElementById("c");
        var button = document.getElementById("b");
        video.src = stream;
        video.srcObject = stream;
        video.play();
		button.disabled = false;
		button.onclick = function() {
			canvas.getContext("2d").drawImage(video, 0, 0);
			var img = canvas.toDataURL("image/png");
			alert("done");
		};
    }, function(err) { });

*/

/*
jQuery(document).ready(function () {
    $('#btn_toggle_lang a').on('click', function (e) {
            var link = window.location.href;
            var success = link.replace(templateUrl, '');
            window.location = templateUrl + '/' + $(this).attr('value') + '/' + success;
    });
});
*/