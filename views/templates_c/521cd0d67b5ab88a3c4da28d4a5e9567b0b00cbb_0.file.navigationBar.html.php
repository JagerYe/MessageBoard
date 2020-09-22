<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-22 04:15:04
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/navigationBar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f695e289b1ca0_35439909',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '521cd0d67b5ab88a3c4da28d4a5e9567b0b00cbb' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/navigationBar.html',
      1 => 1600740903,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f695e289b1ca0_35439909 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/MessageBoard/index">留言板</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_smarty_tpl->tpl_vars['isLogin']->value === true) {?>
                <li id="showUserName"><a
                        href=<?php echo (isset($_smarty_tpl->tpl_vars['isUpdate']->value)) && $_smarty_tpl->tpl_vars['isUpdate']->value ? "#" : "/MessageBoard/member/getUpdateView";?>
><?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
</a>
                </li>
                <li><a href="/MessageBoard/member/getLoginView" id="showLogin">登出</a></li>
                <?php } else { ?>
                <li><a href="/MessageBoard/member/getLoginView" id="showLogin">登入</a></li>
                <li id="showRegistered"><a href="/MessageBoard/member/getCreateView">註冊</a></li>
                <?php }?>
            </ul>
        </div>
    </div>

</nav><?php }
}
