'use strict';

/**
 * Общий функционал шаблона
 */
site.app.blocks.common = function () {
    var common = this;
    /**
     * XXX: Признак первичной инициализации (при загрузке документа)
     *
     * @var boolean
     */
    var firstInit = true;

    /**
     * XXX: Параметры viewport
     *
     * @var object
     */
    var viewport = {
        width: 0,
        height: 0,
        size: '',
        sizeChanged: false
    };

    /**
     * XXX: Обработчик изменения размеров окна браузера
     *
     * @return void
     */
    var onWindowResize = function () {
        viewport.width = $(window).width();
        viewport.height = $(window).height();

        var prevSize = viewport.size;

        //Check breakpoints
        if (viewport.width <= 660) {
            viewport.size = 's';
        } else if (viewport.width <= 960) {
            viewport.size = 'm';
        } else {
            viewport.size = 'l';
        }

        viewport.sizeChanged = viewport.size != prevSize;
    };

    /**
     * Возвращает параметры viewport
     *
     * @return object
     */
    this.getViewport = function () {
        return viewport;
    };

    /**
     * XXX: Вывод окна нотификации
     *
     * @param jQuery message string
     */
    this.showNote = function(message)
    {
        if( !$.fn.fancybox ){
            return false;
        }

        $.fancybox('<div class="window-wrap">' + message + '</div>');
    }

    /**
     * XXX: Инициализирует UI в заданном элементе DOM
     *
     * @param jQuery domElement DOM element
     * @return void
     */
    this.initDOM = function (domElement) {

        if (typeof domElement === 'undefined') {
            domElement = $('body');
        }

        if ($.fn.placeholder) {
            domElement.find('input[placeholder], textarea[placeholder]').placeholder();
        }

        if ($.fn.mask) {
            domElement.find('input[type="tel"]').mask('+7-999-9999999');
        }

        //Заставляем selectivizr заново обработать DOM при повторных инициализациях
        if (!firstInit && typeof Selectivizr != 'undefined') {
            Selectivizr.init();
        }

        // нотификации у формы профиль в шапке лк
        var $notes = domElement.find('.js-profile-header .js-notification');
        if ($notes.length) {
            $notes.each(function () {
                $(this).removeClass('none');
            });
        }


        // Показываем/скрываем пароль в полях форм
        domElement.find('.form .glyphicon-eye-open, .form .glyphicon-eye-close').click(function () {
            var icon = $(this);
            var field = icon.closest('.form-group').find('input');

            if (!icon.data('show-title')) {
                icon.data('show-title', icon.attr('title') || '');
            }

            if (icon.hasClass('glyphicon-eye-open')) {
                field.attr('type', 'text');
                icon
                    .removeClass('glyphicon-eye-open')
                    .addClass('glyphicon-eye-close')
                    .attr('title', icon.data('hide-title'));
            } else {
                field.attr('type', 'password');
                icon
                    .removeClass('glyphicon-eye-close')
                    .addClass('glyphicon-eye-open')
                    .attr('title', icon.data('show-title'));
            }

            return false;
        });
        /**
         * AJAX веб-форма
         * Обязательно нужно указать action, id и enctype="multipart/formadata"
         * Есть возможность делать редирект и перезагружать всю или часть страницы
         */
        domElement.find(".js-ajax-form").each(function (indx) {
            $(this).submit(function (event) {
                event.preventDefault(event);
                var fullReload = $(this).data("full-reload-container");
                var form = $(this);
                var id = $(this).attr("id");
                var formData = new FormData($(form)[0]);
                var loading = new site.ui.loading('body');
                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        //Если нужно, делаем редирект на указанную страницу
                        if ($(response).find(".js-redirect-url").length > 0) {
                            var redirect = $(response).find(".js-redirect-url").val();
                            window.location.href = redirect;
                        }
                        //Если нужно, перезагружаем ajax всю страницу
                        if (fullReload) {
                            response = $("<div>" + response + "</div>").find(fullReload).html();
                            $(fullReload).html(response);
                            site.ui.widgets.init(form);
                            common.initDOM($(fullReload));
                        } else {
                            form.html($('<div>' + response + '</div>').find('#' + id).html());
                            site.ui.widgets.init(form);
                            common.initDOM(form);
                        }
                        //Если форма во всплывающем окне
                        site.app.blocks.popupForm.initDOM($(".popup-form").parent());
                        loading.hide();
                        return false;
                    }
                });
            });
        });

        // для ie - отдельное приглашение
        $(function () {
            $('[autofocus]').focus()
        });

        var www = document.body.clientWidth;

        if (www > 1000 && $.fn.vegas) {
            $('.fon-slider').vegas({
                delay: 10000,
                transitionDuration: 3000,
                slides: [
                    {src: '/local/templates/main/images/general/1.jpg'},
                    {src: '/local/templates/main/images/general/2.jpg'},
                    {src: '/local/templates/main/images/general/3.jpg'},
                    {src: '/local/templates/main/images/general/4.jpg'},
                    {src: '/local/templates/main/images/general/5.jpg'},
                    {src: '/local/templates/main/images/general/6.jpg'},
                    {src: '/local/templates/main/images/general/7.jpg'},
                    {src: '/local/templates/main/images/general/8.jpg'},
                    {src: '/local/templates/main/images/general/9.jpg'},
                    {src: '/local/templates/main/images/general/10.jpg'},
                    {src: '/local/templates/main/images/general/11.jpg'},
                    {src: '/local/templates/main/images/general/12.jpg'}

                ],
                transition: ['zoomOut']
            });
        }


        // 5. Fixed Nav Menu */


        if ($(".fon-slider").length > 0) {
            var menu_container = jQuery(".fon-slider");

            var topDoc = document.documentElement.scrollTop;
            jQuery(".header").addClass('js-header_opacity');

            if( topDoc < 80) {
                jQuery(".header").addClass('js-header_opacity');
            }

            jQuery(window).scroll(function () {


                var hFirstSec = jQuery(".fon-slider").height();

                if (jQuery(this).scrollTop() < hFirstSec) {
                    jQuery(".header").addClass('js-header_opacity');
                }
                else {
                    jQuery(".header").removeClass('js-header_opacity');
                }
            });
        };


        /*Fancybox*/
        $(document).on('click', '.js-fansibox', function (e) {
            $.fancybox.close();

            $.fancybox({
                "href": $(this).attr('href'),
                "type": "ajax",
                "padding": 0,
                beforeClose: function (e) {

                    /*
                     * При закрытии окна условий обработки персональных данных,
                     * открываем раннее заполняемую форму обратной связи
                     * */
                    var $content = $('.fancybox-inner').children();
                    if ($content.attr('id') == 'join') {
                        if ($('body .none #join').length) {
                            $('body .none #join').remove();
                        }

                        $('<div>', {
                            html: $content,
                            class: 'none'
                        }).appendTo('body');
                    }
                    if ($content.attr('id') == 'agree' && $('#join').length) {
                        setTimeout(function () {
                            $.fancybox.open({href: '#join'});
                        }, 700);
                    }
                },
                afterShow: function(){
                    site.ui.widgets.init($('.fancybox-inner'));
                    site.app.blocks.init($('.fancybox-inner'));
                }
            });

            e.stopImmediatePropagation();
            return false;
        });

        $(document).on('click', '.js-close-fb', function () {
            $.fancybox.close();
        });

        if (window.pluso)if (typeof window.pluso.start == "function") return;

        if (window.ifpluso == undefined) {
            window.ifpluso = 1;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript';
            s.charset = 'UTF-8';
            s.async = true;
            s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
            var h = d[g]('body')[0];
            h.appendChild(s);
        }

        //  прокрутка к элементу по клику
        $('.js-down-section').on('click', function (e) {
            $('html,body').stop().animate({scrollTop: $(this.hash).offset().top}, 1000);
            e.preventDefault();
        });

        // загрузка файла
        var inputs = document.querySelectorAll('.inputfile');
        Array.prototype.forEach.call(inputs, function (input) {
            var label = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener('change', function (e) {
                var fileName = '';
                if (this.files && this.files.length > 1)
                    fileName = ( this.getAttribute('data-multiple-caption') || '' ).replace('{count}', this.files.length);
                else
                    fileName = e.target.value.split('\\').pop();

                if (fileName)
                    label.querySelector('span').innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });
        });

        /*
         * AJAX форма
         * data-type - тип возвращаемого сервером ответа
         * data-redirect-url - страница переадресации после успешного выполнения (Необязательный параметр)
         * */
        $(document).on('click', '.js-forma__send', function (e) {
            e.preventDefault();

            var errorFields = 0;
            var $btn = $(this);
            var $form = $btn.closest('form');
            $.each($form.find('[required]'), function (value) {
                if (!$(this).val().length) {
                    $(this).addClass('forma__inpt_error');
                    errorFields++;
                }
                else {
                    $(this).removeClass('forma__inpt_error');
                }
            });

            if( $form.find('[name=USER_PASSWORD]').length
                && $form.find('[name=USER_CONFIRM_PASSWORD]').length
                && $form.find('[name=USER_PASSWORD]').val() != $form.find('[name=USER_CONFIRM_PASSWORD]').val()
            ){
                errorFields = true;
                $.fancybox('<div class="window-wrap">Пароли&nbsp;не&nbsp;совпадают</div>');
                $('[name=USER_PASSWORD], [name=USER_CONFIRM_PASSWORD]').addClass('forma__inpt_error');
            }

            var data = $form.serializeArray();
            if( bMobile ){
                data.push({name: 'MOBILE', value: true});
            }

            if (!errorFields) {
                var loading = new site.ui.loading();
                $.ajax({
                    url: $form.attr('action'),
                    type: 'post',
                    data: data,
                    dataType: $form.data('type'),
                    success: function (response) {
                        if ( $('<div>' + response + '</div>').find('.js-success').length ) {
                            /*Показываем нотификацию, если у формы задана такая опция*/
                            if ($form.data('show-note') && $('<div>' + response + '</div>').find('.js-success').length) {
                                var $successMsg = $('<div>' + response + '</div>').find('.js-success');
                                $successMsg.find('.window-wrap').removeClass('none');
                                $.fancybox($successMsg);
                            }

                            /*Редиректим, если у формы задана такая опция*/
                            if ( $form.data('redirect-url') != undefined ) {
                                setTimeout(function () {
                                    window.location.href = ( bMobile ) ? '/' : $form.data('redirect-url');
                                }, 5000);
                            }
                        }
                        else if ($('<div>' + response + '</div>').find('.js-errors').length) {
                            $form.closest('.js-replacement').replaceWith($('<div>' + response + '</div>').find('.js-replacement'));
                        }
                        else if( response.ERROR && response.ERROR_MESSAGE ){
                            $.fancybox('<div class="window-wrap"><p class="text text_error">' + response.ERROR_MESSAGE + '</p></div>');
                        }
                        else if( response.SUCCESS && response.SUCCESS_MESSAGE ){
                            $.fancybox('<div class="window-wrap"><p class="text text_success">' + response.SUCCESS_MESSAGE + '</p></div>');
                        }

                        site.ui.widgets.init($form.attr('class'));
                        site.app.blocks.citiesAutocomplete.init();

                        loading.hide();
                    }
                });
            }
        });

        /*Поле в которое можно ввести только кириллицу*/
        $(domElement).on('keypress', '.js-rus', function() {
            var that = this;

            setTimeout(function() {
                var res = /[^а-яА-Я ]/g.exec(that.value);
                that.value = that.value.replace(res, '');
            }, 0);
        });


        /*Отмечаем чекбокс*/
        $(document).on('click', '.js-filter__checkbox', function () {
            var checked = $(this).find('input[type=checkbox]').prop('checked')
            $(this).find('input[type=checkbox]').prop('checked', !checked).trigger('change');

            if ($(this).hasClass('js-agree') && !checked) {
                $(this).closest('form').find('[disabled]').removeAttr('disabled');
            }
            else if ($(this).hasClass('js-agree') && checked) {
                $(this).closest('form').find('.js-forma__send').attr('disabled', true);
            }
        });

        var bMobile = parseInt($(window).width()) <= 1000;
        if( window.location.pathname == '/personal/' && bMobile ){
            window.location.href = '/';
        }
        else if( bMobile ){
            $('.header__autoziz-buttons').hide();
        }

        common.checkMobile = function(){
            return bMobile;
        }


        firstInit = false;
    };

    /**
     *
     * Обновление блока по ajax
     *
     * @param url ссылка
     * @param reloadContainerSelector селектор контейнера
     * @param setIdContainerInHash добавлять ли в url браузера id контейнера
     */

    common.reloadContainer = function (url, reloadContainerSelector, setIdContainerInHash, bChangeUrl) {
        var $reloadContainer = $(reloadContainerSelector);
        var loading = new site.ui.loading();

        $.ajax({
            url: url,
            success: function (response) {
                var newContainerHtml = $('<div>' + response + '</div>').find(reloadContainerSelector).html();
                ;
                $reloadContainer.html(newContainerHtml);
                site.app.blocks.common.initDOM($reloadContainer);
                site.app.blocks.init();
                if (setIdContainerInHash == true) {
                    url += "#" + $reloadContainer.attr("id");
                }
                if (bChangeUrl) {
                    window.history.pushState("", "", url);
                }

                loading.hide();
            }
        });
    };


    //Обработчик ресайза окна
    $(window).resize(onWindowResize);
    onWindowResize();

    //Обработчик инициализиации UI
    site.ui.onInit(this.initDOM, this);
};


/**
 * Блок шаблона "Ajax pager"
 */
site.app.blocks.pager = function () {
    // обычная постраничка
    $(document).on("click", ".js-ajax-pagenation a", function (e) {
        if ($(this).hasClass('is-disabled')) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            return false;
        }
        var reloadContainerId = $(this).closest(".js-ajax-container").attr("id");
        var reloadContainerSelector = "#" + reloadContainerId;
        var url = $(this).attr("href");
        site.app.blocks.common.reloadContainer(url, reloadContainerSelector, $(this).data('set-hash'), $(this).data('change-url'));
        e.stopPropagation();
        return false;
    });
};

/**
 * Проверяет наличие блока "Ajax pager"
 *
 * @return boolean
 */
site.app.blocks.pager.exists = function () {
    return $('.js-ajax-pagenation, .js-ajax-pagenation-more').length > 0;
};


/**
 * Блок шаблона "Карта пользователей"
 */
site.app.blocks.map = function () {
    var mapBlock = this;

    mapBlock.arPoints = [];

    /*Добавление кластеров. Инлайном этот код выполнить не можем из-за задержки ответа от геокодера*/
    mapBlock.addClusster = function (map) {
        var clusterer = new ymaps.Clusterer({
            // Зададим массив, описывающий иконки кластеров разного размера.
            clusterIcons: [
                {
                    href: '/local/templates/main/images/general/clasters.svg',
                    size: [37, 41],
                    offset: [-20, -20]
                },
                {
                    href: '/local/templates/main/images/general/clasters.svg',
                    size: [44, 49],
                    offset: [-20, -20]
                },
                {
                    href: '/local/templates/main/images/general/clasters.svg',
                    size: [44, 49],
                    offset: [-20, -20]
                },
                {
                    href: '/local/templates/main/images/general/clasters.svg',
                    size: [54, 60],
                    offset: [-20, -20]
                },
                {
                    href: '/local/templates/main/images/general/clasters.svg',
                    size: [76, 84],
                    offset: [-20, -20]
                },
            ],
            /*Каждому размеру кластера присваиваем свою иконку*/
            clusterNumbers: [10, 100, 1000],
            hasBalloon: false
        });
        /*Задаем опции кластеризатору*/
        clusterer.options.set({
            hasBalloon: false,
            hasHint: false
        });
        /*Добавляем кластеризатор на карту*/
        clusterer.add(mapBlock.arPoints);
        map.geoObjects.add(clusterer);
    }

    var map,
        $map,
        mapId,
        arPlacemarks,
        arPlacemarksCnt,
        myPlacemark,
        myCollection,
        myGeocoder,
        arCoords,
        arAddrCoords;

    $.each($('.js-map'), function () {
        $map = $(this);
        mapId = $map.attr('id');
        arPlacemarks = $map.data('points');
        arPlacemarksCnt = arPlacemarks.length;

        ymaps.ready(function () {
            /*Создаем карту*/
            map = new ymaps.Map(mapId, {
                center: [55.76, 37.64],
                zoom: 3,
                controls: ['zoomControl'],
            }, {
                suppressMapOpenBlock: true,
                minZoom: 2
            });

            /*Расставляем точки*/
            if (arPlacemarks != undefined) {
                $.each(arPlacemarks, function (index, arPoint) {
                    arCoords = arPoint.COORDS.split(' ');
                    arCoords = arCoords.reverse();
                    var icon = arPoint.IMAGE.src;
                    icon = ( icon != undefined ) ? icon : '/local/templates/main/images/avatar.png';
                    if( arPoint.COORDS.length ){
                        mapBlock.arPoints.push(new ymaps.Placemark(arCoords, {}, {
                            iconLayout: 'default#image',
                            iconImageHref: icon,
                            iconImageSize: [44, 44],
                        }));
                    }
                });
                mapBlock.addClusster(map);
            }
        });
    });
};

/**
 * Проверяет наличие блока "Ajax pager"
 *
 * @return boolean
 */
site.app.blocks.map.exists = function () {
    return $('.js-map').length > 0;
};


/**
 * Блок грида юзеров
 */
site.app.blocks.usersGrid = function () {

    /*Делаем поле пароля редактируемым*/
    $(document).on("click", ".js-change-info", function (event) {
        event.preventDefault();
        var $btn = $(this);
        $btn.text('Сохранить').removeClass('js-change-info').addClass('js-save-info');

        var obUTypes = {};
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: '/ajax/user/getUTypesInfo/',
            data: {},
            success: function (response) {
                obUTypes = response;

                $($btn).closest('tr').find('.js-editable').each(function (index, el) {
                    if ($(el).data('property') == 'UF_USER_TYPE' && !$.isEmptyObject(obUTypes)) {
                        var $newEl = $('<select>');
                        $.each(obUTypes, function (propValId, propVal) {
                            $('<option>', {'val': propValId, 'text': propVal}).appendTo($newEl);
                        });

                        $(el).html($newEl.wrapAll('<div>').parent().html());
                    }
                    else {
                        $(el).html($('<input>', {
                            type: 'text',
                            value: $(el).text(),
                            name: $(el).data('property'),
                        }));
                    }
                });
            }
        });
    });

    /*Меняем пароль*/
    $(document).on('click', '.js-save-info', function () {
        var loading = new site.ui.loading();
        var $btn = $(this);
        var uid = $(this).data('user-id');
        var $editableCols = $(this).closest('tr').find('.js-editable');

        var data = {'USER_ID': uid, 'ACTION': 'UPDATE_ALL'};
        $editableCols.each(function (index, el) {
            data[$(el).data('property')] = $(el).find('input, select').val();
        });

        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: '/ajax/user/updateUInfo/',
            data: data,
            success: function (response) {
                window.location.href = '/admin/?TAB=users';
                $btn.removeClass('js-save-info').addClass('js-change-info').text('Изменить');
                loading.hide();
            }
        });
    });

    /*Блокируем*/
    $(document).on('click', '.js-block-user', function () {
        var loading = new site.ui.loading();
        var $btn = $(this);
        var uid = $(this).data('user-id');
        var status = $(this).data('status');

        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: '/ajax/user/updateUInfo/',
            data: {'USER_ID': uid, 'ACTION': 'BLOCK_USER', 'STATUS': status},
            success: function (response) {
                var btnText = ( $btn.text() == 'Разблокировать' ) ? 'Заблокировать' : 'Разблокировать';
                $btn.text(btnText).data('status', ( $btn.data('status') == 'Y' ) ? 'N' : 'Y');
                loading.hide();
            }
        });
    });


};

/**
 * Проверяет наличие блока грида юзеров
 *
 * @return boolean
 */
site.app.blocks.usersGrid.exists = function () {
    return $('#grid_user').length > 0;
};


/**
 * Блок грида пакетов
 */
site.app.blocks.packetsGrid = function () {
    var packetsGrid = this;

    /*Принимаем пакет*/
    $(document).on('click', '.js-packet-confirm', function (event) {
        event.preventDefault();

        var loading = new site.ui.loading();
        var $btn = $(this);
        var packetId = $btn.data('packet-id');
        var action = 'CONFIRM';

        packetsGrid.updatePacket(packetId, action, $btn);
    });

    /*Отклоняем пакет*/
    $(document).on('click', '.js-packet-cancel', function (event) {
        event.preventDefault();

        var loading = new site.ui.loading();
        var packetId = $(this).data('packet-id');

        $.fancybox({type: 'ajax', href: '/ajax/packets/getCancelReasons/?PACKET_ID=' + packetId});
    });

    /*Подтверждаем отклонение пакета*/
    $(document).on('click', '.js-cancel-confirm', function (event) {
        event.preventDefault();

        var loading = new site.ui.loading();
        var packetId = $(this).closest('form').data('packet-id');

        packetsGrid.updatePacket(packetId, 'CANCEL');
    });

    /*Принимаем пакет с внесенными правками*/
    $(document).on('click', '.js-upload-confirm', function (event) {
        event.preventDefault();

        var $btn = $(this);
        var packetId = $btn.data('packet-id');

        $('[name=PACKET_CHANGED]').remove();
        $btn.closest('tr').append('<input type="file" name="PACKET_CHANGED" class="none">');
        $('[name=PACKET_CHANGED]').trigger('click');
    });

    /*После выбора файла, принимаем пакет*/
    $(document).on('change', '[name=PACKET_CHANGED]', function () {
        packetsGrid.updatePacket(
            $(this).closest('tr').find('.js-upload-confirm').data('packet-id'),
            'CONFIRM_UPLOAD',
            $(this)
        );
    });

    /*Обновление информации по пакету*/
    this.updatePacket = function (packetId, action, $source) {
        var loading = new site.ui.loading();
        var obData = new FormData();

        if (action == 'CONFIRM_UPLOAD') {
            obData.append('PACKET_FILE', $('[name=PACKET_CHANGED]')[0].files[0])
        }

        if (action == 'CANCEL') {
            obData.REASONS = '';
            var reasons = '';
            $(document).find('form[name=PACKET_CANCEL] input:checked').each(function () {
                reasons += ((reasons.length) ? '|' : '') + $(this).siblings('span').text();
            });
            obData.append('REASONS', reasons);
        }

        obData.append('PACKET_ID', packetId);
        obData.append('ACTION', action);

        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: '/ajax/packets/updatePInfo/',
            data: obData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.SUCCESS) {
                    if ($source != undefined) {
                        $source.closest('tr').hide();
                        $.fancybox('<div class="window-wrap"><p class="text text_success">Информация обновлена</p></div>');
                    }
                    else {
                        location.reload();
                    }
                }
                else if (response.ERROR && response.ERROR_MESSAGE.length) {
                    $.fancybox('<div class="window-wrap"><p class="text text_error">' + response.ERROR_MESSAGE + '</p></div>');
                }

                loading.hide();
            }
        });
    }

};

/**
 * Проверяет наличие блока грида юзеров
 *
 * @return boolean
 */
site.app.blocks.packetsGrid.exists = function () {
    return $('#grid_pack').length > 0;
};


/**
 * Блок профиля в шапке лк
 */
site.app.blocks.personal = function () {

    var personal = this;

    /*
     * Перезагрузка формы
     * */

    personal.reload = function reload($obj) {
        var $form = $obj.closest('.js-profile-form');
        $form.find('input[name="NEW_PASSWORD_CONFIRM"]').val($form.find('input[name="NEW_PASSWORD"]').val());
        $form.find(".verificator__user-field").attr("disabled", false);
        $form.find('.js-submit-form').trigger('click');
    };

    personal.showError = function ($form, text) {
        var $notification = $form.find('.js-notification');
        $notification.addClass('none');
        var $notificationHidden = $form.find('.js-notification-hidden');
        var $notificationTitle = $notificationHidden.find('.js-notification-title');

        $notificationTitle.html(text);
        $notificationHidden.removeClass('none');
    };


    // разблокрировка формы в профиле и нааборот
    $(document).on('click', '#edit-profil', function () {
        $(".verificator__btn").show();
        $(this).hide();
        $(".verificator__user-field, .verificator_line-border")
            .addClass("active")
            .attr("disabled", false);
        $(".verificator__password").attr("disabled", false);
        var $form = $(this).closest('.js-profile-form');
        $form.find('.js-country-label').addClass('none');
        $form.find('.js-country-select').removeClass('none');

    });

    $(document).on('click', '#verificator-save', function (ret) {
        personal.reload($(this));
        ret.stopPropagation();
        ret.preventDefault();
        return false;

    });

    $(document).on('change', '.js-avatar', function () {
        var $form = $(this).closest('.js-profile-form');
        var file = this.files[0];
        var filesExt = ['jpg', 'gif', 'png']; // массив расширений
        var size = file.size;
        var parts = $(this).val().split('.');
        if(filesExt.join().search(parts[parts.length - 1]) != -1){
            console.log('Файл загружен');
        }
        else {
            personal.showError($form, 'Неверный тип файла!');
            return;
        }

        if(size > 2097152) {
            personal.showError($form, 'Файл слишком большой по размеру!');
            return;
        }

        personal.reload($(this));
    });

    $(document).on('click', '.js-reset', function () {
        var $form = $(this).closest('.js-profile-form');
        $(".verificator__user-field, .verificator_line-border")
            .removeClass("active")
            .attr("disabled", true);

        $(".verificator__btn").hide();
        $("#edit-profil").show();
        $form.find('.js-country-label').removeClass('none');
        $form.find('.js-country-select').addClass('none');
    });

    /*
     * Не даем кликать по неактивным шагам
     * */
    $(document).on('click', '.js-how-begin__step a', function (event) {
        if ($(this).closest('.js-how-begin__step').hasClass('how-begin__step_noactive')) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('click', '.js-dm-activate', function () {
        if (!$(this).closest('.how-begin__step').hasClass('how-begin__step_noactive')) {
            $('.js-dm').val('true');
            personal.reload($(this));
        }
    });

    $(document).on('click', '.js-ifr-activate', function () {
        if (!$(this).closest('.how-begin__step').hasClass('how-begin__step_noactive')) {
            $('.js-ifr').val('true');
            personal.reload($(this));
        }
    });

    /**
     * Получение триалки
     * */
    $(document).on('click', '.js-gt-activate', function (event) {
        event.preventDefault();
        if ($(this).closest('.how-begin__step_noactive').length) {
            return false;
        }
        var $obj = $(this);
        $.ajax({
            url: '/ajax/trials/getTrial/',
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.SUCCESS && response.TRIAL_KEY.length) {
                    $.fancybox('<div class="window-wrap">Ваш серийный номер:<br /><b> ' + response.TRIAL_KEY + '</b></div>');
                    if (!$obj.closest('.how-begin__step').hasClass('how-begin__step_noactive')) {
                        $('.js-gt').val('true');
                        personal.reload($obj);
                    }
                }

            }
        });
    });

    /**
     * Получение пакета
     * */
    $(document).on('click', '.js-gp-activate', function (event) {
        event.preventDefault();
        if ($(this).closest('.how-begin__step_noactive').length) {
            return false;
        }

        var $btn = $(this);
        var loading = new site.ui.loading();

        $.ajax({
            url: '/ajax/packets/getPacket/',
            data: {},
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.SUCCESS && response.FILE_SRC) {
                    loading.hide();
                    window.location.href = response.FILE_SRC;

                    if ($btn.closest('.js-profile-form').length && !$('.js-status').length) {
                        $btn.removeClass('js-gp-activate').addClass('js-upload-packet').text('Отправить пакет');
                        $btn
                            .closest('.get-packet')
                            .find('.get-packet__text')
                            .html('Чтобы скачать следующий пакет, завершите проверку предыдущего<br>и&nbsp;загрузите его на сайт, нажав кнопку "Отправить пакет"')
                            .addClass('text_left');
                    }

                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }
                else if( response.ERROR && response.ERROR_MESSAGE.length ){
                    loading.hide();
                    $.fancybox('<div class="window-wrap">' + response.ERROR_MESSAGE + '</div>');
                }
            }
        })

    });


    /*Сдаем пакет на проверку*/
    $(document).on('click', '.js-upload-packet', function (event) {
        event.preventDefault();

        var $btn = $(this);
        var packetId = $btn.data('packet-id');

        $('[name=UPLOAD_PACKET]').remove();
        $btn.parent().append('<input type="file" name="UPLOAD_PACKET" id="packet-upload-test-denis" class="none">');
        $('[name=UPLOAD_PACKET]').trigger('click');
    });

    /*
     * Сдача пакета на проверку
     * */
    $(document).on('change', '[name=UPLOAD_PACKET]', function () {
        var loading = new site.ui.loading();
        var packetId = $(this).parent().find('.js-upload-packet').data('packet');
        var obData = new FormData();

        obData.append('PACKET_FILE', $('[name=UPLOAD_PACKET]')[0].files[0]);
        obData.append('PACKET_ID', packetId);
        obData.append('ACTION', 'PASS');
        $.ajax({
            method: 'POST',
            url: '/ajax/packets/updatePInfo/',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: obData,
            success: function (response) {
                if (response.SUCCESS) {
                    location.reload();
                }
                else if (response.ERROR && response.ERROR_MESSAGE.length) {
                    $.fancybox('<div class="window-wrap">' + response.ERROR_MESSAGE + '</div>');
                }

                loading.hide();
            }
        })
    });
};


/**
 * Проверяет наличие блока профиля в шапке лк
 *
 * @return boolean
 */
site.app.blocks.personal.exists = function () {
    return ( $('.js-profile-header').length || $('.js-packet-actions').length );
};


/*
 * Адаптация меню для администратора
 *
 * */
site.app.blocks.adminPanel = function () {
    $(window).scroll(function(){
        var fromTop = $(this).scrollTop();
        if( fromTop >= 0 && fromTop < 40 ){
            $('.page__wrapper header').css('marginTop', 40 - fromTop);
        }
        else{
            $('.page__wrapper header').css('marginTop', 0);
        }
    });
};
site.app.blocks.adminPanel.exists = function () {
    return ( $('.page__wrapper_authorized').length );
};

/**
 * Список городов с автодополнением
 */
site.app.blocks.citiesAutocomplete = function () {
    this.init = function()
    {
        $('.js-city-selector').autocomplete({
            minLength: 2,
            source: function( request, response ) {
                var term = request.term;
                $.getJSON( "/ajax/cities/getCitiesArray/", request, function( data, status, xhr ) {
                    response(data);
                });
            }
        });
    }

    this.init();
};
site.app.blocks.citiesAutocomplete.exists = function () {
    return ( $('.js-city-selector').length && $.fn.autocomplete );
};

/**
 * Проверка блокировки пользователя
 */
site.app.blocks.checkUserStatus = function () {
    var interval = setInterval(function(){
        $.ajax({
            url: '/ajax/user/checkUserStatus',
            method: 'post',
            dataType: 'json',
            success: function(response){
                if( response.ERROR && response.ERROR_TEXT.length ){
                    site.app.blocks.common.showNote(response.ERROR_TEXT);
                    setTimeout(function(){
                        window.location.href = '/';
                    }, 3000);
                }
            }
        });
    }, 1000 * 30);
};
site.app.blocks.checkUserStatus.exists = function () {
    return ( $('.js-personal-page').length );
};


/**
 * Блок шаблона "Стандартный индикатор ajax-битрикса"
 */
site.app.blocks.bitrixDefaultIndicator = function () {
    var lastWait = [];
    /* non-xhr loadings */
    BX.showWait = function (node, msg) {
        node = BX(node) || document.body || document.documentElement;
        msg = msg || BX.message('JS_CORE_LOADING');
        var container_id = node.id || Math.random();
        var obMsg = node.bxmsg = document.body.appendChild(BX.create('DIV', {
            props: {
                id: 'wait_' + container_id,
                className: 'bx-core-waitwindow'
            },
            text: msg
        }));
        var loading = new site.ui.loading($(node));
        window.loading = loading;
        lastWait[lastWait.length] = obMsg;
        return obMsg;
    };
    BX.closeWait = function (node, obMsg) {
        window.loading.hide();
        if (node && !obMsg)
            obMsg = node.bxmsg;
        if (node && !obMsg && BX.hasClass(node, 'bx-core-waitwindow'))
            obMsg = node;
        if (node && !obMsg)
            obMsg = BX('wait_' + node.id);
        if (!obMsg)
            obMsg = lastWait.pop();
        if (obMsg && obMsg.parentNode) {
            for (var i = 0, len = lastWait.length; i < len; i++) {
                if (obMsg == lastWait[i]) {
                    lastWait = BX.util.deleteFromArray(lastWait, i);
                    break;
                }
            }
            obMsg.parentNode.removeChild(obMsg);
            if (node)
                node.bxmsg = null;
            BX.cleanNode(obMsg, true);
        }
    };
    BX.addCustomEvent('onAjaxSuccess', function () {
        site.ui.widgets.init();
        site.app.blocks.init();
        site.app.blocks.common.initDOM();
    });
};


/* Инициализация после готовности DOM */
$(function () {
    site.init();
});