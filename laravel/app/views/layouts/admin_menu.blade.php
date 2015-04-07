<!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="admin.inicio">
                                <i class="fa fa-dashboard"></i> <span>{{ trans('greetings.menu_inicio') }}</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>{{ trans('greetings.menu_mantenimientos') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li><a href="admin.mantenimiento.area"><i class="fa fa-angle-double-right"></i> Areas</a></li>
                                <li><a href="admin.mantenimiento.cargo"><i class="fa fa-angle-double-right"></i> Cargos</a></li>
                                <li><a href="admin.mantenimiento.flujo"><i class="fa fa-angle-double-right"></i> Flujos</a></li>
                                <li><a href="admin.mantenimiento.flujotiporespuesta"><i class="fa fa-angle-double-right"></i> Flujos Respuestas</a></li>
                                <li><a href="admin.mantenimiento.menu"><i class="fa fa-angle-double-right"></i> Menus</a></li>
                                <li><a href="admin.mantenimiento.opcion"><i class="fa fa-angle-double-right"></i> Opciones</a></li>
                                <li><a href="admin.mantenimiento.persona"><i class="fa fa-angle-double-right"></i> Personas</a></li>
                                <li><a href="admin.mantenimiento.tiporespuesta"><i class="fa fa-angle-double-right"></i> Respuestas</a></li>
                                <li><a href="admin.mantenimiento.tiporespuestadetalle"><i class="fa fa-angle-double-right"></i> Respuestas (detalle)</a></li>
                                <li><a href="admin.mantenimiento.software"><i class="fa fa-angle-double-right"></i> Softwares</a></li>
                                <li><a href="admin.mantenimiento.tiempo"><i class="fa fa-angle-double-right"></i> Tiempos</a></li>

                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Ruta</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.ruta.crear"><i class="fa fa-angle-double-right"></i> Crear</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Asignar</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shield"></i> <span>{{ trans('greetings.menu_info') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.mantenimiento.misdatos"><i class="fa fa-angle-double-right"></i>{{ trans('greetings.menu_info_actualizar') }}</a></li>
                            </ul>
                        </li>
                    </ul>
