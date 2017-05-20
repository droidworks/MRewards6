// Jamroom 5 FoxyCart Bundle Javascript
// @copyright 2003-2011 by Talldude Networks LLC
// @author Brian Johnson - brian@jamroom.net


/**
 * Display item bundles
 * @param uid string Unique Module-Field-ItemID
 * @return bool
 */
function jrFoxyCartBundle_display_bundles(uid)
{
    $(".bundle_box").fadeOut(100);
    var bid = $('#image_' + uid);
    var bpr = $(window).width() - bid.offset().left;
    var bpt = bid.offset().top;
    var pid = '#bundle_' + uid;
    $(pid).appendTo('body').css({'position':'absolute','right':(bpr - 35) +'px','top':(bpt + 35) + 'px'});
    if ($(pid).is(":visible")) {
        $(pid).fadeOut(100);
    }
    else {
        $(pid).fadeIn(250).load(core_system_url +'/'+ jrFoxyCartBundle_url +'/display/id='+ uid);
    }
    return true;
}

/**
 * Close any open Bundle display box
 */
function jrFoxyCartBundle_close()
{
    $(".bundle_box").fadeOut(100);
}

/**
 * show the bundle to add this item to.
 */
function jrFoxyCartBundle_select(item_id, field, module, page)
{
    var pid = '#bundle_' + item_id;
    var url = '';
    if (page === null || typeof page == "undefined") {
        if ($(pid).is(":visible")) {
            $(pid).fadeOut(100);
            jrFoxyCartBundle_close();
        }
        else {
            $('.overlay').hide();
            jrFoxyCartBundle_position(item_id);
            url = core_system_url +'/'+ jrFoxyCartBundle_url +'/add/'+ jrE(module) +'/'+ Number(item_id) +'/field='+ jrE(field) +'/p=1/__ajax=1';
            jrCore_set_csrf_cookie(url);
            $(pid).fadeIn(250).load(url);
        }
    }
    else {
        url = core_system_url +'/'+ jrFoxyCartBundle_url +'/add/'+ jrE(module) +'/'+ Number(item_id) +'/field='+ jrE(field) +'/p='+ page +'/__ajax=1';
        jrCore_set_csrf_cookie(url);
        $(pid).load(url);
    }
}

/**
 * position the bundle on the page via javascript so it doesnt get hidden
 * by the overflow hidden on the .row class.
 */
function jrFoxyCartBundle_position(item_id)
{
    var bid = $('#bundle_button_' + item_id);
    var bpr = $(window).width() - bid.offset().left;
    var bpt = bid.offset().top;
    $('#bundle_' + item_id).appendTo('body').css({'position':'absolute','right':(bpr - 35) +'px','top':(bpt + 35) + 'px'});
}

/**
 * remove an item from a bundle
 * @param {string} dom_id DOM ID of item to remove on success
 * @param {int} bundle_id Bundle id (will be string for non logged in users)
 * @param {string} bundle_module Module Item belongs to
 * @param {int} item_id Item ID of item being removed
 */
function jrFoxyCartBundle_remove(dom_id, bundle_id, bundle_module, item_id)
{
    var url = core_system_url + '/' + jrFoxyCartBundle_url + '/remove_save/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.ajax({
        type: 'POST',
        data: {
            bundle_id: bundle_id,
            bundle_module: bundle_module,
            item_id: item_id
        },
        cache: false,
        dataType: 'json',
        url: url,
        success: function (_msg) {
            if (_msg.type == 'success') {
                window.location.reload();
            }
            else {
                alert('error received trying to remove item: ' + _msg.note);
            }
        }
    });
}

/**
 * add the selected item to the bundle
 */
function jrFoxyCartBundle_inject(bundle_id, item_id, field, module)
{
    $('.bundle_button').prop('disabled',true).addClass('form_button_disabled');
    var url = core_system_url + '/' + jrFoxyCartBundle_url + '/inject_save/__ajax=1';
    jrCore_set_csrf_cookie(url);
    $.ajax({
        type: 'POST',
        data: {
            bundle_id:      Number(bundle_id),
            item_id :       Number(item_id),
            bundle_module : module,
            field :         field
        },
        cache: false,
        dataType: 'json',
        url: url,
        success:function (_msg) {
            if (_msg.type == 'success') {
                $('.bundle_button').prop('disabled',false).removeClass('form_button_disabled');
                jrFoxyCartBundle_close();
            }
            else {
                $('.bundle_button').prop('disabled',false).removeClass('form_button_disabled');
                $('#bundle_message').addClass('error').text(_msg.note).show();
            }
        }
    });
}

/**
 * add the selected item to the bundle
 */
function jrFoxyCartBundle_new(item_id, field, module)
{
    $('.bundle_button').prop('disabled',true).addClass('form_button_disabled');
    $('#bundle_close').hide();
    $('#bundle_message').hide();
    $('#bundle_indicator').show();
    setTimeout(function () {
        var bundle_title = $('#new_bundle_'+ item_id).val();
        var bundle_price = $('#bundle_price_'+ item_id).val();
        if (bundle_title.length > 0) {
            var url = core_system_url + '/' + jrFoxyCartBundle_url + '/add_save/__ajax=1';
            jrCore_set_csrf_cookie(url);
            $.ajax({
                type: 'POST',
                data: {
                    title: bundle_title,
                    bundle_price: bundle_price,
                    item_id: Number(item_id),
                    bundle_module: module,
                    field: field
                },
                cache: false,
                dataType: 'json',
                url: url,
                success:function (_msg) {
                    if (_msg.type == 'success') {
                        $('#bundle_indicator').hide();
                        $('#bundle_message').removeClass('error').addClass('success').text(_msg.note).show();
                        setTimeout(function () {
                            jrFoxyCartBundle_close();
                            $('#bundle_close').show();
                            $('.bundle_button').prop('disabled',false).removeClass('form_button_disabled');
                        },1200);
                    }
                    else {
                        $('#bundle_close').show();
                        $('#bundle_indicator').hide();
                        $('#bundle_message').addClass('error').text(_msg.note).show();
                        $('.bundle_button').prop('disabled',false).removeClass('form_button_disabled');
                    }
                }
            });

        }
        else {
            $('#bundle_message').addClass('error').text('please enter a bundle name').show();
            $('#bundle_indicator').hide();
            $('.bundle_button').prop('disabled',false).removeClass('form_button_disabled');
        }
    }, 1000);
}
