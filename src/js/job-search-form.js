/*
The Job Form Search Functionality
*/
jQuery(document).ready(function ($) {

    $('.dropdown__list').children('li').on('click', function () {
        var thisSelection = $(this).attr('data-slug');
        $(this).parent().siblings('.dropdown__wrap').children('input').attr('data-cur', thisSelection);

    });

    var userLocationGeocodeLat;
    var userLocationGeocodeLng;
    var locationsRelevant = '';
    var locationsRelevantLive = '';
    var str;
    var thisRadius;

    // if present, get stored view from local storage using nullFirst ternary
    var userViewPref = (!localStorage ? 'list' : localStorage.getItem('search_results_view'));

    if (userViewPref != null) {
        // load the preferred view on init, force element click
        $('.search_contain__label--' + userViewPref).click();
    }

    // onchange, store the preference
    $('.search_contain__label').on('click', function () {
        // check if element has the list class, if not, map has been clicked
        var newView = ($(this).hasClass('search_contain__label--list') ? 'list' : 'map');
        if (!localStorage) {
            // extremely wide usage however some browsers may lack support (Opera, etc)
            // TODO: fallback to cookie
            return;
        }

        localStorage.setItem('search_results_view', newView);
    });

    $('.btn-reset').click(function () {
        $(':input', '#search-form')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
        $('#radius').val('10');

        window.location = window.location.origin + '?s=';
    });

    // take control of the radius select box
    // force check on page load
    $('#location').on('keyup', function () {
        var val = $(this).val(),
            radius = $('#radius'),
            radiusNow = radius.parent('.select-list').data('miles');

        if (!val) {
            radius.attr('disabled', 'disabled').hide();
        } else {
            radius.attr('disabled', null).val(radiusNow || 10).fadeIn();
        }
    }).keyup();

    $('#search-form').on('submit', function (event) {

        event.preventDefault();
        var keyword = $(this).find('#keyword').val() || '',
            roleType = $(this).find('#role-type').val() || '',
            salaryRange = $(this).find('#salary-min').val() || '',
            workingPattern = $(this).find('#working-pattern').val() || '',
            thisLocation = $(this).find('#location').val() || '',
            thisRadius = parseInt($(this).find('#radius').val()) || 10;

        var keywordLive = '',
            roleTypeLive = '',
            salaryRangeLive = '',
            workingPatternLive = '',
            locationLive = '',
            radiusLive = '';

        if (_hasString(keyword)) {
            keywordLive = keyword;
        }

        if (!_hasString(roleType)) {
            roleTypeLive = '';
        } else {
            if (roleType === 'all') {
                roleTypeLive = '';
            } else {
                roleTypeLive = '&role-type=' + roleType;
            }
        }

        if (!_hasString(salaryRange)) {
            salaryRangeLive = '';
        } else {
            if (salaryRange === 'all') {
                salaryRangeLive = '';
            } else {
                salaryRangeLive = '&salary-min=' + salaryRange;
            }
        }

        if (!_hasString(workingPattern)) {
            workingPatternLive = '';
        } else {
            if (workingPattern === 'all') {
                workingPatternLive = '';
            } else {
                workingPatternLive = '&working-pattern=' + workingPattern;
            }
        }

        if (_hasString(thisLocation)) {
            locationLive = '&location=' + thisLocation;
            radiusLive = '&radius=' + thisRadius;
            str = '?s=' + keywordLive + roleTypeLive + salaryRangeLive + workingPatternLive + locationLive + radiusLive;
            getJSON(thisLocation, thisRadius);
        } else {
            str = '?s=' + keywordLive + roleTypeLive + salaryRangeLive + workingPatternLive;
            localStorage.setItem("currentSearch", str);

            window.location = window.location.origin + str;
        }
    });

    $('#mini-search-form').on('submit', function (e) {
        e.preventDefault();
        var keyword = $(this).find("#keyword").val() || '',
            thisLocation = $(this).find('#location').val() || '',
            locationLive = '',
            radiusLive,
            keywordLive = '',
            thisRadius = $(this).find('#radius').val() || 10;

        if (_hasString(keyword)) {
            keywordLive = keyword;
        }

        if (_hasString(thisLocation)) {
            locationLive = '&location=' + thisLocation;
            radiusLive = '&radius=' + parseInt(thisRadius);
            str = '?s=' + keywordLive + locationLive + radiusLive;
            getJSON(thisLocation, thisRadius);
        } else {
            str = '?s=' + keywordLive;
            window.location = window.location.origin + str;
        }
    });

    function _hasString(string) {
        return string !== '';
    }

    function getJSON(userLocation, userRadius) {
        $.ajax({
            type: "post",
            dataType: "json",
            url: justice.ajaxurl,
            data: {action: "get_location_coordinates", location: userLocation},
            success: function (response) {
                if (response.error !== true) {
                    userLocationGeocodeLat = parseFloat(response.lat);
                    userLocationGeocodeLng = parseFloat(response.lng);
                    testEachMarker(userRadius);
                } else {
                    console.log(response.error);
                }
            }
        })
    }

    function testEachMarker(userRadius) {
        $('#allLocations li').each(function (k) {
            var thisLAT = parseFloat($(this).data('lat')),
                thisLNG = parseFloat($(this).data('lng')),
                p1 = new google.maps.LatLng(thisLAT, thisLNG),
                p2 = new google.maps.LatLng(userLocationGeocodeLat, userLocationGeocodeLng),
                currentDistance = calcDistance(p1, p2),
                thisRadiusInMiles = parseInt(userRadius) * 1.609344;

            if (parseInt(currentDistance) < thisRadiusInMiles) {
                locationsRelevant += $(this).data('id') + ', ';
            }

            //calculates distance between two points in km's
            function calcDistance(p1, p2) {
                return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
            }
        });

        locationsRelevantLive = '&locations-relevant=' + locationsRelevant;

        str = str + locationsRelevantLive;
        window.location = window.location.origin + str;
    }
});
