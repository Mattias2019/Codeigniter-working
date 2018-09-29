<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['roles'] = array(

    ROLE_GUEST => array(
        'name' => 'guest',
        'url' => '/home/index'
    ),

    ROLE_ENTREPRENEUR => array(
        'parent' => ROLE_GUEST,
        'name' => 'entrepreneur',
        'url' => '/account'
    ),

    ROLE_PROVIDER => array(
        'parent' => ROLE_GUEST,
        'name' => 'provider',
        'url' => '/account'
    ),

    ROLE_ADMIN => array(
        'parent' => ROLE_GUEST,
        'name' => 'admin',
        'url' => '/admin/users/viewUsers'
    ),

    ROLE_ROOT => array(
        'parent' => ROLE_ADMIN,
        'name' => 'super-administrator',
        'url' => '/account'
    ),

    ROLE_CRON => array(
        'name' => 'cron',
        'url' => '/home/index'
    ),
);

$config['acl'] = array(

    'guest_menu' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ADMIN => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
    ),

    'user_menu' => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'admin/dashboard/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/users/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/siteSettings/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/feedback/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/items/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/earnings/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/emailSettings/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/skills/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/faq/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/paymentSettings/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/packages/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/payments/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/dispute/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/pages/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'admin/safety/*' => array(

        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'cli/email/*' => array(

        'allow' => [
            ROLE_CRON => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'account/*' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
        ],
    ),

    'account/index' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'account/dashboard' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'account/edit' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'account/signup' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
        ],
        'deny' => [
//			ROLE_PROVIDER => [GRANT_READ],
//			ROLE_ENTREPRENEUR => [GRANT_READ],
//			ROLE_ADMIN => [GRANT_READ],
        ],
    ),

    'account/invite_supplier' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ADMIN => [GRANT_READ],
        ],
    ),

    'account/favorite_members' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_ADMIN => [GRANT_READ],
        ],
    ),

    'account/banned_members' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_ADMIN => [GRANT_READ],
        ],
    ),

    'account/login' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
        ],
        'deny' => [
//			ROLE_ADMIN => [GRANT_READ, GRANT_WRITE],
//			ROLE_PROVIDER => [GRANT_READ],
//			ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
    ),

    'account/logout' => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ, GRANT_WRITE],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    'bookmark/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'cancel/*' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'chat/*' => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
        'deny' => [
        ],
    ),

    'file/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/index' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/spending' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/revenue' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/invoice' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/invoice_csv' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/invoice_print' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/tax' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/tax_csv' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/deposit' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/transfer' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/withdraw' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/escrow' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/send_reminder' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    /*'finance/escrow' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
		'assert' => 'EscrowAssertion',
    ),*/

    'finance/paypal_return' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/invoice_all_pdf' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/invoice_pdf' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/exportInvoiceToExcelAction' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/exportTaxToExcelAction' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/get_escrow_total' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/get_project_info' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'finance/get_milestone_info' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'home/*' => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [

        ],
    ),

    'home/index' => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_CRON => [GRANT_READ]
        ],
        'deny' => [

        ],
    ),

    'information/*' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [],
    ),

    'messages/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'offline/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
        'deny' => [
        ],
    ),

    'payment/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'portfolio/*' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'portfolio/manage' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),
    'portfolio/get_standard_items' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),


    'project/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/assign_quote' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/accept_quote' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/reject_quote' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/tender' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/close' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/close_milestone' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/review' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
			ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'project/create' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
    ),

    'project/reset_form' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
    ),

    'project/invoice' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'provider/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
    ),

    'reports/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],

        ],
    ),

    'rss/*' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
        ],

    ),

    'search/tender' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],

    ),

    'search/employee' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    'search/machinery' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],

    ),

    'search/getSinglePortfolio' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    'search/getNextPortfolio' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    'search/quote_request' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],

    ),

    'search/entrepreneursQuoteRequestDatatable' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    'search/send_quote_request' => array(
        'allow' => [
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
            ROLE_PROVIDER => [GRANT_READ],
        ],

    ),

    'team/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),

    'team/confirm' => array(
        'allow' => [
            ROLE_GUEST => [GRANT_READ],
        ],
    ),


    'transfer/*' => array(
        'allow' => [
            ROLE_PROVIDER => [GRANT_READ],
            ROLE_ENTREPRENEUR => [GRANT_READ],
        ],
        'deny' => [
            ROLE_GUEST => [GRANT_READ],
        ],

    ),

    ROLE_ADMIN => array(
        'allow' => [
            ROLE_ADMIN => [GRANT_READ],
        ],
    ),

    ROLE_ROOT => array(
        'allow' => [
            ROLE_ROOT => [GRANT_READ],
        ],
    ),
);