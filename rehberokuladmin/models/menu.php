<?php
class Menu extends DBOperation {
    public function __construct() {
        parent::__construct();
    }
    
   
    public function getMenuItems() {
        $this->findAll('menu');
        
        $menuItems = $this->resultSet();
        return $menuItems;
    }
    
    public function menuItemHasChildren($id) {
        $this->findByColumn('menu', 'parent_id', $id);
        $children = $this->resultSet();
        if($children) {
            return true;
        } else {
            return false;
        }
    }
    
    public function print_menu($array, $parent=0) {
        $rowId = '';
        foreach ($array as $row) {
            $rowId = $row['id'];
            $hasChildren = $this->menuItemHasChildren($rowId);
            if($row['parent_id'] == $parent && $parent == 0) {
                $this->print_parent($array, $row, $rowId, $hasChildren);
            }
        }
       
    }
    
    public function hasReadingAuth($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        $auths = $this->single();
        return $auths['reading'];
    }
    
    public function hasCheckAuth($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        $auths = $this->single();
        return $auths['check_news'];
    }
    
    public function print_parent($array, $row, $parent, $hasChildren) {
        $this->count('all_user_notifications');
        $this->where('user_id', $_SESSION['user_data']['user_id']);
        $this->addAndClause('as_read', 0);
        $this->addAndClause('is_active', 1);
        $count = $this->single();
        $count = $count['total'];
        $str = $count == 0 ? '' : ' ( '.$count.' )';
        if($this->hasReadingAuth($_SESSION['user_data']['role'], $row['id'])){
            $active = $row['id'] == Controller::$active_id ? 'nav-active' : '';
            $expanded = $active ? 'nav-expanded' : '';
            if($hasChildren) {
                echo '<li class="nav-parent '.$active.' '.$expanded.'" >';
                echo '<a>
                            <i class="'.$row['icon'].'" aria-hidden="true"></i>
                            <span>'.$row['menu_name'].'</span>
                        </a>';
                //echo '</li>';
                $this->print_children($array, $parent);
            }
            else {
                echo '<li class="'.$active.'">';
                echo $row['link'] == 'notifications/parent' ? '<a href="'.$row['link'].'">
                            <i class="'.$row['icon'].'" aria-hidden="true"></i>
                            <span>'.$row['menu_name'].$str.'</span>
                        </a>' : ($row['link'] == 'notifications/owner' ? '<a href="'.$row['link'].'">
                            <i class="'.$row['icon'].'" aria-hidden="true"></i>
                            <span>'.$row['menu_name'].$str.'</span>
                        </a>' : '<a href="'.$row['link'].'">
                            <i class="'.$row['icon'].'" aria-hidden="true"></i>
                            <span>'.$row['menu_name'].'</span>
                        </a>');
                echo '</li>';
            }
            $this->print_menu($array, $parent);  # recurse   
        }
    }
    public function print_children($array, $parent) {
            echo '<ul class="nav nav-children">';
            foreach($array as $rowChildren) {

                $hasChildren = $this->menuItemHasChildren($rowChildren['id']);
                if($rowChildren['parent_id'] == $parent && $hasChildren) {
                    echo '<li class="nav-parent">';
                    echo '<a>'.$rowChildren['menu_name'].'</a>';
                    $this->print_children($array, $rowChildren['id']);
                    echo '</li>';
                } else if ($rowChildren['parent_id'] == $parent && !$hasChildren){
                        $active = $rowChildren['id'] == Controller::$child_active_id ? 'nav-active' : '';
                        echo '<li  class="'.$active.'">';
                        echo '<a href="'.$rowChildren['link'].'">'.$rowChildren['menu_name'].'</a>';
                        echo '</li>';
                }
            }
            echo '</ul>';
            echo '</li>';
    }
}
