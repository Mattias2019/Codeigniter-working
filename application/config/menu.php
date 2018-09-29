<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['menu'] = array(

	// ---------- Top Menu (Landing Page) ------------
	"top" => array(

		"signup" => array(
			"label" => "Sign Up",
			'resource' => "guest_menu",
			'url' => "account/signup",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "signup.png",
			'order' => 2,
			'hide' => false,
		),

		"post_project" => array(
			"label" => "Post Project",
			'resource' => "project/create",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "post-projt.png",
			'order' => 2,
			'hide' => false,
		),

		"find_project" => array(
			"label" => "Find Project",
			'resource' => "search/tender",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "acnt-pjct.png",
			'order' => 2,
			'hide' => false,
		),

		"project_feeds" => array(
			"label" => "Project Feeds",
			'resource' => "rss/index",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "acnt-feed.png",
			'order' => 3,
			'hide' => false,
		),

		"login" => array(
			"label" => "Sign In",
            'resource' => "guest_menu",
			'url' => "account/login",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "login-icon.png",
			'order' => 4,
			'hide' => false,
		),

		"account" => array(
			"label" => "Account",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'cls_signup-icon',
			'src' => "acount.png",
			'order' => 4,
			'hide' => false,
			"items" => array(

				"account" => array(
					"label" => "Welcome, <em>&username</em>",
					'resource' => "account/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"dashboard" => array(
					"label" => "Dashboard",
					'resource' => "account/dashboard",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
				),

				"admin_dashboard" => array(
					"label" => "Dashboard",
					'resource' => "admin/users/viewUsers",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
				),

				"logout" => array(
					"label" => "Sign Out",
					'resource' => "account/logout",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
				),

			)
		),

	),

	// --------------- Sidebar Menu ------------------
	"sidebar" => array(

		/* Admin */

		"admin_dashboard" => array (
			"label" => "Dashboard",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-home',
			'order' => 1,
			'hide' => false,
			"items" => array(

				"marketing_dashboard" => array (
					"label" => "Marketing Dashboard",
					'resource' => "admin/dashboard/marketingDashboard",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"financial_dashboard" => array (
					"label" => "Financial Dashboard",
					'resource' => "admin/dashboard/marketingDashboard",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"quality_dashboard" => array (
					"label" => "Quality Dashboard",
					'resource' => "admin/dashboard/marketingDashboard",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"system_dashboard" => array (
					"label" => "System Dashboard",
					'resource' => "admin/dashboard/marketingDashboard",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),
			),
		),

		"user_management" => array (
			"label" => "User Management",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-puzzle',
			'order' => 2,
			'hide' => false,
			"items" => array(

				"view_users" => array (
					"label" => "View Users",
					'resource' => "admin/users/viewUsers",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

                "view_bans" => array (
                    "label" => "View Bans",
                    'resource' => "admin/users/viewBans",
                    'privilege' => GRANT_READ,
                    'icon_class' => '',
                    'order' => 2,
                    'hide' => false,
                ),

//                "view_suspend" => array (
//                    "label" => "View Suspended Users",
//                    'resource' => "admin/users/viewSuspend",
//                    'privilege' => GRANT_READ,
//                    'icon_class' => '',
//                    'order' => 3,
//                    'hide' => false,
//                ),
			),
		),

		"site_administration" => array (
			"label" => "Site Administration",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-diamond',
			'order' => 3,
			'hide' => false,
			"items" => array(

				"site_settings" => array (
					"label" => "Site settings",
					'resource' => "admin/siteSettings/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"email_manager" => array (
					"label" => "Email template manager",
					'resource' => "admin/emailSettings/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
				),

				"groups" => array (
					"label" => "Groups",
					'resource' => "admin/skills/viewGroups",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 4,
					'hide' => false,
				),

				"categories" => array (
					"label" => "Categories",
					'resource' => "admin/skills/viewCategories",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
					'hide' => false,
				),

				"projects" => array (
					"label" => "Tender/projects",
					'resource' => "admin/skills/viewJobs",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 6,
					'hide' => false,
				),

				"quotation_manager" => array (
					"label" => "Quotation Manager",
					'resource' => "admin/skills/viewQuotes",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 7,
					'hide' => false,
				),

				"faq" => array (
					"label" => "FAQ",
					'resource' => "admin/faq/viewFaqs",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 8,
					'hide' => false,
				),

                "feedback" => array (
                    "label" => "Feedback",
                    'resource' => "admin/feedback/viewFeedbacks",
                    'privilege' => GRANT_READ,
                    'icon_class' => '',
                    'order' => 9,
                    'hide' => false,
                ),

                "items" => array (
                    "label" => "Manage items",
                    'resource' => "admin/items/viewItems",
                    'privilege' => GRANT_READ,
                    'icon_class' => '',
                    'order' => 10,
                    'hide' => false,
                ),
			),
		),

		"financial_manager" => array (
			"label" => "Financial Manager",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'fa fa-money',
			'order' => 3,
			'hide' => false,
			"items" => array(

				"payment_manager" => array (
					"label" => "Payment manager",
					'resource' => "admin/paymentSettings/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"pricing_cockpit" => array (
					"label" => "Pricing Cockpit",
					'resource' => "admin/paymentSettings/pricingCockpit",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
				),

				"escrow_fee" => array (
					"label" => "Escrow Fee",
					'resource' => "admin/paymentSettings/escrowFee",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
				),

				"platform_fee" => array (
					"label" => "Platform Fee",
					'resource' => "admin/paymentSettings/platformFee",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 4,
					'hide' => false,
				),

				"payment_packages" => array (
					"label" => "Payment Packages & Offers",
					'resource' => "",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
					'hide' => false,
					"items" => array(

						"view_packages" => array (
							"label" => "View Packages",
							'resource' => "admin/packages/viewPackages",
							'privilege' => GRANT_READ,
							'icon_class' => '',
							'order' => 1,
							'additional_resources' => [
								"admin/packages/addPackages",
								"admin/packages/editPackage"
							],
							'hide' => false,
						),

						"membership_management" => array (
							"label" => "Membership Management",
							'resource' => "admin/packages/viewSubscriptionUser",
							'privilege' => GRANT_READ,
							'icon_class' => '',
							'order' => 2,
							'hide' => false,
						),

						"subscription_payment" => array (
							"label" => "Subscription Payment",
							'resource' => "admin/packages/viewSubscriptionPayment",
							'privilege' => GRANT_READ,
							'icon_class' => '',
							'order' => 3,
							'hide' => false,
						),
					),
				),

				"transactions" => array (
					"label" => "Transaction manager",
					'resource' => "admin/payments/transaction",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 4,
					'hide' => false,
				),

				"legal" => array (
					"label" => "Legal",
					'resource' => "",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
					'hide' => false,
					"items" => array(

						"vat" => array (
							"label" => "VAT compliance matrix",
							'resource' => "admin/payments/vat",
							'privilege' => GRANT_READ,
							'icon_class' => '',
							'order' => 1,
							'hide' => false,
						),

						"import" => array (
							"label" => "Import tax compliance matrix",
							'resource' => "admin/payments/import",
							'privilege' => GRANT_READ,
							'icon_class' => '',
							'order' => 2,
							'hide' => false,
						),

					)
				),

				"earnings" => array (
					"label" => "Earnings",
					'resource' => "admin/earnings/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 6,
					'hide' => false,
				),
			),
		),

		"dispute_mamager" => array(
			"label" => "DISPUTE MANAGEMENT",
			'resource' => "admin/dispute/index",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/messages",
			'order' => 5,
			'hide' => false,
		),

		"page_manager" => array(
			"label" => "STATIC PAGE MANAGEMENT",
			'resource' => "admin/pages/index",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/quotes",
			'order' => 6,
			'hide' => false,
		),

		"safety_cockpit" => array(
			"label" => "SAFETY COCKPIT",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'fa fa-shield',
			'order' => 7,
			'hide' => false,
			"items" => array(

				"vat" => array (
					"label" => "Failed logins",
					'resource' => "admin/safety/failed_logins",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

			)
		),

		/* User */

		"dashboard" => array(
			"label" => "DASHBOARD",
			'resource' => "account/dashboard",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/dashboard",
			'order' => 1,
			'hide' => false,
		),

		"tender" => array(
			"label" => "TENDER",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/search",
			'order' => 3,
			'hide' => false,
			"items" => array(

				"search" => array(
					"label" => "Search machinery",
					'resource' => "search/machinery",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
				),

				"invite" => array(
					"label" => "Invite your machine supplier",
					'resource' => "account/invite_supplier",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
				),

				"new_machine_tender" => array(
					"label" => "New Machine tender",
					'resource' => "project/create",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
				),

				"file_manager" => array(
					"label" => "File Manager",
					'resource' => "file",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 4,
					'hide' => false,
				),

				"tender_overview" => array(
					"label" => "Tender overview",
					'resource' => "project/tender",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
					'hide' => false,
					'badge_data' => 'count_tender_projects',
				),

				"quote_requests" => array(
					"label" => "Quote requests",
					'resource' => "search/quote_request",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 6,
					'hide' => false,
					'badge_data' => 'count_quote_requests',
				),

				"search_tender" => array(
					"label" => "Find suitable tender",
					'resource' => "search/tender",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 7,
					'hide' => false,
					'badge_data' => 'count_new_projects',
				),

				"rss" => array(
					"label" => "RSS Feeds",
					'resource' => "rss/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 8,
					'hide' => false,
				),
			)
		),

		"quote" => array(
			"label" => "QUOTE",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/quotes",
			'order' => 4,
			'hide' => false,
			"items" => array(

				"pending_quotes" => array(
					"label" => "Pending quotes",
					'resource' => "project/list/3",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
					'badge_data' => 'count_pending_quotes',
				),

				"won_projects" => array(
					"label" => "Won projects",
					'resource' => "project/list/2",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
					'badge_data' => 'count_won_quotes',
				),
			)
		),

		"projects" => array(
			"label" => "PROJECTS",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/projects",
			'order' => 4,
			'hide' => false,
			"items" => array(

				"my_projects" => array(
					"label" => "My projects",
					'resource' => "project/project_list",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false,
					'badge_data' => 'count_active_projects',
				),

				"file_manager" => array(
					"label" => "File manager",
					'resource' => "file/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false,
				),

				"dispute_manager" => array(
					"label" => "Dispute manager",
					'resource' => "cancel/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false,
					'badge_data' => 'count_disputes',
				),
			)
		),

		"messages" => array(
			"label" => "MESSAGES",
			'resource' => "messages/index",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/messages",
			'order' => 9,
			'hide' => false,
			'badge_data' => 'count_unread_messages',
		),

		"finance" => array(
			"label" => "PAYMENTS",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/payments",
			'order' => 7,
			'hide' => false,
			"items" => array(
				"spending_calendar" => array(
					"label" => "Spending Calendar",
					'resource' => "finance/spending",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false
				),
				"revenue_calendar" => array(
					"label" => "Revenue Calendar",
					'resource' => "finance/revenue",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
				),
				"invoices" => array(
					"label" => "Invoices",
					'resource' => "finance/invoice",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false
				),
				"tax" => array(
					"label" => "Tax manager",
					'resource' => "finance/tax",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false
				),
				"deposit" => array(
					"label" => "Deposit",
					'resource' => "finance/deposit",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 4,
				),
				"transfer" => array(
					"label" => "Transfer",
					'resource' => "finance/transfer",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
				),
				"withdraw" => array(
					"label" => "Withdraw",
					'resource' => "finance/withdraw",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 6,
				),
				"escrow" => array(
					"label" => "Escrow",
					'resource' => "finance/escrow",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 7,
				),
			)
		),

		"account" => array(
			"label" => "ACCOUNT",
			'resource' => "",
			'privilege' => GRANT_READ,
			'icon_class' => 'icon-svg-img',
			'src' => "menu/account",
			'order' => 10,
			'hide' => false,
			"items" => array(
				"my_account" => array(
					"label" => "My Account",
					'resource' => "account/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false
				),
				"account_settings" => array(
					"label" => "Account settings",
					'resource' => "account/edit",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false
				),
				"machine_portfolio" => array(
					"label" => "Machine Portfolio Manager",
					'resource' => "portfolio/manage",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 3,
					'hide' => false
				),
				"team_member" => array(
					"label" => "Team members",
					'resource' => "team/index",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 1,
					'hide' => false
				),
				"group_permissions" => array(
					"label" => "Group permissions",
					'resource' => "team/groups",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 2,
					'hide' => false
				),
				"favorite_members" => array(
					"label" => "Favorite Members",
					'resource' => "account/favorite_members",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 5,
					'hide' => false
				),
				"banned_members" => array(
					"label" => "Banned Members",
					'resource' => "account/banned_members",
					'privilege' => GRANT_READ,
					'icon_class' => '',
					'order' => 6,
					'hide' => false
				),
			),
		),
	),
);