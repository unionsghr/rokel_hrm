ALTER TABLE Documents ADD COLUMN `expire_notification` enum('Yes','No') default 'Yes';
ALTER TABLE Documents ADD COLUMN `expire_notification_month` enum('Yes','No') default 'Yes';
ALTER TABLE Documents ADD COLUMN `expire_notification_week` enum('Yes','No') default 'Yes';
ALTER TABLE Documents ADD COLUMN `expire_notification_day` enum('Yes','No') default 'Yes';
ALTER TABLE Documents ADD COLUMN `created` DATETIME default '0000-00-00 00:00:00';
ALTER TABLE Documents ADD COLUMN `updated` DATETIME default '0000-00-00 00:00:00';


ALTER TABLE EmployeeDocuments ADD COLUMN `expire_notification_last` int(4) NULL;
ALTER TABLE EmployeeDocuments ADD KEY `KEY_EmployeeDocuments_valid_until` (`valid_until`);
ALTER TABLE EmployeeDocuments ADD KEY `KEY_EmployeeDocuments_valid_until_status` (`valid_until`,`status`,`expire_notification_last`);

ALTER TABLE LeaveTypes ADD COLUMN `send_notification_emails` enum('Yes','No') default 'Yes' AFTER `propotionate_on_joined_date`;

ALTER TABLE EmployeeTravelRecords ADD COLUMN `funding` decimal(10,3) NULL AFTER `details`;
ALTER TABLE EmployeeTravelRecords ADD COLUMN `currency` bigint(20) NULL AFTER `funding`;
ALTER TABLE EmployeeTravelRecords ADD COLUMN `status` enum('Approved','Pending','Rejected','Cancellation Requested','Cancelled') default 'Pending';


REPLACE INTO `Reports` (`name`, `details`, `parameters`, `query`, `paramOrder`, `type`) VALUES
  ('Travel Request Report', 'This report list employees travel requests for a specified period',
   '[\r\n[ "employee", {"label":"Employee","type":"select2multi","allow-null":true,"null-label":"All Employees","remote-source":["Employee","id","first_name+last_name"]}],\r\n[ "date_start", {"label":"Start Date","type":"date"}],\r\n[ "date_end", {"label":"End Date","type":"date"}],\r\n[ "status", {"label":"Status","type":"select","source":[["NULL","All Statuses"],["Approved","Approved"],["Pending","Pending"],["Rejected","Rejected"],["Cancellation Requested","Cancellation Requested"],["Cancelled","Cancelled"]]}]\r\n]',
   'TravelRequestReport',
   '["employee","date_start","date_end","status"]', 'Class');

REPLACE INTO `Reports` (`name`, `details`, `parameters`, `query`, `paramOrder`, `type`) VALUES
  ('Employee Leaves Report', 'This report list all employee leaves by employee, date range and leave status', '[\r\n[ "employee", {"label":"Employee","type":"select2multi","allow-null":true,"null-label":"All Employees","remote-source":["Employee","id","first_name+last_name"]}],\r\n[ "date_start", {"label":"Start Date","type":"date"}],\r\n[ "date_end", {"label":"End Date","type":"date"}],\r\n[ "status", {"label":"Leave Status","type":"select","source":[["NULL","All Statuses"],["Approved","Approved"],["Pending","Pending"],["Rejected","Rejected"],["Cancellation Requested","Cancellation Requested"],["Cancelled","Cancelled"]]}]\r\n]', 'EmployeeLeavesReport', '["employee","date_start","date_end","status"]', 'Class');

REPLACE INTO `Reports` (`name`, `details`, `parameters`, `query`, `paramOrder`, `type`) VALUES
  ('Expense Report', 'This report list employees expenses for a specified period',
   '[\r\n[ "employee", {"label":"Employee","type":"select2multi","allow-null":true,"null-label":"All Employees","remote-source":["Employee","id","first_name+last_name"]}],\r\n[ "date_start", {"label":"Start Date","type":"date"}],\r\n[ "date_end", {"label":"End Date","type":"date"}],\r\n[ "status", {"label":"Status","type":"select","source":[["NULL","All Statuses"],["Approved","Approved"],["Pending","Pending"],["Rejected","Rejected"],["Cancellation Requested","Cancellation Requested"],["Cancelled","Cancelled"]]}]\r\n]',
   'ExpenseReport',
   '["employee","date_start","date_end","status"]', 'Class');


create table `ExpensesCategories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `created` timestamp NULL default '0000-00-00 00:00:00',
  `updated` timestamp NULL default '0000-00-00 00:00:00',
  `pre_approve` enum('Yes','No') default 'Yes',
  primary key  (`id`)
) engine=innodb default charset=utf8;

create table `ExpensesPaymentMethods` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `created` timestamp NULL default '0000-00-00 00:00:00',
  `updated` timestamp NULL default '0000-00-00 00:00:00',
  primary key  (`id`)
) engine=innodb default charset=utf8;


create table `EmployeeExpenses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee` bigint(20) NOT NULL,
  `expense_date` date NULL default '0000-00-00',
  `payment_method` bigint(20) NOT NULL,
  `transaction_no` varchar(300) NOT NULL,
  `payee` varchar(500) NOT NULL,
  `category` bigint(20) NOT NULL,
  `notes` text,
  `amount` decimal(10,3) NULL,
  `currency` bigint(20) NULL,
  `attachment1` varchar(100) NULL,
  `attachment2` varchar(100) NULL,
  `attachment3` varchar(100) NULL,
  `created` timestamp NULL default '0000-00-00 00:00:00',
  `updated` timestamp NULL default '0000-00-00 00:00:00',
  `status` enum('Approved','Pending','Rejected','Cancellation Requested','Cancelled') default 'Pending',
  CONSTRAINT `Fk_EmployeeExpenses_Employee` FOREIGN KEY (`employee`) REFERENCES `Employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Fk_EmployeeExpenses_pm` FOREIGN KEY (`payment_method`) REFERENCES `ExpensesPaymentMethods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Fk_EmployeeExpenses_category` FOREIGN KEY (`category`) REFERENCES `ExpensesCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  primary key  (`id`)
) engine=innodb default charset=utf8;


INSERT INTO `ExpensesPaymentMethods` (`name`) VALUES
  ('Cash'),
  ('Check'),
  ('Credit Card'),
  ('Debit Card');


INSERT INTO `ExpensesCategories` (`name`) VALUES
  ('Auto - Gas'),
  ('Auto - Insurance'),
  ('Auto - Maintenance'),
  ('Auto - Payment'),
  ('Transportation'),
  ('Bank Fees'),
  ('Dining Out'),
  ('Entertainment'),
  ('Hotel / Motel'),
  ('Insurance'),
  ('Interest Charges'),
  ('Loan Payment'),
  ('Medical'),
  ('Mileage'),
  ('Rent'),
  ('Rental Car'),
  ('Utility');


INSERT INTO `Settings` (`name`, `value`, `description`, `meta`) VALUES
  ('Notifications: Send Document Expiry Emails', '1', '','["value", {"label":"Value","type":"select","source":[["1","Yes"],["0","No"]]}]'),
  ('Notifications: Copy Document Expiry Emails to Manager', '1', '','["value", {"label":"Value","type":"select","source":[["1","Yes"],["0","No"]]}]');


REPLACE INTO `Settings` (`name`, `value`, `description`, `meta`) VALUES
  ('Expense: Pre-Approve Expenses', '0', '','["value", {"label":"Value","type":"select","source":[["1","Yes"],["0","No"]]}]');

REPLACE INTO `Settings` (`name`, `value`, `description`, `meta`) VALUES
  ('Travel: Pre-Approve Travel Request', '0', '','["value", {"label":"Value","type":"select","source":[["1","Yes"],["0","No"]]}]');

REPLACE INTO `Settings` (`name`, `value`, `description`, `meta`) VALUES
('Attendance: Use Department Time Zone', '0', '','["value", {"label":"Value","type":"select","source":[["1","Yes"],["0","No"]]}]');

UPDATE `Settings` set value = '1' where name = 'System: Reset Modules and Permissions';

ALTER TABLE `CompanyStructures` ADD COLUMN `timezone` varchar(100) not null default 'Europe/London';

create table `Timezones` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) not null default '',
  `details` varchar(255) not null default '',
  primary key  (`id`)
) engine=innodb default charset=utf8;


INSERT INTO `Timezones`(`id`, `name`, `details`) VALUES
  (1, 'Pacific/Midway', '(GMT-11:00) Midway Island'),
  (2, 'US/Samoa', '(GMT-11:00) Samoa'),
  (3, 'US/Hawaii', '(GMT-10:00) Hawaii'),
  (4, 'US/Alaska', '(GMT-09:00) Alaska'),
  (5, 'US/Pacific', '(GMT-08:00) Pacific Time (US &amp; Canada)'),
  (6, 'America/Tijuana', '(GMT-08:00) Tijuana'),
  (7, 'US/Arizona', '(GMT-07:00) Arizona'),
  (8, 'US/Mountain', '(GMT-07:00) Mountain Time (US &amp; Canada)'),
  (9, 'America/Chihuahua', '(GMT-07:00) Chihuahua'),
  (10, 'America/Mazatlan', '(GMT-07:00) Mazatlan'),
  (11, 'America/Mexico_City', '(GMT-06:00) Mexico City'),
  (12, 'America/Monterrey', '(GMT-06:00) Monterrey'),
  (13, 'Canada/Saskatchewan', '(GMT-06:00) Saskatchewan'),
  (14, 'US/Central', '(GMT-06:00) Central Time (US &amp; Canada)'),
  (15, 'US/Eastern', '(GMT-05:00) Eastern Time (US &amp; Canada)'),
  (16, 'US/East-Indiana', '(GMT-05:00) Indiana (East)'),
  (17, 'America/Bogota', '(GMT-05:00) Bogota'),
  (18, 'America/Lima', '(GMT-05:00) Lima'),
  (19, 'America/Caracas', '(GMT-04:30) Caracas'),
  (20, 'Canada/Atlantic', '(GMT-04:00) Atlantic Time (Canada)'),
  (21, 'America/La_Paz', '(GMT-04:00) La Paz'),
  (22, 'America/Santiago', '(GMT-04:00) Santiago'),
  (23, 'Canada/Newfoundland', '(GMT-03:30) Newfoundland'),
  (24, 'America/Buenos_Aires', '(GMT-03:00) Buenos Aires'),
  (25, 'Greenland', '(GMT-03:00) Greenland'),
  (26, 'Atlantic/Stanley', '(GMT-02:00) Stanley'),
  (27, 'Atlantic/Azores', '(GMT-01:00) Azores'),
  (28, 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'),
  (29, 'Africa/Casablanca', '(GMT) Casablanca'),
  (30, 'Europe/Dublin', '(GMT) Dublin'),
  (31, 'Europe/Lisbon', '(GMT) Lisbon'),
  (32, 'Europe/London', '(GMT) London'),
  (33, 'Africa/Monrovia', '(GMT) Monrovia'),
  (34, 'Europe/Amsterdam', '(GMT+01:00) Amsterdam'),
  (35, 'Europe/Belgrade', '(GMT+01:00) Belgrade'),
  (36, 'Europe/Berlin', '(GMT+01:00) Berlin'),
  (37, 'Europe/Bratislava', '(GMT+01:00) Bratislava'),
  (38, 'Europe/Brussels', '(GMT+01:00) Brussels'),
  (39, 'Europe/Budapest', '(GMT+01:00) Budapest'),
  (40, 'Europe/Copenhagen', '(GMT+01:00) Copenhagen'),
  (41, 'Europe/Ljubljana', '(GMT+01:00) Ljubljana'),
  (42, 'Europe/Madrid', '(GMT+01:00) Madrid'),
  (43, 'Europe/Paris', '(GMT+01:00) Paris'),
  (44, 'Europe/Prague', '(GMT+01:00) Prague'),
  (45, 'Europe/Rome', '(GMT+01:00) Rome'),
  (46, 'Europe/Sarajevo', '(GMT+01:00) Sarajevo'),
  (47, 'Europe/Skopje', '(GMT+01:00) Skopje'),
  (48, 'Europe/Stockholm', '(GMT+01:00) Stockholm'),
  (49, 'Europe/Vienna', '(GMT+01:00) Vienna'),
  (50, 'Europe/Warsaw', '(GMT+01:00) Warsaw'),
  (51, 'Europe/Zagreb', '(GMT+01:00) Zagreb'),
  (52, 'Europe/Athens', '(GMT+02:00) Athens'),
  (53, 'Europe/Bucharest', '(GMT+02:00) Bucharest'),
  (54, 'Africa/Cairo', '(GMT+02:00) Cairo'),
  (55, 'Africa/Harare', '(GMT+02:00) Harare'),
  (56, 'Europe/Helsinki', '(GMT+02:00) Helsinki'),
  (57, 'Europe/Istanbul', '(GMT+02:00) Istanbul'),
  (58, 'Asia/Jerusalem', '(GMT+02:00) Jerusalem'),
  (59, 'Europe/Kiev', '(GMT+02:00) Kyiv'),
  (60, 'Europe/Minsk', '(GMT+02:00) Minsk'),
  (61, 'Europe/Riga', '(GMT+02:00) Riga'),
  (62, 'Europe/Sofia', '(GMT+02:00) Sofia'),
  (63, 'Europe/Tallinn', '(GMT+02:00) Tallinn'),
  (64, 'Europe/Vilnius', '(GMT+02:00) Vilnius'),
  (65, 'Asia/Baghdad', '(GMT+03:00) Baghdad'),
  (66, 'Asia/Kuwait', '(GMT+03:00) Kuwait'),
  (67, 'Africa/Nairobi', '(GMT+03:00) Nairobi'),
  (68, 'Asia/Riyadh', '(GMT+03:00) Riyadh'),
  (69, 'Europe/Moscow', '(GMT+03:00) Moscow'),
  (70, 'Asia/Tehran', '(GMT+03:30) Tehran'),
  (71, 'Asia/Baku', '(GMT+04:00) Baku'),
  (72, 'Europe/Volgograd', '(GMT+04:00) Volgograd'),
  (73, 'Asia/Muscat', '(GMT+04:00) Muscat'),
  (74, 'Asia/Tbilisi', '(GMT+04:00) Tbilisi'),
  (75, 'Asia/Yerevan', '(GMT+04:00) Yerevan'),
  (76, 'Asia/Kabul', '(GMT+04:30) Kabul'),
  (77, 'Asia/Karachi', '(GMT+05:00) Karachi'),
  (78, 'Asia/Tashkent', '(GMT+05:00) Tashkent'),
  (79, 'Asia/Kolkata', '(GMT+05:30) Kolkata'),
  (80, 'Asia/Kathmandu', '(GMT+05:45) Kathmandu'),
  (81, 'Asia/Yekaterinburg', '(GMT+06:00) Ekaterinburg'),
  (82, 'Asia/Almaty', '(GMT+06:00) Almaty'),
  (83, 'Asia/Dhaka', '(GMT+06:00) Dhaka'),
  (84, 'Asia/Novosibirsk', '(GMT+07:00) Novosibirsk'),
  (85, 'Asia/Bangkok', '(GMT+07:00) Bangkok'),
  (86, 'Asia/Jakarta', '(GMT+07:00) Jakarta'),
  (87, 'Asia/Krasnoyarsk', '(GMT+08:00) Krasnoyarsk'),
  (88, 'Asia/Chongqing', '(GMT+08:00) Chongqing'),
  (89, 'Asia/Hong_Kong', '(GMT+08:00) Hong Kong'),
  (90, 'Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur'),
  (91, 'Australia/Perth', '(GMT+08:00) Perth'),
  (92, 'Asia/Singapore', '(GMT+08:00) Singapore'),
  (93, 'Asia/Taipei', '(GMT+08:00) Taipei'),
  (94, 'Asia/Ulaanbaatar', '(GMT+08:00) Ulaan Bataar'),
  (95, 'Asia/Urumqi', '(GMT+08:00) Urumqi'),
  (96, 'Asia/Irkutsk', '(GMT+09:00) Irkutsk'),
  (97, 'Asia/Seoul', '(GMT+09:00) Seoul'),
  (98, 'Asia/Tokyo', '(GMT+09:00) Tokyo'),
  (99, 'Australia/Adelaide', '(GMT+09:30) Adelaide'),
  (100, 'Australia/Darwin', '(GMT+09:30) Darwin'),
  (101, 'Asia/Yakutsk', '(GMT+10:00) Yakutsk'),
  (102, 'Australia/Brisbane', '(GMT+10:00) Brisbane'),
  (103, 'Australia/Canberra', '(GMT+10:00) Canberra'),
  (104, 'Pacific/Guam', '(GMT+10:00) Guam'),
  (105, 'Australia/Hobart', '(GMT+10:00) Hobart'),
  (106, 'Australia/Melbourne', '(GMT+10:00) Melbourne'),
  (107, 'Pacific/Port_Moresby', '(GMT+10:00) Port Moresby'),
  (108, 'Australia/Sydney', '(GMT+10:00) Sydney'),
  (109, 'Asia/Vladivostok', '(GMT+11:00) Vladivostok'),
  (110, 'Asia/Magadan', '(GMT+12:00) Magadan'),
  (111, 'Pacific/Auckland', '(GMT+12:00) Auckland'),
  (112, 'Pacific/Fiji', '(GMT+12:00) Fiji');



