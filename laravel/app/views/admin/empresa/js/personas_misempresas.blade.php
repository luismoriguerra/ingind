<script type="text/javascript">
var E_SERVER_ERROR = 'Error communicating with the server';
Vue.config.debug = true;
// fields definition
var tableColumns = [
    /*{
        name: 'id',
        title: '',
        dataClass: 'text-center',
        callback: 'showDetailRow'
    },*/
    {
        title: 'DNI',
        name: 'dni',
        sortField: 'dni',
    },
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
        title: 'VIGENCIA',
        name: 'fecha_vigencia',
        sortField: 'fecha_vigencia',
        callback: 'formatDate|DD-MM-YYYY',
    },
    {
        title: 'CESE',
        name: 'fecha_cese',
        sortField: 'fecha_cese',
        callback: 'formatDate|DD-MM-YYYY',
    },
    {
        title: 'CARGO',
        name: 'cargo',
        sortField: 'cargo',
    },
    {
        title: 'ESTADO',
        name: 'estado',
        sortField: 'estado',
        callback: 'estado',
    },
    {
        title: 'TIPO REPRESENTANTE',
        name: 'representante_legal',
        sortField: 'representante_legal',
        callback: 'tipoRepresentante',
    },
];
Vue.component('my-detail-row', {
    template: [
        '<div class="detail-row ui form" @click="onClick($event)">',
            '<div class="inline field">',
                '<label>Name: </label>',
                '<span>@{{rowData.name}}</span>',
            '</div>',
            '<div class="inline field">',
                '<label>Email: </label>',
                '<span>@{{rowData.email}}</span>',
            '</div>',
            '<div class="inline field">',
                '<label>Nickname: </label>',
                '<span>@{{rowData.nickname}}</span>',
            '</div>',
            '<div class="inline field">',
                '<label>Birthdate: </label>',
                '<span>@{{rowData.birthdate}}</span>',
            '</div>',
            '<div class="inline field">',
                '<label>Gender: </label>',
                '<span>@{{rowData.gender}}</span>',
            '</div>',
        '</div>',
    ].join(''),
    props: {
        rowData: {
            type: Object,
            required: true
        }
    },
    methods: {
        onClick: function(event) {
            //console.log('my-detail-row: on-click');
        }
    },
});
var personas=new Vue({
    http: {
      root: '/empresapersona',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },
    el: '#personas',
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
            field: 'paterno',
            direction: 'asc'
        },
        {
            field: 'materno',
            direction: 'asc'
        },
        {
            field: 'nombre',
            direction: 'asc'
        }],
        multiSort: true,
        perPage: 5,
        paginationComponent: 'vuetable-pagination',
        paginationInfoTemplate: 'Mostrando {from} hasta {to} de {total} items',
                
        itemActions: [
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} }
        ],
        moreParams: [
            'empresa_id=0',
        ],
        //
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
        empresaSelec:{
            id:false,
            nombre_comercial:'',
        }
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
        estado: function(value) {
            switch(value) {
                case 1:
                    return 'Activo';
                case 0:
                    return 'Inactivo';
                    return '';
            }
        },
        tipoRepresentante: function(value) {
            switch(value) {
                case 0:
                    return 'Trabajador';
                case 1:
                    return 'Representante';
                default:
                    return '';
            }
        },
        formatDate: function(value, fmt) {
            if (value == null) return '';
            fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt;
            return moment(value, 'YYYY-MM-DD').format(fmt);
        },
        showDetailRow: function(value) {
            var icon = this.$refs.vuetable.isVisibleDetailRow(value) ? 'glyphicon glyphicon-minus-sign' : 'glyphicon glyphicon-plus-sign';
            return [
                '<a class="show-detail-row">',
                    '<i class="' + icon + '"></i>',
                '</a>'
            ].join('');
        },
        /**
         * Other functions
         */
        setFilter: function() {
            this.moreParams = [
                'empresa_id='+app.empresaSelec,
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
        'vuetable:loading': function() {
            var moreParams='empresa_id='+app.empresaSelec;
            this.$set('moreParams', [moreParams]);
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