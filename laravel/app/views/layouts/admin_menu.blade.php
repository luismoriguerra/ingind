<!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @if (isset($menus))
                            @foreach ( $menus as $key => $val)
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa {{ $val[0]->icon }}"></i> <span>{{ $key }}</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        @foreach ( $val as $k)
                                            <li><a href="admin.{{ $k->ruta }}"><i class="fa fa-angle-double-right"></i>{{ $k->opcion }} </a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        @endif
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shield"></i> <span>{{ trans('greetings.menu_info') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.mantenimiento.misdatos"><i class="fa fa-angle-double-right"></i>{{ trans('greetings.menu_info_actualizar') }} </a></li>
                            </ul>
                        </li>
                    </ul>
