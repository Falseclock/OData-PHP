<?php

$CONVERT = [

	'agents'                               => [
		'scheme'     => 'public',
		'EntityName' => 'Agent',
		'mapping'    => [
			'agent_id'       => 'id',
			'agent_name'     => 'name',
			'agent_metadata' => 'metadata',
			'agent_identity' => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
	'billing_backlogs'                     => [
		'scheme'     => 'public',
		'EntityName' => 'BillingBacklogOld',
		'mapping'    => [
			'backlogid'        => 'id',
			'amount'           => 'amount',
			'issuedate'        => 'issuedate',
			'deadlinedate'     => 'deadlinedate',
			'statuslid'        => 'statuslid',
			'compid'           => 'compid',
			'reason'           => 'reason',
			'comments'         => 'comments',
			'canceldate'       => 'canceldate',
			'insertdate'       => 'insertdate',
			'userinsert'       => 'userinsert',
			'backlogtype'      => 'backlogtype',
			'startservicedate' => 'startservicedate',
			'stopservicedate'  => 'stopservicedate',
			'discount'         => 'discount',
			'updatedate'       => 'updatedate',
			'userupdate'       => 'userupdate',
			'ispenalty'        => 'ispenalty',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'billing_invoice'                      => [
		'scheme'     => 'public',
		'EntityName' => 'BillingInvoiceOld',
		'mapping'    => [
			'invoiceid'     => 'id',
			'compid'        => 'compid',
			'statuslid'     => 'statuslid',
			'invoiceamount' => 'invoiceamount',
			'invoicename'   => 'invoicename',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'billing_payments'                     => [
		'scheme'     => 'public',
		'EntityName' => 'BillingPaymentOld',
		'mapping'    => [
			'paymentid'   => 'id',
			'backlogid'   => 'backlogid',
			'amount'      => 'amount',
			'paymentdate' => 'paymentdate',
			'comments'    => 'comments',
			'insertdate'  => 'insertdate',
			'userinsert'  => 'userinsert',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'billing_schemas'                      => [
		'scheme'     => 'handbook',
		'EntityName' => 'BillingSchemeOld',
		'mapping'    => [
			'billing_schema_id'          => 'id',
			'billing_schema_value'       => 'value',
			'billing_schema_description' => 'description',
			'billing_schema_constant'    => 'constant',
			'billing_schema_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'comp_services'                        => [
		'scheme'     => 'public',
		'EntityName' => 'CompServiceOld',
		'mapping'    => [
			'compserviceid'        => 'id',
			'serviceid'            => 'serviceid',
			'compid'               => 'compid',
			'datestart'            => 'datestart',
			'dateend'              => 'dateend',
			'quantity'             => 'quantity',
			'compservicestatuslid' => 'compservicestatuslid',
			'backlogid'            => 'backlogid',
			'dateinsert'           => 'dateinsert',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'comp_tariffs'                         => [
		'scheme'     => 'public',
		'EntityName' => 'CompTariffOld',
		'mapping'    => [
			'comptariffid' => 'id',
			'compid'       => 'compid',
			'tariffid'     => 'tariffid',
			'datestart'    => 'datestart',
			'dateend'      => 'dateend',
			'parameters'   => 'parameters',
			'istrial'      => 'istrial',
			'iscurrent'    => 'iscurrent',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'invoice_states'                       => [
		'scheme'     => 'handbook',
		'EntityName' => 'InvoiceStateOld',
		'mapping'    => [
			'invoice_state_id'          => 'id',
			'invoice_state_value'       => 'value',
			'invoice_state_description' => 'description',
			'invoice_state_constant'    => 'constant',
			'invoice_state_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'billing_types'                        => [
		'scheme'     => 'handbook',
		'EntityName' => 'InvoiceTypeOld',
		'mapping'    => [
			'billing_type_id'          => 'id',
			'billing_type_value'       => 'value',
			'billing_type_description' => 'description',
			'billing_type_constant'    => 'constant',
			'billing_type_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'backlog_states'                       => [
		'scheme'     => 'handbook',
		'EntityName' => 'PaymentStatusOld',
		'mapping'    => [
			'backlog_state_id'          => 'id',
			'backlog_state_value'       => 'value',
			'backlog_state_description' => 'description',
			'backlog_state_constant'    => 'constant',
			'backlog_state_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'services'                             => [
		'scheme'     => 'public',
		'EntityName' => 'ServiceOld',
		'mapping'    => [
			'serviceid'   => 'id',
			'name'        => 'name',
			'price'       => 'price',
			'description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'service_states'                       => [
		'scheme'     => 'handbook',
		'EntityName' => 'ServiceStateOld',
		'mapping'    => [
			'service_state_id'          => 'id',
			'service_state_value'       => 'value',
			'service_state_description' => 'description',
			'service_state_constant'    => 'constant',
			'service_state_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'tariff_comp_requests'                 => [
		'scheme'     => 'public',
		'EntityName' => 'TariffCompRequestOld',
		'mapping'    => [
			'tariffrequestid'            => 'id',
			'tariffpriceid'              => 'tariffpriceid',
			'compid'                     => 'compid',
			'requestparameters'          => 'requestparameters',
			'invoiceid'                  => 'invoiceid',
			'tariffcomprequeststatuslid' => 'tcr_status',
			'isactive'                   => 'isactive',
			'isprolong'                  => 'isprolong',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'tariffs'                              => [
		'scheme'     => 'public',
		'EntityName' => 'TariffOld',
		'mapping'    => [
			'tariffid'    => 'id',
			'name'        => 'name',
			'description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'tariff_request_types'                 => [
		'scheme'     => 'handbook',
		'EntityName' => 'TariffRequestStateOld',
		'mapping'    => [
			'tariff_request_type_id'          => 'id',
			'tariff_request_type_value'       => 'value',
			'tariff_request_type_description' => 'description',
			'tariff_request_type_constant'    => 'constant',
			'tariff_request_type_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'tariffs_prices'                       => [
		'scheme'     => 'public',
		'EntityName' => 'TariffsPriceOld',
		'mapping'    => [
			'tariffpriceid' => 'id',
			'tariffid'      => 'tariffId',
			'name'          => 'name',
			'period'        => 'period',
			'price'         => 'price',
			'isactive'      => 'isActive',
			'ispublic'      => 'isPublic',
		],
		'namespace'  => 'MP\\Business\\Entities\\Finance',
	],
	'bid_question_states'                  => [
		'scheme'     => 'handbook',
		'EntityName' => 'BidQuestionStatus',
		'mapping'    => [
			'bid_question_state_id'          => 'id',
			'bid_question_state_value'       => 'name',
			'bid_question_state_description' => 'description',
			'bid_question_state_constant'    => 'constant',
			'bid_question_state_order'       => 'order',
			'bid_question_state_data'        => 'data',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'categories'                           => [
		'scheme'     => 'handbook',
		'EntityName' => 'Category',
		'mapping'    => [
			'category_id'          => 'id',
			'category_name'        => 'name',
			'category_description' => 'description',
			'category_any_field'   => 'anyField',
			'category_parent_id'   => 'parentId',
			'category_is_active'   => 'isActive',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'currencies'                           => [
		'scheme'     => 'handbook',
		'EntityName' => 'Currency',
		'mapping'    => [
			'currency_id'           => 'id',
			'currency_name'         => 'name',
			'currency_short_name'   => 'shortName',
			'currency_abbreviation' => 'abbreviation',
			'currency_code'         => 'code',
			'currency_symbol'       => 'symbol',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'delivery_entities'                    => [
		'scheme'     => 'handbook',
		'EntityName' => 'DeliveryEntity',
		'mapping'    => [
			'delivery_entity_id'        => 'id',
			'delivery_entity_name'      => 'name',
			'delivery_entity_full_name' => 'fullName',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'legal_forms'                          => [
		'scheme'     => 'handbook',
		'EntityName' => 'LegalForm',
		'mapping'    => [
			'legal_form_id'          => 'id',
			'legal_form_value'       => 'abbreviation',
			'legal_form_constant'    => 'constant',
			'legal_form_description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'lot_attributes'                       => [
		'scheme'     => 'handbook',
		'EntityName' => 'LotAttribute',
		'mapping'    => [
			'lot_attribute_id'       => 'id',
			'lot_attribute_name'     => 'name',
			'lot_attribute_constant' => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'measure_units'                        => [
		'scheme'     => 'handbook',
		'EntityName' => 'MeasureUnit',
		'mapping'    => [
			'measure_unit_id'          => 'id',
			'measure_unit_name'        => 'name',
			'measure_unit_description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'rating_statuss'                       => [
		'scheme'     => 'handbook',
		'EntityName' => 'RatingStatus',
		'mapping'    => [
			'rating_status_id'          => 'id',
			'rating_status_value'       => 'name',
			'rating_status_description' => 'description',
			'rating_status_constant'    => 'constant',
			'rating_status_order'       => 'order',
			'rating_status_data'        => 'data',
		],
		'namespace'  => 'MP\\Business\\Entities\\Handbook',
	],
	'authentication_tokens'                => [
		'scheme'     => 'membership',
		'EntityName' => 'AuthToken',
		'mapping'    => [
			'authentication_token_id'     => 'id',
			'authentication_token_type'   => 'type',
			'authentication_token_date'   => 'date',
			'authentication_token_expire' => 'expire',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'companies'                            => [
		'scheme'     => 'membership',
		'EntityName' => 'Company',
		'mapping'    => [
			'company_id'                => 'id',
			'company_name'              => 'name',
			'company_registration_date' => 'registrationDate',
			'company_is_active'         => 'isActive',
			'company_identity'          => 'identity',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'companies_data'                       => [
		'scheme'     => 'membership',
		'EntityName' => 'CompanyData',
		'mapping'    => [
			'company_data_id'           => 'id',
			'company_data_account_info' => 'bankAccountNumber',
			'company_data_bic'          => 'bankIdentityCode',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'persons'                              => [
		'scheme'     => 'membership',
		'EntityName' => 'Person',
		'mapping'    => [
			'person_id'           => 'id',
			'person_first_name'   => 'firstName',
			'person_last_name'    => 'lastName',
			'person_email'        => 'email',
			'person_password'     => 'password',
			'person_identity'     => 'identity',
			'person_is_active'    => 'isActive',
			'person_metadata'     => 'metaData',
			'person_metadata_old' => 'metaDataOld',
			'person_permissions'  => 'Permissions',
			'person_admissions'   => 'Admissions',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'comp_empl_contacts'                   => [
		'scheme'     => 'public',
		'EntityName' => 'PersonContactOld',
		'mapping'    => [
			'contactid'   => 'id',
			'empid'       => 'empid',
			'contactlid'  => 'contactlid',
			'contact'     => 'contact',
			'isactive'    => 'isActive',
			'isconfirmed' => 'isConfirmed',
			'isprivate'   => 'isPrivate',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'contact_types'                        => [
		'scheme'     => 'handbook',
		'EntityName' => 'PersonContactTypeOld',
		'mapping'    => [
			'contact_type_id'          => 'id',
			'contact_type_value'       => 'value',
			'contact_type_description' => 'description',
			'contact_type_constant'    => 'constant',
			'contact_type_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'users'                                => [
		'scheme'     => 'membership',
		'EntityName' => 'User',
		'mapping'    => [
			'user_id'    => 'id',
			'user_title' => 'title',
		],
		'namespace'  => 'MP\\Business\\Entities\\Membership',
	],
	'monitor_event_types'         => [
		'scheme'     => 'handbook',
		'EntityName' => 'MonitorEventTypeOld',
		'mapping'    => [
			'monitor_event_type_id'          => 'id',
			'monitor_event_type_name'        => 'name',
			'monitor_event_type_constant'    => 'constant',
			'monitor_event_type_description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notification_channels'   => [
		'scheme'     => 'notification',
		'EntityName' => 'NotificationChannel',
		'mapping'    => [
			'notification_channel_id'       => 'id',
			'notification_channel_name'     => 'name',
			'notification_channel_constant' => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'message_types'                        => [
		'scheme'     => 'handbook',
		'EntityName' => 'NotificationChannelOld',
		'mapping'    => [
			'message_type_id'          => 'id',
			'message_type_value'       => 'name',
			'message_type_constant'    => 'constant',
			'message_type_description' => 'description',
			'message_type_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notification_deliverers' => [
		'scheme'     => 'notification',
		'EntityName' => 'NotificationDeliverer',
		'mapping'    => [
			'notification_deliverer_id'       => 'id',
			'notification_deliverer_name'     => 'name',
			'notification_deliverer_constant' => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notification_methods'    => [
		'scheme'     => 'notification',
		'EntityName' => 'NotificationMethod',
		'mapping'    => [
			'notification_method_id'            => 'id',
			'notification_method_placeholder'   => 'placeholder',
			'notification_method_has_templates' => 'hasTemplates',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notification_types'      => [
		'scheme'     => 'notification',
		'EntityName' => 'NotificationType',
		'mapping'    => [
			'notification_type_id'          => 'id',
			'notification_type_name'        => 'name',
			'notification_type_constant'    => 'constant',
			'notification_type_description' => 'description',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notif2_subscription_events'           => [
		'scheme'     => 'public',
		'EntityName' => 'SubscriptionEventOld',
		'mapping'    => [
			'subscriptioneventid' => 'id',
			'subsciptionid'       => 'subscriptionId',
			'notifyeventnamelid'  => 'subscriptionEventTypeId',
			'isactive'            => 'isActive',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notification_services'                => [
		'scheme'     => 'handbook',
		'EntityName' => 'SubscriptionEventTypeOld',
		'mapping'    => [
			'notification_service_id'          => 'id',
			'notification_service_value'       => 'value',
			'notification_service_description' => 'description',
			'notification_service_constant'    => 'constant',
			'notification_service_order'       => 'order',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'notif2_subscriptions'                 => [
		'scheme'     => 'public',
		'EntityName' => 'SubscriptionOld',
		'mapping'    => [
			'subscriptionid'          => 'id',
			'address'                 => 'emailAddress',
			'activcode'               => 'activationCode',
			'isactive'                => 'isActive',
			'empid'                   => 'empid',
			'deliveryprotocoltypelid' => 'channelId',
		],
		'namespace'  => 'MP\\Business\\Entities\\Notification',
	],
	'monitor_events'                => [
		'scheme'     => 'public',
		'EntityName' => 'MonitorEventOld',
		'mapping'    => [
			'monitoreventid'  => 'id',
			'monitoreventlid' => 'monitoreventlid',
			'objid'           => 'objid',
			'results'         => 'results',
			'processstatus '  => 'processstatus',
			'insertdate'      => 'insertdate',
			'updatedate'      => 'updatedate',
		],
		'namespace'  => 'MP\\Business\\Entities\\Old',
	],
	'referrals'                            => [
		'scheme'     => 'public',
		'EntityName' => 'Referral',
		'mapping'    => [
			'referral_id'   => 'id',
			'referral_date' => 'date',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
	'admissions'                           => [
		'scheme'     => 'rights',
		'EntityName' => 'Admission',
		'mapping'    => [
			'admission_id'                    => 'id',
			'admission_name'                  => 'name',
			'admission_description'           => 'description',
			'admission_constant'              => 'constant',
			'admission_log_level'             => 'logLevel',
			'admission_functionalities_count' => 'functionalitiesCount',
			'admission_companies_count'       => 'companiesCount',
			'admission_persons_count'         => 'personsCount',
			'admission_usage_count'           => 'usageCount',
			'admission_functionalities'       => 'Functionalities',
			'admission_exclusions'            => 'Exclusions',
			'admission_delegations'           => 'Delegations',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'admission_delegation'          => [
		'scheme'     => 'rights',
		'EntityName' => 'AdmissionDelegation',
		'mapping'    => [
			'admission_id_delegation' => 'delegation',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'admission_functionalities'     => [
		'scheme'     => 'rights',
		'EntityName' => 'AdmissionFunctionality',
		'mapping'    => [
			'admission_id'     => 'functionalityId',
			'functionality_id' => 'admissionId',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'functionalities'               => [
		'scheme'     => 'rights',
		'EntityName' => 'Functionality',
		'mapping'    => [
			'functionality_id'          => 'id',
			'functionality_name'        => 'name',
			'functionality_description' => 'description',
			'functionality_constant'    => 'constant',
			'functionality_permissions' => 'Permissions',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'functionality_permissions'     => [
		'scheme'     => 'rights',
		'EntityName' => 'FunctionalityPermission',
		'mapping'    => [
			'functionality_id' => 'functionalityId',
			'permission_id'    => 'permissionId',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'permissions'                          => [
		'scheme'     => 'rights',
		'EntityName' => 'Permission',
		'mapping'    => [
			'permission_id'          => 'id',
			'permission_name'        => 'constant',
			'permission_description' => 'description',
			'permission_title'       => 'title',
			'permission_is_active'   => 'isActive',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'roles_exclusions'                     => [
		'scheme'     => 'rights',
		'EntityName' => 'RolesExclusion',
		'mapping'    => [
			'user_id'       => 'userId',
			'permission_id' => 'permissionId',
		],
		'namespace'  => 'MP\\Business\\Entities\\Rights',
	],
	'sessions'                             => [
		'scheme'     => 'public',
		'EntityName' => 'SessionOld',
		'mapping'    => [
			'session_id'               => 'id',
			'session_key'              => 'key',
			'session_create_time'      => 'createTime',
			'session_ip'               => 'ipAddress',
			'session_last_action_time' => 'lastActionTime',
			'session_device'           => 'device',
			'session_ga'               => 'googleAnalytics',
			'session_gid'              => 'googleAnalyticsId',
			'session_fingerprint'      => 'fingerprint',
			'session_signed_in_by'     => 'signedInBy',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
	'tenders_new'                          => [
		'scheme'     => 'tender',
		'EntityName' => 'Tender',
		'mapping'    => [
			'tender_id'               => 'id',
			'tender_name'             => 'name',
			'tender_date_publication' => 'datePublication',
			'tender_is_active'        => 'isActive',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
	'tender_lots'                          => [
		'scheme'     => 'tender',
		'EntityName' => 'TenderLot',
		'mapping'    => [
			'tender_lot_id'                => 'id',
			'tender_lot_name'              => 'name',
			'tender_lot_description'       => 'description',
			'tender_lot_budget'            => 'budgetPerItem',
			'tender_lot_quantity'          => 'quantity',
			'tender_lot_date_start'        => 'dateStart',
			'tender_lot_date_stop'         => 'dateStop',
			'tender_lot_fts'               => 'fullTextSearch',
			'tender_lot_is_active'         => 'isActive',
			'tender_lot_state_explanation' => 'stateExplanation',
			'tender_lot_type_id'           => 'typeId',
			'tender_lot_state_id'          => 'stateId',
			'tender_lot_is_public'         => 'isPublic',
			'tender_lot_date_commit'       => 'dateCommit',
			'tender_id'                    => 'tenderId',
			'delivery_entity_id'           => 'deliveryEntityId',
			'category_id'                  => 'categoryId',
			'currency_id'                  => 'currencyId',
			'measure_unit_id'              => 'measureUnitId',
			'initiator_company_id'         => 'initiatorCompanyId',
			'initiator_user_id'            => 'initiatorUserId',
			'tender_lot_any_field'         => 'anyField',
			'tender_lot_bids_count'        => 'bidsCount',
			'tender_lot_volume'            => 'volume',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
	'tender_lot_options'                   => [
		'scheme'     => 'tender',
		'EntityName' => 'TenderLotOption',
		'mapping'    => [
			'tender_lot_option_id'           => 'id',
			'tender_lot_option_name'         => 'name',
			'tender_lot_option_description'  => 'description',
			'tender_lot_option_constant'     => 'constant',
			'tender_lot_option_value_type'   => 'valueType',
			'tender_lot_option_value'        => 'value',
			'tender_lot_option_old_constant' => 'oldConstant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Tender',
	],
	'tender_lot_states'                    => [
		'scheme'     => 'tender',
		'EntityName' => 'TenderLotState',
		'mapping'    => [
			'tender_lot_state_id'          => 'id',
			'tender_lot_state_name'        => 'name',
			'tender_lot_state_description' => 'description',
			'tender_lot_state_constant'    => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Tender',
	],
	'tender_lot_types'                     => [
		'scheme'     => 'tender',
		'EntityName' => 'TenderLotType',
		'mapping'    => [
			'tender_lot_type_id'          => 'id',
			'tender_lot_type_name'        => 'name',
			'tender_lot_type_description' => 'description',
			'tender_lot_type_constant'    => 'constant',
		],
		'namespace'  => 'MP\\Business\\Entities\\Tender',
	],
	'test'                                 => [
		'scheme'     => 'public',
		'EntityName' => 'Test',
		'mapping'    => [
			'agent_id'       => 'id',
			'agent_name'     => 'name',
			'agent_metadata' => 'metadata',
			'agent_identity' => 'constant',
			'my_name is'     => 'test',
		],
		'namespace'  => 'MP\\Business\\Entities',
	],
];