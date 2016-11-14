<script type="text/javascript">
var E_SERVER_ERROR = 'Error communicating with the server';
Vue.config.debug = true;
// fields definition
var tableColumnsPersona = [
    /*{
        name: 'id',
        title: '',
        dataClass: 'text-center',
        callback: 'showDetailRow'
    },*/
    {
        title: 'AP PATERNO',
        name: 'paterno',
        sortField: 'paterno',
    },
    {
        title: 'AP MATERNO',
        name: 'materno',
        sortField: 'materno',
    },
    {
        title: 'NOMBRE',
        name: 'nombre',
        sortField: 'nombre'
    },
    {
        title: 'DNI',
        name: 'dni',
        sortField: 'dni',
    },
    {
        name: '__actions',
        dataClass: 'text-center',
    }
];

var modal=new Vue({
    http: {
      root: '/personas',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },
    el: '#personasModal',
    components: {
        'v-select': VueStrap.select,
        'v-option': VueStrap.option,
        'checkbox-group': VueStrap.checkboxGroup,
        'checkbox': VueStrap.checkboxBtn,
        'radio-group': VueStrap.radioGroup,
        'radio': VueStrap.radioBtn,
        'datepicker': VueStrap.datepicker,
        'alert': VueStrap.alert,
        'modal': VueStrap.modal,
        'aside': VueStrap.aside,
        'panel': VueStrap.panel,
        'spinner': VueStrap.spinner,
    },
    data: {
        radioValue:'',
        searchFor: '',
        fields: tableColumnsPersona,
        sortOrder: [
            {
                field: 'paterno',
                direction: 'asc'
            },
        ],
        multiSort: true,
        perPage: 5,
        paginationComponent: 'vuetable-pagination',
        paginationInfoTemplate: 'Mostrando {from} hasta {to} de {total} items',
                
        itemActions: [
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} }
        ],
        moreParams: [
            'estado=1',
        ],
        persona:{
            representante_legal:'',
        },
        loaded: false,
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
    ready: function () {
        $('#cese,#vigencia').daterangepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            singleDatePicker: true,
            showDropdowns: true
        });
    },
    computed: {
        nombresApellidos: function () {
            if (this.persona.nombre) {
                return this.persona.nombre+' ' + this.persona.paterno+' ' +this.persona.materno;
            }
            return '';
        },
        getImagen: function() {
            if (this.persona.imagen) {
                return 'img/user/'+hex_md5('u'+this.persona.id)+'/'+this.persona.imagen;
            }
        },
        getImagenDni: function() {
            if (this.persona.imagen_dni) {
                return 'img/user/'+hex_md5('u'+this.persona.id)+'/'+this.persona.imagen_dni;
            }
        },
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
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
              return;
            this.createImage(files[0],e.target.id);
        },
        createImage(file,id) {
            var image = new Image();
            var reader = new FileReader();
  
            reader.onload = (e) => {
                if (id=='imagen') modal.persona.imagen = e.target.result;
                if (id=='imagen_dni') modal.persona.imagen_dni = e.target.result;
              //vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (id) {
            if (id=='imagen') this.persona.imagen = '';
            if (id=='imagen_dni') this.persona.imagen_dni = '';
        },
        AfiliarPersona: function (){
            this.load(1);
            this.$http.post('/empresapersona/afiliar', this.persona,  function (data) {
                if (data.rst==2) {
                    this.ShowMensaje(data.msj, 5, false, true);
                } else {
                    this.persona = {
                        id: '',
                        tipo_id:'',
                        ruc:'',
                        razon_social:'',
                        nombre_comercial:'',
                        direccion_fiscal:'',
                        cargo:'',
                        telefono:'',
                        fecha_vigencia:'',
                        estado:1,
                    };
                    //this.showModal=false;
                    //app.$broadcast('vuetable:refresh');
                    //msj=' empresa nueva creado correctamente.';
                    //this.ShowMensaje(msj, 5, true, false);
                }

            }).error(function(errors) {
                this.ShowMensaje(errors, 5, false, true);
            });
            //self = this;
        },
        MostrarPersona: function(data){
            if (data.id!=this.persona.id) {
                this.persona=data;
            }
            this.persona.empresa_id=app.empresaSelec;
        },
        setFilter: function() {
            this.moreParams = [
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
        Add: function () {// cargar modal para añadir personal
            this.showModal=true;
            this.ShowMensaje('',0,false,false);
            this.edit = false;
            this.tituloModal = 'Nueva Empresa';
            
        },
        ShowMensaje: function(msj, time, success, danger) {
            this.msj=msj;
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
    events: {
        'vuetable:row-changed': function(data) {
            //console.log('row-changed:', data.name);
        },
        'vuetable:row-clicked': function(data, event) {
            //console.log('row-clicked:', data.name);
        },
        'vuetable:cell-clicked': function(data, field, event) {
            //console.log('cell-clicked:', field.name);
            if (field.name !== '__actions') {
                this.$broadcast('vuetable:toggle-detail', data.id);
            }
        },
        /* esto depende si no tiene componente el datatable*/
        'vuetable:action': function(action, data) {
            this.MostrarPersona(data);
        },
        'vuetable:load-success': function(response) {
            //this.empresas = response.data.data;
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