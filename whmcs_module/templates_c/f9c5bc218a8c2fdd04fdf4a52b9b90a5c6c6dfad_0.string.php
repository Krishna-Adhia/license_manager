<?php
/* Smarty version 3.1.48, created on 2026-09-01 08:30:22
  from 'f9c5bc218a8c2fdd04fdf4a52b9b90a5c6c6dfad' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6a9670fe1f1867_06305289',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a9670fe1f1867_06305289 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wizard-transition-step">
    <div class="icon"><i class="far fa-lightbulb"></i></div>
    <div class="title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"wizard.welcome"),$_smarty_tpl ) );?>
</div>
    <div class="tag"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"wizard.intro"),$_smarty_tpl ) );?>
</div>
    <div class="greyout"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lang'][0], array( array('key'=>"wizard.noTime"),$_smarty_tpl ) );?>
</div>
</div><?php }
}
