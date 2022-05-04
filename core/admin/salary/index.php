<?php
 
$moduleName = 'salary';
$moduleGroup = 'admin';
define('MODULE_PATH',dirname(__FILE__));
include APP_BASE_PATH.'header.php';
include APP_BASE_PATH.'modulejslibs.inc.php';

$moduleBuilder = new \Classes\ModuleBuilder\ModuleBuilder();

$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'SalaryComponentType','SalaryComponentType','Salary Component Types','SalaryComponentTypeAdapter','','',true
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'SalaryComponent','SalaryComponent','Salary Components','SalaryComponentAdapter','',''
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'EmployeeSalary','EmployeeSalary','Employee Salary Components','EmployeeSalaryAdapter','','',false,array("setRemoteTable"=>"true"))
);
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'Notches','Notches','Notch Setup','NotchesAdapter','',''
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'PaymentType','PaymentType','Payment Type','PaymentTypeAdapter','',''
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'Salaries','Salaries','Salary Increment/Decrement','SalariesAdapter','',''
)); 
// $moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
// 	'Benefits','Benefits','End of Service Benefits','BenefitsAdapter','',''
// ));


echo \Classes\UIManager::getInstance()->renderModule($moduleBuilder);

include APP_BASE_PATH.'footer.php';
