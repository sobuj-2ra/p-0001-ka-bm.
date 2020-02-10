<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" style="text-align: center;color: #F79F1F;letter-spacing: 1px;font-weight: bold;">
                MENU LIST
            </li>
        <?php
        $permission_level = DB::table('users')->where('id', Auth::user()->id)->first();
        //var_dump($permission_level->menu_permitted);
        $permission_id = explode(",", $permission_level->menu_permitted);
        $menus = DB::table('menus')->where('parent_id', '=', 0)->get();
        $j = 0;
        foreach ($menus as $menu) {
            $menus[$j]->sub_menu = DB::table('menus')
                ->whereIn('id', $permission_id)
                ->where('parent_id', $menu->id)
                ->where('sub_id', 0)
                ->orderBy('id', 'asc')
                ->get();
            $j++;
        }

        foreach ($menus as $menu_data) {
            $i = 0;
            foreach ($menu_data->sub_menu as $item) {
//                    var_dump($item->parent_id);
                $menu_data->sub_menu[$i]->child_menu = DB::table('menus')
//                        ->where('parent_id', $item->parent_id)
                    ->where('sub_id', $item->id)
                    ->whereIn('id', $permission_id)
                    ->orderBy('id', 'asc')
                    ->get();
                $i++;
                //var_dump($child_menu);
            }
        }
        ?>

        <!-- FILE MENU -->
            <li class="treeview">
                <a href="#"><i class="fa fa-user"></i> <span>USER</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL('/change-password')}}"><i class="fa fa-circle-o icon_tree_color"></i> CHANGE PASSWORD</a></li>
                </ul>
            </li>

            <?php
            foreach($menus as $menu){
            if ($menu->menu == 'Settings') {
                $icon = '<i class="fa fa-cogs"></i>';
            } elseif ($menu->menu == 'Operation') {
                $icon = '<i class="fa fa-cubes"></i>';
            } elseif ($menu->menu == 'Report') {
                $icon = '<i class="fa fa-bar-chart"></i>';
            }
            if (count($menu->sub_menu) > 0){ ?>
            <li class="treeview">
                <a href="#">
                    <?php echo $icon; ?><span><?php echo strtoupper($menu->menu); ?> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php foreach ($menu->sub_menu as $sub){
                    if ($sub->url_link == '#'){ ?>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <?php echo strtoupper($sub->menu); ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($sub->child_menu as $child_menu) { ?>
                            <li><a href="{{URL::to($child_menu->url_link)}}"><i
                                            class="fa fa-circle-o icon_tree_color"></i><?php echo strtoupper($child_menu->menu); ?>
                                </a></li>
                            <?php  } ?>
                        </ul>
                    </li>
                    <?php }else{ ?>
                    <li>
                        <a href="{{URL::to($sub->url_link)}}"><i
                                    class="fa fa-circle-o icon_tree_color"></i> <?php echo strtoupper($sub->menu) ?>
                        </a>
                    </li>
                    <?php   }
                    } ?>

                        {{--<li class="treeview">--}}
                            {{--<a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <span>PRODUCT TYPE</span>--}}
                                {{--<span class="pull-right-container">--}}
                                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                                    {{--</span>--}}
                            {{--</a>--}}
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="{{URL('/producttype/add')}}"><i class="fa fa-circle-o icon_tree_color"></i>Add Product Type</a></li>--}}
                                {{--<li><a href="{{URL('/producttype/view')}}"><i class="fa fa-circle-o icon_tree_color"></i>List Product Type</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="treeview">--}}
                                {{--<a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <span>WEIGHT MACHINE</span>--}}
                                    {{--<span class="pull-right-container">--}}
                                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                                {{--<ul class="treeview-menu">--}}
                                    {{--<li><a href="{{URL('/weightmachine/add')}}"><i class="fa fa-circle-o icon_tree_color"></i>Add Weight Machine</a></li>--}}
                                    {{--<li><a href="{{URL('/weightmachine/view')}}"><i class="fa fa-circle-o icon_tree_color"></i>List Weight Machine</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--<li class="treeview">--}}
                            {{--<a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <span>Bacher History</span>--}}
                                {{--<span class="pull-right-container">--}}
                                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                                {{--</span>--}}
                            {{--</a>--}}
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="{{URL('/batcherhistory/reprint')}}"><i class="fa fa-circle-o icon_tree_color"></i>Bacher History</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="treeview">--}}
                            {{--<a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <span>Packaging Stutas</span>--}}
                                {{--<span class="pull-right-container">--}}
                                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                                {{--</span>--}}
                            {{--</a>--}}
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="{{URL::to('/packaging-status')}}"><i class="fa fa-circle-o icon_tree_color"></i>Packaging Stutas</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}


                        {{--<li class="treeview">--}}
                            {{--<a href="#"><i class="fa fa-circle-o icon_tree_color"></i> <span>REPORTS</span>--}}
                                {{--<span class="pull-right-container">--}}
                                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                                {{--</span>--}}
                            {{--</a>--}}
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="{{URL::to('/productdetails')}}"><i class="fa fa-circle-o icon_tree_color"></i>Product Report</a></li>--}}
                                {{--<li><a href="{{URL::to('/stockin-report')}}"><i class="fa fa-circle-o icon_tree_color"></i>Stock In Report</a></li>--}}
                                {{--<li><a href="{{URL::to('/stockout-report')}}"><i class="fa fa-circle-o icon_tree_color"></i>Stock Out Report</a></li>--}}
                                {{--<li><a href="{{URL::to('/customer-report')}}"><i class="fa fa-circle-o icon_tree_color"></i>Customer Report</a></li>--}}
                                {{--<li><a href="{{URL::to('/batcher-report')}}"><i class="fa fa-circle-o icon_tree_color"></i>Batcher Report</a></li>--}}
                                {{--<li><a href="{{URL::to('/print-slip-report')}}"><i class="fa fa-circle-o icon_tree_color"></i>Slip Print Report</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                </ul>
            </li>
            <?php }
             } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- Sidebar menu -->