<script type="text/javascript">
var E_SERVER_ERROR = 'Error communicating with the server';
Vue.config.debug = true;
// fields definition
var tableColumns = [
    {
        title: 'RUC',
        name: 'ruc',
        sortField: 'ruc',
    },
    {
        title: 'RAZON SOCIAL',
        name: 'razon_social',
        sortField: 'razon_social',
    },
    {
        title: 'NOMBRE COMERCIAL',
        name: 'nombre_comercial',
        sortField: 'nombre_comercial'
    },
    {
        title: 'TELEFONO',
        name: 'telefono',
        sortField: 'telefono'
    },
    {
        title: 'DIRECCION FISCAL',
        name: 'direccion_fiscal',
        sortField: 'direccion_fiscal',
        titleClass: 'text-center',
        dataClass: 'text-center',
    },
    {
        title: 'VIGENCIA',
        name: 'fecha_vigencia',
        sortField: 'fecha_vigencia',
        callback: 'formatDate|DD-MM-YYYY'
    },
    {
        name: '__actions',
        dataClass: 'text-center',
    }
];

var app=new Vue({
    http: {
      root: '/empresa',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },
    el: '#misempresas',
    components: {
        'v-select': VueStrap.select,
        'v-option': VueStrap.option,
        'checkbox-group': VueStrap.checkboxGroup,
        'checkbox': VueStrap.checkboxBtn,
        'datepicker': VueStrap.datepicker,
        'alert': VueStrap.alert,
        'modal': VueStrap.modal,
        'aside': VueStrap.aside,
        'panel': VueStrap.panel,
        'spinner': VueStrap.spinner,
    },
    data: {
        searchFor: '',
        fields: tableColumns,
        sortOrder: [{
            field: 'razon_social',
            direction: 'asc'
        }],
        multiSort: true,
        perPage: 10,
        paginationComponent: 'vuetable-pagination',
        paginationInfoTemplate: 'Mostrando {from} hasta {to} de {total} items',
                
        itemActions: [
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} }
        ],
        moreParams: [
            'usuario_actual=true'
        ],
        //
        loaded: false,
        newEmpresa: {
            id: '',
            tipo_id:'',
            ruc:'',
            razon_social:'',
            nombre_comercial:'',
            direccion_fiscal:'',
            persona_id:'{{Auth::id()}}',
            cargo:'',
            telefono:'',
            fecha_vigencia:'',
            estado:1,
        },
        showModal: false,
        edit: false,
        tituloModal:'',
        success: false,
        danger: false,
        msj: '',
        errores:[],
        mensaje_ok:false,
        mensaje_error:false,
    },
    watch: {
        'perPage': function(val, oldVal) {
            this.$broadcast('vuetable:refresh');
        },
        'paginationComponent': function(val, oldVal) {
            this.$broadcast('vuetable:load-success', this.$refs.vuetable.tablePagination);
            this.paginationConfig(this.paginationComponent);
        }
    },
    methods: {
        /**
         * Callback functions
         */
        formatDate: function(value, fmt) {
            if (value == null) return '';
            fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt;
            return moment(value, 'YYYY-MM-DD').format(fmt);
        },
        /**
         * Other functions
         */
        setFilter: function() {
            this.moreParams = [
                'usuario_actual=true',
                'filter=' + this.searchFor
            ];
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh');
            });
        },
        resetFilter: function() {
            this.searchFor = '';
            this.setFilter();
        },
        preg_quote: function( str ) {
            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight: function(needle, haystack) {
            return haystack.replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<span class="highlight">$1</span>'
            );
        },
        rowClassCB: function(data, index) {
            return (index % 2) === 0 ? 'positive' : '';
        },
        paginationConfig: function(componentName) {
            //console.log('paginationConfig: ', componentName);
            if (componentName == 'vuetable-pagination') {
                this.$broadcast('vuetable-pagination:set-options', {
                    wrapperClass: 'pagination',
                    icons: { first: '', prev: '', next: '', last: ''},
                    activeClass: 'active',
                    linkClass: 'btn btn-default',
                    pageClass: 'btn btn-default'
                });
            }
            if (componentName == 'vuetable-pagination-dropdown') {
                this.$broadcast('vuetable-pagination:set-options', {
                    wrapperClass: 'form-inline',
                    icons: { prev: 'glyphicon glyphicon-chevron-left', next: 'glyphicon glyphicon-chevron-right' },
                    dropdownClass: 'form-control'
                });
            }
        },
        //
        Edit: function (id) { // enviar a laravel para guardar edicion
            this.load(1);
            this.$http.patch( ''+id, this.newEmpresa, function (data) {
                if (data.rst==2) {
                    this.ShowMensaje(data.msj, 5, false, true);
                } else {
                    this.showModal=false;
                    app.$broadcast('vuetable:refresh');
                    msj=' empresa modificada correctamente.';
                    this.newEmpresa = {
                        id: '',
                        tipo_id:'',
                        ruc:'',
                        razon_social:'',
                        nombre_comercial:'',
                        direccion_fiscal:'',
                        persona_id:'{{Auth::id()}}',
                        cargo:'',
                        telefono:'',
                        fecha_vigencia:'',
                        estado:1,
                    };
                    this.ShowMensaje(msj, 5, true, false);
                    this.edit = false;
                }
            }).error(function(errors) {
                this.ShowMensaje(errors, 5, false, true);
            });
            
        },
        accionModal:function(){
            if (this.edit)
                this.Edit(this.newEmpresa.id);
            else
                this.AddNew();
        },
        New: function () {// cargar modal para añadir empresa
            this.showModal=true;
            this.ShowMensaje('',0,false,false);
            this.edit = false;
            this.tituloModal = 'Nueva Empresa';
            this.newEmpresa = {
                    id: '',
                    tipo_id:'',
                    ruc:'',
                    razon_social:'',
                    nombre_comercial:'',
                    direccion_fiscal:'',
                    persona_id:'{{Auth::id()}}',
                    cargo:'',
                    telefono:'',
                    fecha_vigencia:'',
                    estado:1,
                };
        },
        AddNew: function () { //añadir un empresa
            this.load(1);
            this.$http.post('/empresa', this.newEmpresa,  function (data) {
                if (data.rst==2) {
                    this.ShowMensaje(data.msj, 5, false, true);
                } else {
                    this.newEmpresa = {
                        id: '',
                        tipo_id:'',
                        ruc:'',
                        razon_social:'',
                        nombre_comercial:'',
                        direccion_fiscal:'',
                        persona_id:'{{Auth::id()}}',
                        cargo:'',
                        telefono:'',
                        fecha_vigencia:'',
                        estado:1,
                    };
                    this.showModal=false;
                    app.$broadcast('vuetable:refresh');
                    msj=' empresa nueva creado correctamente.';
                    this.ShowMensaje(msj, 5, true, false);
                }

            }).error(function(errors) {
                this.ShowMensaje(errors, 5, false, true);
            });
            self = this;
        },
        Show: function (id) { //mostrar modal para editar
            this.ShowMensaje('',0,false,false);
            this.showModal=true;
            this.edit = true;
            this.tituloModal = 'Editar Empresa';
            this.$http.get( ''+id, function (data) {
                this.newEmpresa = data;
            });
        },
        fetch: function () { //consultar todos las empresa
            this.$http.get('', function (data) {
                this.$set('empresas', data);
            });
        },
        Remove: function (id) { //remover 
            var ConfirmBox = confirm("Estas seguro, que deseas borrar esta empresa?");
            if(ConfirmBox) {
                this.$http.delete( ''+id, function (data) {
                    app.$broadcast('vuetable:refresh');
                    msj=' empresa eliminada correctamente.';
                    this.ShowMensaje(msj, 5, true, false);
                }).error(function(errors) {
                    this.ShowMensaje(errors, 5, false, true);
                });
            }
        },
        validarRuc: function(ruc) {

            if (ruc=='' || ruc == undefined || ruc == null)
                return;
            this.ShowMensaje('',0,false,true);
            this.$http.get('/empresapersona/porruc/'+ ruc,  function (data) {
                if (data.estado==1) {
                    var msj = new Object();
                    msj.ruc=["ruc ya ha sido registrado."];
                    
                    this.ShowMensaje(msj,5,false,true);
                    this.newEmpresa.ruc='';
                } else {

                    this.newEmpresa.ruc=ruc;
                }
            });
        },
        ShowMensaje: function(msj, time, success, danger) {
            if (success)
                this.msj=msj;
            if (danger)
                this.errores=msj;
            self = this;
            this.danger = danger;
            this.success = success;
            setTimeout(function () {
                self.danger = false;
                self.success = false;
            }, time*1000);
        },
        load: function(segundos) {
            this.loaded=true;
            this.handle = setInterval( ( ) => {
                this.loaded=false;
                clearInterval(this.handle);
            },segundos*1000);
        }
    },
    ready: function () {
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            if ($(this).attr('href') == "#afiliadas") 
                afiliadas.$broadcast('vuetable:refresh');
            
        });
        $('#fecha_vigencia').daterangepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            singleDatePicker: true,
            //timePicker: true,
            showDropdowns: true
        });
        $('#empresas tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('active') ) {
                //$(this).removeClass('active');
            } else {
                $('#empresas tbody tr.active').removeClass('active');
                $(this).addClass('active');
            }
        });
    },
    computed: {
        validation: function () {
            return {
                tipo_id: !!$.isNumeric(this.newEmpresa.tipo_id),
                ruc: !!$.isNumeric(this.newEmpresa.ruc),
                razon_social: !!this.newEmpresa.razon_social.trim(),
                nombre_comercial: !!this.newEmpresa.nombre_comercial.trim(),
                direccion_fiscal: !!this.newEmpresa.direccion_fiscal.trim(),
                cargo: !!this.newEmpresa.cargo.trim(),
                telefono: !!this.newEmpresa.telefono.trim(),
                fecha_vigencia: !!this.newEmpresa.fecha_vigencia.trim(),
            };
        },
        isValid: function () {
            var validation = this.validation;
            return Object.keys(validation).every(function (key) {
                return validation[key];
            });
        }
    },
    events: {
        'vuetable:row-changed': function(data) {
            //console.log('row-changed:', data.name);
        },
        'vuetable:row-clicked': function(data, event) {
            var moreParams = 'empresa_id='+data.id;
            app.empresaSelec = data.id;
            personas.empresaSelec.id = data.id;
            personas.empresaSelec.nombre_comercial = data.nombre_comercial;
            personas.$set('moreParams', [moreParams] );
            this.$nextTick(function() {
                personas.$broadcast('vuetable:refresh');
            });
        },
        'vuetable:cell-clicked': function(data, field, event) {
            //console.log('cell-clicked:', field.name);
            if (field.name !== '__actions') {
                this.$broadcast('vuetable:toggle-detail', data.id);
            }
        },
        /* esto depende si no tiene componente el datatable*/
        'vuetable:action': function(action, data) {
            this.Show(data.id);
        },
        'vuetable:load-success': function(response) {
            this.empresas = response.data.data;
        },
        'vuetable:load-error': function(response) {
            if (response.status == 400) {
                sweetAlert('Something\'s Wrong!', response.data.message, 'error');
            } else {
                sweetAlert('Oops', E_SERVER_ERROR, 'error');
            }
        }
    }
});

</script>