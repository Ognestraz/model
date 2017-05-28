<?php namespace Model\Traits;

trait Menu
{
    public function menu()
    {
        return $this->hasMany(config('model.menu') ?: 'Model\Menu', 'element_id');
    }
    
    public function inMenu()
    {
        $classMenu = config('model.menu') ?: 'Model\Menu';
        $inMenu = array();
        if ($this->id) {
        
            $menuSite = $classMenu::where('element_id', $this->id)
                    ->where('module', 'site')
                    ->get();

            foreach ($menuSite as $m) {
                $node = $m->rootNode();
                if (!empty($node)) {
                    $inMenu[$node] = true;
                }
            }
        }

        $menu = $classMenu::where('parent', 0)->get();

        $return = array();
        foreach ($menu as $m) {
            $return[] = array('menu' => $m, 'checked' => isset($inMenu[$m->id]));
        }        

        return $return;
    }      
}
