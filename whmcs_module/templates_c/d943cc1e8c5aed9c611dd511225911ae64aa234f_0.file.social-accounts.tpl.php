<?php
/* Smarty version 3.1.48, created on 2026-09-01 10:00:26
  from '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/social-accounts.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6a96861a6538f4_94765980',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd943cc1e8c5aed9c611dd511225911ae64aa234f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/license_manager/whmcs_module/templates/twenty-one/includes/social-accounts.tpl',
      1 => 1713935288,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a96861a6538f4_94765980 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['socialAccounts']->value, 'account');
$_smarty_tpl->tpl_vars['account']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['account']->value) {
$_smarty_tpl->tpl_vars['account']->do_else = false;
?>
    <li class="list-inline-item">
        <a class="btn btn-icon mb-1" href="<?php echo $_smarty_tpl->tpl_vars['account']->value->getUrl();?>
" target="_blank">
            <i class="<?php echo $_smarty_tpl->tpl_vars['account']->value->getFontAwesomeIcon();?>
"></i>
        </a>
    </li>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
