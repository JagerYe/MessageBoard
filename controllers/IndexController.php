<?php
class IndexController extends Controller
{
    public function getIndexView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('index_.html');
    }
}
