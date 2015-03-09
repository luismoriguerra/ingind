<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">                        
                        <div class="pull-left image" data-toggle="modal" data-target="#imagenModal">
                            <img src="img/user/<?= md5('u'.Auth::user()->id).'/'.Auth::user()->imagen; ?>" class="img-circle" alt="User Image" />
                        </div>
                        
                        <div class="pull-left info">
                            <p>Hello, {{ Auth::user()->nombre }}</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('greetings.inicio_sesion') }}</a>
                        </div>
                    </div>
                    <?php /*
                    <div class="btn-group user-panel">
                      <a class="btn btn-default">
                        <i class="fa fa-flag-checkered fa-fw"></i> {{ Session::get('language') }}
                      </a>
                      <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="fa fa-caret-down"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="language/idioma?language_id=es&language=Español"><i class="fa <?php echo ( Session::get('language_id')=='es' ) ? 'fa-flag-checkered': 'fa-flag-o'; ?> fa-fw"></i> Español</a></li>
                        <li><a href="language/idioma?language_id=en&language=English"><i class="fa <?php echo ( Session::get('language_id')=='en' ) ? 'fa-flag-checkered': 'fa-flag-o'; ?> fa-fw"></i> English</a></li>
                      </ul>
                    </div> 

                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    */
                    ?>
                    @include( 'layouts.admin_menu' )
                    
                </section>
                <!-- /.sidebar -->
            </aside>

            @include( 'layouts.form.imagen' )
