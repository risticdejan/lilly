$.validator.addMethod("alfaNumericSpaces", function(value, element) {
    return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
}, "Polje može da sadrži samo slova, brojeve i prazna mesta.");

var Auth = {
    config: {
        form: '#login'
    },

    init: function (config) {
        $.extend(this.config, config);

        this.bindEvents();
    },

    bindEvents: function () {
        var config = this.config,
            form = config.form;

        $(form).find('button.submit').on('click', $.proxy(this.login,this));
        $(form).on('focus', 'input', this.removeSpan);

    },

    validateForm: function(form) {
        return $(form).validate({
            lang: 'en',
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    },


    removeSpan: function() {
        var $this = $(this);

        $this.siblings('span.err').remove();
    },


    login: function (e) {
        var config = this.config,
            $form = $(config.form),
            url = $form.attr('action'),
            data = $form.serialize(),
            validator;


        validator = this.validateForm(config.form);


        if(validator.form()){
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                dataType: 'JSON'
            }).done(function (data) {
                if(data.status == 'success'){
                    alert(data.message);
                    window.location = data.url
                } else {
                    console.log(data.message);
                    if(data.errors) {
                        $('.err').remove();
                        $('#email').closest('div').append(data.errors.email);
                        $('#password').closest('div').append(data.errors.password);
                    } else {
                        alert(data.message);
                        window.location = url;
                    }

                }
            });
        }



        e.preventDefault();
    }
};

Auth.init();

var Admin = {
    config: {
        form: '#send_data',
        stores: '#store_list'
    },

    init: function (config) {
        $.extend(this.config, config);

        this.bindEvents();
        this.updateStores();
    },

    bindEvents: function () {
        var self = this,
            config = self.config,
            form = config.form;

        $(form).find('button.submit').on('click', $.proxy(this.send,this));
        $(form).on('focus', 'input', this.removeSpan);

        $('#grad').on('change', function(e) {
            var city_id = this.value,
                url = $(this).data('url');
            self.updateOpstine( city_id, url);
            e.preventDefault();
        })

    },

    validateForm: function(form) {
        return $(form).validate({
            lang: 'en',
            rules: {
                naziv: {
                    required: true,
                    alfaNumericSpaces: true,
                    maxlength: 255
                },
                adresa: {
                    required: true,
                    alfaNumericSpaces: true,
                    maxlength: 255
                },
                grad: {
                    required: true,
                    digits: true,
                    maxlength: 11
                },
                opstina: {
                    required: true,
                    digits: true,
                    maxlength: 11
                },
                lat: {
                    required: true,
                    number: true,
                    maxlength: 11
                },
                lon: {
                    required: true,
                    number: true,
                    maxlength: 11
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    },

    removeSpan: function() {
        var $this = $(this);

        $this.siblings('span.err').remove();
    },

    updateOpstine: function(value, url) {
        var $select = $('#opstina');
        $.ajax({
            url: url,
            data: {
                city_id: value,
                csrf_token: $('input[name="csrf_token"]').val()
            },
            type: 'POST',
            dataType: 'JSON'
        }).done(function (data) {

            $('input[name="csrf_token"]').val(data.csrf_token);

            var temp = '';

            if(data.opstine){
                data.opstine.forEach(function (item) {
                    temp += "<option value='" + item.id + "'>" + item.naziv + "</option>";
                });

                $select.empty().append(temp);
            }
        });
    },

    updateStores: function() {
        var self = this,
            config = self.config,
            $stores = $(config.stores);
        if($stores.length > 0){
            setTimeout(function(){
                self.handleRequestForUpdateStores($stores);
                self.updateStores();
            }, 2000);
        }
    },

    send: function (e) {
        var config = this.config,
            $form = $(config.form),
            url = $form.attr('action'),
            data = $form.serialize(),
            validator;


        validator = this.validateForm(config.form);


        if(validator.form()){
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                dataType: 'JSON'
            }).done(function (data) {
                $('input[name="csrf_token"]').val(data.csrf_token);
                if(data.status == 'success'){
                    alert(data.message);
                    $form.trigger("reset");
                } else {
                    if(data.errors) {
                        $('.err').remove();
                        $('#naziv').closest('div').append(data.errors.naziv);
                        $('#adresa').closest('div').append(data.errors.adresa);
                        $('#grad').closest('div').append(data.errors.grad);
                        $('#opstina').closest('div').append(data.errors.opstina);
                        $('#lat').closest('div').append(data.errors.lat);
                        $('#lon').closest('div').append(data.errors.lon);
                    } else {
                        alert(data.message);
                    }

                }
            });
        }
        e.preventDefault();
    },

    handleRequestForUpdateStores: function($stores){
        var url = $stores.data('url');
        $.ajax({
            url: url,
            data: {
                csrf_token: $('input[name="csrf_token"]').val()
            },
            type: 'POST',
            dataType: 'JSON'
        }).done(function (data) {
            $('input[name="csrf_token"]').val(data.csrf_token);
            var temp = '';
            if(data.pmesta){
                data.pmesta.forEach(function (item) {
                    temp += "<tr>";
                    temp += "<td>" + item.naziv + "</td>";
                    temp += "<td>" + item.adresa + "</td>";
                    temp += "<td>" + item.grad + "</td>";
                    temp += "<td>" + item.opstina + "</td>";
                    temp += "<td>" + item.lat + "</td>";
                    temp += "<td>" + item.lon + "</td>";
                    temp += "</tr>";
                });

                $stores.empty().append(temp);
            }
        });
    }

};

Admin.init();

var Upload = {
    config: {
        form: '#upload_data',
        files: null,
        spinner: '.loader',
        fieldImage: '.img-wrapper'
    },

    init: function (config) {
        $.extend(this.config, config);

        $(this.config.spinner).hide();

        this.bindEvents();
    },

    bindEvents: function () {
        var self = this,
            config = self.config,
            form = config.form;

        $(form).find('button.submit').on('click', $.proxy(this.send,this));
        $(form).on('focus', 'input', this.removeSpan);


        $('input[type=file]').on('change', function (event){
            config.files = event.target.files;
        });
    },

    validateForm: function(form) {
        return $(form).validate({
            lang: 'en',
            rules: {
                kategorija: {
                    required: true,
                    digits: true,
                    maxlength: 11
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    },


    removeSpan: function() {
        var $this = $(this);

        $this.siblings('span.err').remove();
    },


    send: function (e) {
        var config = this.config,
            $form = $(config.form),
            url = $form.attr('action'),
            validator;


        validator = this.validateForm(config.form);

        if(validator.form()){
            $(config.spinner).show();
            $(config.fieldImage).hide();
            $.ajax({
                url: url,
                data:  new FormData($form[0]),
                contentType: false,
                cache: false,
                processData:false,
                type: 'POST',
                dataType: 'JSON'
            }).done(function (data) {
                $('input[name="csrf_token"]').val(data.csrf_token);
                $(config.spinner).hide();
                $(config.fieldImage).show();
                if(data.status == 'success'){
                    alert(data.message);
                    $form.trigger("reset");
                } else {
                    if(data.errors) {
                        $('.err').remove();
                        $('#kategorija').closest('div').append(data.errors.kategorija);
                        $('#image').closest('div').append(data.errors.image);
                    } else {
                        alert(data.message);
                    }

                }
            }).fail(function (e) {
                $(config.spinner).hide();
                $(config.fieldImage).show();
            });
        }
        e.preventDefault();
    },

};

Upload.init();

var Barcode = {
    config: {
        insert: '#insert-csv',
        delete: '#delete-csv',
        spinner: '.main-loader',
        field_code: '#code',
        field_name: '#name',
        form: '#search'
    },

    init: function (config) {
        $.extend(this.config, config);

        this.bindEvents();
    },

    bindEvents: function () {
        var self = this,
            config = self.config;

        $(config.insert).on('click', $.proxy(this.insertData,this));

        $(config.delete).on('click', $.proxy(this.deleteData,this));


        $(config.field_code).keyup( 'keyup', $.proxy(this.search, this));
        $(config.field_name).keyup( 'keyup', $.proxy(this.search, this));

        $('#DropdownSuggest').on('click', 'a.dropdownlivalue' , function (e) {
            console.log($(this).data('code'));
            var $el = $(this),
                code = $el.data('code'),
                name = $el.html();

            var str = '<span ><b>Code: </b>' + code + '</span><br/>';
                str += '<span ><b>Naslov: </b>' + name + '</span><br/>';

            $('#DropdownSuggest').hide();
            $('#code-area').html(str).show();
            e.preventDefault();
        })
    },

    insertData: function (e) {

        var el = e.target,
            config = this.config,
            url = $(el).attr('href');


        $(config.spinner).show();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'JSON'
        }).done(function (data) {
            $(config.spinner).hide();
            if(data.status == 'success'){
                alert(data.message);
            }
        }).fail(function (err) {
            $(config.spinner).hide();
        });

        e.preventDefault();
    },

    deleteData: function (e) {

        var el = e.target,
            config = this.config,
            url = $(el).attr('href');


        $(config.spinner).show();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'JSON'
        }).done(function (data) {
            $(config.spinner).hide();
            if(data.status == 'success'){
                alert(data.message);
            }
        }).fail(function (err) {
            $(config.spinner).hide();
        });

        e.preventDefault();
    },

    search: function (e) {
        var self = this,
            config = self.config,
            $el_code = $(config.field_code),
            $el_name = $(config.field_name),
            code = $el_code.val(),
            name = $el_name.val(),
            url = $(config.form).attr('action').replace("search","");

        $('#code-area').empty().hide();

        $.ajax({
            url: url,
            data: {
                name: name,
                code: code,
                csrf_token: $('input[name="csrf_token"]').val()
            },
            type: 'POST',
            dataType: 'JSON'
        }).done(function (data) {
            $('input[name="csrf_token"]').val(data.csrf_token);
            console.log(data);

            if (data.arr.length > 0) {
                $('#DropdownSuggest').empty().show();
                $('#DropdownSuggest').dropdown('toggle');
            }
            else if (data.arr.length == 0) {
                $('#DropdownSuggest').hide();
            }

            $.each(data.arr, function (key,value) {
                if (data.arr.length >= 0){
                    var str = '<li >';
                        str += '<a data-code=' + value['code'] + ' href="#" class="dropdownlivalue">';
                        str += value['name'];
                        str += '</a></li>';
                    $('#DropdownSuggest').append(str);
                }
            });

        });

        e.preventDefault();
    },
};

Barcode.init();