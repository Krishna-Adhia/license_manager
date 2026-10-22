<?php
/* Smarty version 3.1.48, created on 2026-10-22 09:46:49
  from 'mailMessage:subject' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_6ad9bf6961b600_51814595',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3658c8804036d8e01de31155025e7476dc5a36b3' => 
    array (
      0 => 'mailMessage:subject',
      1 => 1792655209,
      2 => 'mailMessage',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6ad9bf6961b600_51814595 (Smarty_Internal_Template $_smarty_tpl) {
?>[Ticket ID: <?php echo $_smarty_tpl->tpl_vars['ticket_id']->value;?>
] <?php echo $_smarty_tpl->tpl_vars['ticket_subject']->value;
}
}
