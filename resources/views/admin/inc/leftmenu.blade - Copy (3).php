<aside class="main-sidebar">
    <section class="sidebar">
          <!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
<li class="header" style="text-align: center;color: #F79F1F;letter-spacing: 1px;font-weight: bold;">
  MENU LIST
</li>
  {{--Auth::user()->id--}}
<?php
$permission_level = DB::table('users')->where('id', Auth::user()->id)->first();

$permission_id =explode(",",$permission_level->menu_permitted);
//var_dump($permission_id);
foreach ($permission_id as $id){
  $permission_child = DB::table('menus')->where('id', $id)->first();
//  var_dump($permission_child);

  $permission_sub = DB::table('menus')->where('id', $permission_child->parent_id)->first();

  if ($permission_sub->id > 3){

    $re = DB::table('menus')->where('id', $permission_sub->parent_id)->first();
    echo '<li class="treeview">
    <a href="#"><i class="fa fa-file"></i> <span>'.$re->menu.'</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      <!-- loog start  -->
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> '.$permission_sub->menu.'
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href=""><i class="fa fa-circle-o icon_tree_color"></i>'.$permission_child->menu.'</a></li>
        </ul>
      </li>
    </ul>
  </li>';
  }else{

  }


//
//  $permission_parent = DB::table('menus')->distinct()->select('*')->where('id', '=', $permission_sub->parent_id)->first();
////echo $permission_parent->parent_id.' '.$permission_parent->menu;
//  if ($permission_parent->parent_id != 0){
////    $parent_name = DB::table('menus')->distinct('menu');
//    $parent_name = DB::table('menus')->distinct()->select('menu')->where('id', '=', $permission_parent->parent_id)->first();
////    echo "<li class='treeview'>
////    <a href='#'><i class='fa fa-file'></i> <span>".$parent_name->menu."</span>
////  <span class='pull-right-container'>
////          <i class='fa fa-angle-left pull-right'></i>
////        </span>
////    </a>
////  </li>";
//  }else{
//
//  }
//
}

?>

  <?php
//  for ($i = 0; $i < count($permission_id); $i++){
//    $parent_id = $permission_id[$i];
////      $result = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = '$someVariable'") );
//
//    $sql = DB::select( DB::raw("SELECT a.id, a.menu, a.url_link, a.parent_id, (SELECT count(*) FROM menus b WHERE a.id = b.parent_id) AS no_of_child FROM menus a WHERE id = $parent_id"));
//var_dump($sql);
    //    echo $sql[0]->parent_id;
//    if ($sql[0]->parent_id > 3){
//      echo $sql[0]->parent_id;
//      $permission_sub = DB::table('menus')->where('id', $sql[0]->parent_id)->first();
//      var_dump($permission_sub);
//    }

//  }

  ?>

  <li class="treeview">
    <a href="#"><i class="fa fa-file"></i> <span>Demo</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{URL('/')}}"><i class="fa fa-circle-o icon_tree_color"></i> DASHBOARD</a></li>
      <li><a href="#"><i class="fa fa-circle-o icon_tree_color"></i> CHANGE PASSWORD</a></li>
    </ul>
  </li>



  <!-- FILE MENU -->
  <li class="treeview">
    <a href="#"><i class="fa fa-file"></i> <span>FILE</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{URL('/')}}"><i class="fa fa-circle-o icon_tree_color"></i> DASHBOARD</a></li>
      <li><a href="#"><i class="fa fa-circle-o icon_tree_color"></i> CHANGE PASSWORD</a></li>
    </ul>
  </li>
  <!-- SETTINGS -->
    <li class="treeview">
    <a href="#">
      <i class="fa fa-cogs"></i> <span>SETTINGS </span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <!-- loop start -->
    <ul class="treeview-menu">
      <!-- loog start  -->
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> CENTER TYPE
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{URL::to('/center-type-add')}}"><i class="fa fa-circle-o icon_tree_color"></i>Add Center Type</a></li>
      <li><a href="{{URL::to('/center-type-list')}}"><i class="fa fa-circle-o icon_tree_color"></i> Center Type List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> CENTER
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
           <li><a href="{{URL::to('/center-add')}}"><i class="fa fa-circle-o icon_tree_color"></i> Add Center</a></li>
      <li><a href="{{URL::to('/center-list')}}"><i class="fa fa-circle-o icon_tree_color"></i> Center List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> MENU
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('/menu/create') }}"><i class="fa fa-circle-o icon_tree_color"></i> Add Menu</a></li>
          <li><a href="{{ url('/menu/index') }}"><i class="fa fa-circle-o icon_tree_color"></i> Menu List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa fa-circle-o icon_tree_color"></i> MANAGE USER
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
         @if(auth()->user()->name=='Admin')
             <li><a href="{{ url('/create') }}"><i class="fa fa-circle-o icon_tree_color"></i> Add User</a></li>
         @endif
          <li><a href="{{URL::to('/user-list')}}"><i class="fa fa-circle-o icon_tree_color"></i> User List</a></li>
        </ul>
      </li>
      <!-- loop end  -->
    </ul>
     <!-- loop end -->
  </li>

  <!-- OPERATOINS -->
  <li class="treeview">
    <a href="#"><i class="fa fa-cubes"></i> <span>OPERATION</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">

      <li><a href="{{ url('/print') }}"><i class="fa fa-circle-o icon_tree_color"></i>  R.A.P. / P.A.P. Approval</a></li>

      <li><a href="{{ url('/edit') }}"><i class="fa fa-circle-o icon_tree_color"></i>  R.A.P. / P.A.P. Approval Edit</a></li>

    </ul>
  </li>

    <!-- Export / Import -->
  <li class="treeview">
    <a href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span>IMPORT FILE</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">

      <li><a href="{{ url('/import/data') }}"><i class="fa fa-circle-o icon_tree_color"></i> Import R.A.P. / P.A.P.</a></li>

    </ul>
  </li>

  <!-- REPORT MENU -->
  <li class="treeview">
    <a href="#"><i class="fa fa-bar-chart"></i> <span>REPORT</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">

      <li><a href="{{ url('/approve/report') }}"><i class="fa fa-circle-o icon_tree_color"></i> R.A.P. / P.A.P. Details</a></li>

      <li><a href="{{ url('/port-update-report') }}"><i class="fa fa-circle-o icon_tree_color"></i> R.A.P. / P.A.P. Summary</a></li>

    </ul>
  </li>
  <li class="treeview">
    <a href="#"><i class="fa fa-bar-chart"></i> <span>Sticker</span>
      <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">

      <li><a href="{{ url('/sticker') }}"><i class="fa fa-circle-o icon_tree_color"></i> Add Sticker</a></li>

      <li><a href="{{ url('/sticker-list') }}"><i class="fa fa-circle-o icon_tree_color"></i> Sticker List</a></li>

    </ul>
  </li>

</ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<!-- Sidebar menu -->