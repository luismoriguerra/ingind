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
        title: 'TIPO EMPRESA',
        name: 'tipo_id',
        sortField: 'tipo_id',
        callback: 'tipoEmpresa'
    },
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
        title: 'REPRESENTANTE',
        name: 'representante',
        sortField: 'representante'
    },
    {
        title: 'Mi Cargo',
        name: 'persona_cargo',
        sortField: 'persona_cargo'
    },
    {
        title: 'VIGENCIA',
        name: 'persona_vigencia',
        sortField: 'persona_vigencia',
        callback: 'formatDate|DD-MM-YYYY'
    },
    {
        title: 'CESE',
        name: 'persona_cese',
        sortField: 'persona_cese',
        callback: 'formatDate|DD-MM-YYYY'
    }
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
var afiliadas=new Vue({
    http: {
      root: '/empresapersona',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },
    el: '#afiliadas',
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
        tipoEmpresa: function(value) {
            switch(value) {
                case 1:
                    return 'Natural';
                case 2:
                    return 'Juridico';
                case 3:
                    return 'Organizacion Social';
                case 4:
                    return 'Institucion Publica';
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